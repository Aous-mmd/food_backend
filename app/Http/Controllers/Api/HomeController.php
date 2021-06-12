<?php

namespace App\Http\Controllers\Api;

use App\models\Blog;
use App\Models\Category;
use App\Models\Footer;
use App\Models\Restaurant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function footer(){
        $footer=Footer::take(4)->get();
        $restaurant=Restaurant::first();
        return response()->json(['msg'=>'Footer Received','firstColumn'=>$footer,'secondColumn'=>$restaurant],200,[],JSON_NUMERIC_CHECK);
    }
    public function blogs(){
        $blogs=Blog::all();
//        $cat=Category::take(3)->with(['image'=>function ($query){
//            $query->select('imageable_id','image_path');
//        }])->get();
        return response()->json(['msg'=>'Blogs Received','Blogs'=>$blogs],200,[],JSON_NUMERIC_CHECK);
    }
}
