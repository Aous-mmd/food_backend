<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\Category;
use App\Models\DeliveryAddress;
use App\models\Discount;
use App\Models\Extra;
use App\Models\Food;
use App\Models\FoodOption;
use App\models\FoodOptionExtra;
use App\Models\Option;
use App\Models\Order;
use App\Models\OrderDetail;
use App\models\OrderDetailExtra;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;
use function PHPUnit\Framework\isEmpty;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store', 'checkRestaurantIfOpenInDys', 'check'
            , 'checkRestaurantIfOpenInHours','status']]);
    }

    public function index()
    {
        $orders = Order::where('is_deleted', 0)->orderBy('created_at','DESC')->get();
        return response()->json(['orders' => $orders], 200);
    }

    public function change(Request $request)
    {
        $status = $request->get('status');
        $id = $request->get('id');
        $order=Order::findOrFail($id);
        $details['title']='Dear '.$order['customer_name'].': ';
        $details['body']='Your Order : 
        ';
        $order_details=OrderDetail::where('order_id',$id)->pluck('id');
        $food_options=OrderDetail::where('order_id',$id)->pluck('food_option_id');
        $options=FoodOption::whereIn('id',$food_options)->pluck('option_id');
        $quantity=OrderDetail::where('order_id',$id)->pluck('quantity');

        for($i=0;$i<sizeof($food_options);$i++){
            $extras_id=OrderDetailExtra::where('order_detail_id',$order_details[$i])->pluck('extra_id');
            $extras_quantity=OrderDetailExtra::where('order_detail_id',$order_details[$i])->pluck('quantity');
            $option=Option::findOrFail($options[$i]);
            $details['body'].=$quantity[$i].'  '.$option['name'];
            if(sizeof($extras_id)>0){
                $details['body'].= ' with extras : 
             ';
            }
            for($j=0;$j<sizeof($extras_id);$j++){
                $extra=Extra::findOrFail($extras_id[$j]);
                $details['body'].=($j+1).'_ '.$extras_quantity[$j]. '  ' .$extra['name'].'
                ';
            }
        }
        $details['body'].='
        With total price '.$order['total_price'];
        $details['body'].=' has been '.$status.'ed';
        Mail::to($order['customer_email'])->send(new OrderMail($details));
        if( count(Mail::failures()) > 0 ) {
            return response()->json(['msg'=>'server error please try again'],500);
        }
        Order::where('id', $id)->update(['status' => $status]);
        return response()->json(['msg' => 'Order has been ' . $status . 'ed successfully'], 200);

    }

    public function store(Request $request)
    {
        $form = $request->get('form');
        $order_data = array();
        $valid = Validator::make($form, [
            'full_name' => 'required|string|min:5',
            'email' => 'required|email',
            'phone' => 'required',
            'city' => 'nullable',
            //'order_type' => 'required|in:delivery,table_reservation,daily_order',
            'date' => 'required|date_format:Y-m-d H:i',
        ]);
        if ($valid->fails()) {
            return response()->json([['msg' => 'Order failed', 'errors' => $valid->errors()->all()]], 422);
        }
        $order=$request->get('order');
        $valid2 =Validator::make($order,[
          '*.food_id'=>'required|exists:food,id',
            '*.size_id'=>'required|exists:options,id',
            '*.quantity'=>'required|numeric',
            //'*.extras'=>'required',
            '*.extras.*.extra_id'=>'required|exists:extras,id'
        ]);
        if ($valid2->fails()) {
            return response()->json([['msg' => 'Order failed', 'errors' => $valid2->errors()->all()]], 422);
        }
        $date_time=$form['date'];
        if ($form['city'] != 'Abholung'&& is_numeric($form['city'])) {
            $city=DeliveryAddress::where('id',$form['city'])->first();
            if(!$city){
                return response()->json([['msg' => 'Order failed', 'errors' => ['error in city']]], 422);
            }
            $order_data = ['delivery_address_id' => $form['city'],
                'customer_name' => $form['full_name'],
                'customer_phone' => $form['phone'],
                'customer_email' => $form['email'],
                'started_at' =>  $date_time,
                'type' =>'delivery'
            ];
        } else if ($form['city']=='Abholung') {
            $order_data = ['customer_name' => $form['full_name'],
                'customer_phone' => $form['phone'],
                'customer_email' => $form['email'],
                'started_at' =>$date_time,
                'type' =>'daily_order'
            ];
        }
        else{
            return response()->json([['msg' => 'Order failed', 'errors' => ['error in city']]], 422);
        }
        $restaurant = Restaurant::first();
        $day=new \DateTime($date_time);
        $day=$day->format('l');
        if ($this->checkRestaurantIfOpenInDys($restaurant,$day) && $this->checkRestaurantIfOpenInHours($restaurant ,$date_time) ) {
            $order = Order::create($order_data);
            $orders = $request->get('order');
            $price = 0.00;
            foreach ($orders as $o) {
                $food_option = FoodOption::where('food_id', $o['food_id'])->where('option_id', $o['size_id'])->first();
                $cat_id = Food::where('id', $o['food_id'])->first();
                $day = Carbon::now()->format('l');
                $discount = Discount::where('category_id', $cat_id['category_id'])->where('day', $day)->get()->sum('amount');
                $details = ['order_id' => $order->id,
                    'food_option_id' => $food_option->id,
                    'quantity' => $o['quantity'],
                    'price' => $o['quantity'] * $food_option->price
                ];
                $price += $details['price'] - (($discount * $details['price']) / 100);
                $details['price']=$price;
                $order_details = OrderDetail::create($details);
                $extras = $o['extras'];
                $i =0;
                foreach ($extras as $e) {
                    $extra=Extra::find($e['extra_id']);
                    $extra_food_option = FoodOptionExtra::where('food_option_id', $food_option->id)->where('extra_id', $e['extra_id'])->first();
                    $p=$o['quantity'] * $extra['price'];
                    $order_extra = [
                        'order_detail_id' => $order_details['id'],
                        'extra_id' => $e['extra_id'],
                        'quantity' => $o['quantity'],
                        'price' => $p
                    ];
                    $price += $order_extra['price'];
                    $order_detail_extras = OrderDetailExtra::create($order_extra);
                }

            }
            if ($form['city'] != 'Abholung'&& is_numeric($form['city'])) {
                $delivery_add = DeliveryAddress::where('id', $form['city'])->get(['min_delivery', 'delivery_cost'])->first();
                if ($price < $delivery_add['min_delivery']) {
                    $price += $delivery_add['delivery_cost'];
                }
            }
            if($price<$restaurant['min_order']){
                Order::where('id',$order->id)->delete();
                return response()->json(['msg'=>'sorry your order less than our minimum order price '],422);

            }
            $price=(double)$price;
            $updated_order = Order::where('id', $order->id)->update(['total_price' => $price]);
            $final_price=Order::find($order->id);
            return response()->json(['msg' => 'order has been added successfully', 'order_id' => $order->id, 'total_price' => ((float)$final_price['total_price'])], 200);
        } else {
            return response()->json(['msg' => 'sorry we are closed in this date'], 422);
        }
    }

    public function checkRestaurantIfOpenInDys($restaurant,$day){
        $days=[
            'Saturday',
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
        ];
        $open_index=array_search($restaurant->from_day,$days);
        $close_index=array_search($restaurant->to_day,$days);
        $list_days=array();
        if($open_index<$close_index){
            for($i=$open_index;$i<=$close_index;$i++){
                array_push($list_days,$days[$i]);
            }
        }
        else if($open_index>$close_index){
            for($i=$open_index;$i<7;$i++){
                array_push($list_days,$days[$i]);
            }
            for($i=0;$i<=$close_index;$i++){
                array_push($list_days,$days[$i]);
            }
        }
        else{
            array_push($list_days,$days[$open_index]);
        }
        if(array_search($day,$list_days)==false){
            return false;
        }
        return true;

    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        if ((Hash::check($request->get('password'), $user->password))) {
            Order::where('is_deleted', 0)->update(['is_deleted' => 1]);
            return response()->json('Orders has been deleted successfully', 200);
        } else {
            return response()->json('Wrong password', 422);
        }

    }

    public function clear(Request $request)
    {
        $ids = $request->get('ids');
        $ids = explode(',', $ids);
        foreach ($ids as $id) {
            Order::where('id', $id)->update(['is_deleted' => 1]);
        }
        return response()->json('Orders has been deleted successfully', 200);
    }

    public function get($id)
    {
        $order = Order::where('id', $id)->with('address')->first();
        $foodOptions = OrderDetail::where('order_id', $id)->with(['food_option' => function ($query) {
            $query->select('id', 'option_id')->get();
        }, 'food_option.option' => function ($query) {
            $query->select('id', 'name')->get();
        }, 'extras' => function ($query) {
            $query->select('extras.id', 'extras.name', 'quantity')->get();
        }])->get(['id', 'order_id', 'food_option_id', 'quantity']);
        return response()->json(['foods' => $foodOptions, 'order' => $order], 200);
    }

    protected function checkRestaurantIfOpenInHours($restaurant, $datetime)
    {

        $date=Carbon::parse($datetime)->format('Y-m-d');

        $open_time =$date.$restaurant->open_time;

        $close_time =$date.$restaurant->close_time;
        $open_date = new \DateTime($open_time);
        $close_date = new \DateTime($close_time);
        $time_date=new \DateTime($datetime);
        if ($time_date >= $open_date && $time_date <= $close_date)
            return true;
        return false;

    }
    public function status($id){
        $order=Order::find($id);
        if($order){
            return response()->json(['status'=>$order->status]);
        }
        else{
            return response()->json(['msg'=>'No order for this id '],412);
        }
    }
}
