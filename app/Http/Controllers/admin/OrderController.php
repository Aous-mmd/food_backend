<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private $index_view;
    private $index_route;
    private $success_message;
    private $error_message;
    private $update_success_message;
    private $update_error_message;
    private $edit_view;

    public function __construct()
    {
        $this->index_view   = 'admin.orders.index';
        $this->index_route  = 'admin.orders.index';
        $this->edit_view    = 'admin.orders.edit';

        $this->success_message = trans('admin.created_successfully');
        $this->update_success_message = trans('admin.update_success');
        $this->error_message = trans('admin.fail_while_create');
        $this->update_error_message = trans('admin.fail_while_update');
    }

    public function index()
    {
        $orders = Order::all();
        return view($this->index_view,compact('orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order =Order::find($id);
        return view ($this->edit_view,compact('order'));
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
        $object = Order::find($id);
        $object->update($validated_data);
        return redirect()->route($this->index_route)->with('error', $this->update_error_message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            $order->details()->delete();
            $deleted = $order->delete();
            DB::commit();
            if ($deleted) {
                return response()->json(['status' => 'success', 'message' => 'deleted_successfully']);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'fail_while_delete']);
            }
        }
        return redirect()->route($this->index_route);
    }

    public function getDetails($id){
        $order = Order::findOrFail($id);
        $details = $order->details;
        return view ('admin.orders.details',compact('details'));
    }
}



