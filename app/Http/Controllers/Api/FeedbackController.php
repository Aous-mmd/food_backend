<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\storeContactRequest;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public  function  store(storeContactRequest $request){
        $validated_data = $request->validated();
        $feed=Feedback::create($validated_data);
        return response()->json(['msg'=>'Feedback saved successfully'],200);
    }
}
