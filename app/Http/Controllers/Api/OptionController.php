<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Models\Food;
use App\Models\FoodOption;
use App\Models\FoodOptionExtra;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{

    /**
     * OptionController constructor.
     */
    public function __construct()
    {
    }

    public  function show($id){
        $food_options=FoodOption::where('food_id',$id)->pluck('option_id');
        $options=Option::WhereIn('id',$food_options)->with(['foodOptions'=> function ($query){
            $query->select('id','option_id','price')->get();
        },'foodOptions.extras'=>function ($query){
            $query->select('extras.id','extras.name','extras.price')->get();
        }])->get();
        return response()->json(["msg"=>"All Food Options Received",'foodOptions'=>$options],200,[],JSON_NUMERIC_CHECK);
    }
    public function getExtras($id){
        $extras_ids=FoodOptionExtra::where('food_option_id',$id)->pluck('extra_id');
        $extras=Extra::whereIn('id',$extras_ids)->get(['id','name','price']);
        return response()->json(["msg"=>"All Extras  Received",'extras'=>$extras],200,[],JSON_NUMERIC_CHECK);

    }
}
