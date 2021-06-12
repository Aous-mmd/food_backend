<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{

    /**
     * FoodController constructor
     */
    public function __construct()
    {
    }

    public  function show($id){
        $foods=Food::where('category_id','=',$id)->with(['foodOption'=>function($query){
            $query->select(['food_id','price']);
        }])->get();
        $category=Category::with('image')->where('id',$id)->get()->first();
        $image=$category->image;
        $title=$category->name;
        $desc=$category->description;
        if($image)
        return response()->json(['msg'=>'All Foods Retrieved','image_url'=>$image['image_url'],'title'=>$title,'description'=>$desc,'Foods'=>$foods],200,[],JSON_NUMERIC_CHECK);
        return response()->json(['msg'=>'All Foods Retrieved','image_url'=>null,'title'=>$title,'description'=>$desc,'Foods'=>$foods],200,[],JSON_NUMERIC_CHECK);

    }
    public function  search($type){
        $foods=Food::where('name','like','%'.$type.'%')->orWhere('description','like','%'.$type.'%')->with(['foodOption'=>function($query){
            $query->select(['food_id','price']);
        }])->get();
        if(!$foods->isEmpty()){
            return response()->json(['msg'=>'Foods Retrieved','Foods'=>$foods],200,[],JSON_NUMERIC_CHECK);
        }
        else {
            return response()->json(['msg'=>'No Foods'],412);
        }
    }

}
