<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['address','details'])->get();
        return response()->json(['msg'=>'All Orders Received','orders'=>$orders],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        $validated_data = $request->validated();
        $object = Order::findOrFail($id);
        $object->update($validated_data);
        return response()->json(['msg'=>'Updated Successfully'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $order = Order::findOrFail($id);
        //$order->details()->delete();
        $deleted = $order->delete();
        DB::commit();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'deleted_successfully']);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'fail_while_delete']);
        }
    }
}
