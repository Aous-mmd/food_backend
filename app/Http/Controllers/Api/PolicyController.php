<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public  function  show(){
        $polices=Policy::all()->makeHidden(['created_at','updated_at']);
        if(!$polices->isEmpty()){
            return response()->json(['msg'=>'All policy received','policies'=>$polices],200);
        }
        else
        {
            return response()->json(['msg'=>'no policies'],422);
        }
    }
}
