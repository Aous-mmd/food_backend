<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index(){
        $sliders = Slider::with('image:imageable_id,image_path')->get();
        return response()->json(['msg'=>'All Sliders Received','sliders'=>$sliders],200);
    }
}
