<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function show(){
        $addresses=DeliveryAddress::get();
        return response()->json(['msg'=>'All Addresses Received','Addresses'=>$addresses],200,[],JSON_NUMERIC_CHECK);
    }
}
