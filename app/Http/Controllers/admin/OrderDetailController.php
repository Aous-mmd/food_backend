<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function getExtras($id){
        $detail = OrderDetail::findOrFail($id);
        $extras = $detail->extras;
        return view ('admin.orders.extras',compact('extras'));
    }
}
