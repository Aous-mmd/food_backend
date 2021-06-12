<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryAddress\StoreDeliveryAddressRequest;
use App\Http\Requests\DeliveryAddress\UpdateDeliveryAddressRequest;
use App\Models\DeliveryAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryAddressController extends Controller
{
    private $index_view;
    private $create_view;
    private $edit_view;
    private $show_view;
    private $index_route;
    private $success_message;
    private $error_message;
    private $update_success_message;
    private $update_error_message;

    public function __construct()
    {
        $this->index_view   = 'admin.delivery_addresses.index';
        $this->create_view  = 'admin.delivery_addresses.create';
        $this->show_view    = 'admin.delivery_addresses.show';
        $this->edit_view    = 'admin.delivery_addresses.edit';
        $this->index_route  = 'admin.delivery-addresses.index';

        $this->success_message = trans('admin.created_successfully');
        $this->update_success_message = trans('admin.update_success');
        $this->error_message = trans('admin.fail_while_create');
        $this->update_error_message = trans('admin.fail_while_update');
    }
    public function index()
    {
        $delivery_addresses=DeliveryAddress::all();
        return view($this->index_view,compact('delivery_addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->create_view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeliveryAddressRequest $request)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        DeliveryAddress::create($validated_data);
        DB::commit();
        return redirect()->route($this->index_route)->with('error', $this->error_message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $delivery_address=DeliveryAddress::find($id);
        return view ($this->edit_view,compact('delivery_address'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeliveryAddressRequest $request, $id)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $object = DeliveryAddress::find($id);
        $object->update($validated_data);
        DB::commit();
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
            $delivery_address = DeliveryAddress::findOrFail($id);
            $deleted =  $delivery_address->delete();
            if ($deleted) {
                return response()->json(['status' => 'success', 'message' => 'deleted_successfully']);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'fail_while_delete']);
            }
        }
        return redirect()->route($this->index_route);
    }
}
