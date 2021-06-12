<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Parent_;

class   CategoryController extends Controller
{

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
    }

    public  function  show(){
        $current_date=Carbon::now()->toDateTime();
        $day_name=$current_date->format('l');
        $categories=Category::with(['Discount'=>function ($query) use ($day_name){
            $query->select('category_id','amount')->where('day',$day_name);
        }])->orderBy('order')->get(['id','name']);
        if(!$categories->isEmpty()) {
            return response()->json(['msg' => 'All Categories Retrieved', 'Categories' => $categories],200,[],JSON_NUMERIC_CHECK);
        }
        else{
            return response()->json(['msg'=>'No Categories Found'],422);
        }

    }
    public  function  get(Request $request){
        $categories=Category::orderBy('order')->get(['id','name']);
        if(!$categories->isEmpty()) {
            return response()->json(['msg' => 'All Categories Retrieved', 'Categories' => $categories],200,[],JSON_NUMERIC_CHECK);
        }
        else{
            return response()->json(['msg'=>'No Categories Found'],422);
        }
    }
    public  function  all(Request $request){
    $categories=Category::with(['image'=>function($query){
        $query->select('imageable_id','image_path');
    },'foods'=>function($query){
        $query->select('id','category_id','name','description');
    },'foods.foodOption'=>function($query){
        $query->select(['food_id','price']);
    }])->orderBy('order')->get();
    return $categories;

    }

}
