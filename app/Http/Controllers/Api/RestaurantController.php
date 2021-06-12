<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RestaurantController extends Controller
{

    /**
     * RestaurantController constructor.
     */
    public function __construct()
    {
    }

    public function show(){
        $restaurant=Restaurant::first()->makeHidden('image');;
        $time=Carbon::now()->toTimeString();
        $day=Carbon::now()->format('l');
        $status='closed';
        if($this->checkRestaurantIfOpenInHours($restaurant,$time) && $this->checkRestaurantIfOpenInDys($restaurant,$day))
            $status='open';

        $imgae=$restaurant->image;
        if($imgae)
        return response()->json(['msg'=>'Restaurant Received','Restaurant'=>$restaurant,'status'=>$status,'logo'=>$imgae['image_url']],200,[],JSON_NUMERIC_CHECK);
        return response()->json(['msg'=>'Restaurant Received','Restaurant'=>$restaurant,'status'=>$status,'logo'=>null],200,[],JSON_NUMERIC_CHECK);
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
    protected function checkRestaurantIfOpenInHours($restaurant,$time){
        $open_time=$restaurant->open_time;
        $close_time=$restaurant->close_time;
        $open_date=new \DateTime($open_time);
        $close_date=new \DateTime($close_time);
        $time_date=new \DateTime($time);
        if($time_date>=$open_date && $time_date<=$close_date)
            return true;
        return false;
    }
}
