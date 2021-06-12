<?php

namespace App\Http\Controllers\dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryAddress\StoreDeliveryAddressRequest;
use App\Http\Requests\DeliveryAddress\UpdateDeliveryAddressRequest;
use App\Models\DeliveryAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeliveryAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses=DeliveryAddress::all();
        return response()->json(['msg'=>'All Delivery Addresses Received','addresses'=>$addresses],200);
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
        DeliveryAddress::create($validated_data);
        return response()->json(['msg'=>'Added Succefully'],200);
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
        $object = DeliveryAddress::findOrFail($id);
        $object->update($validated_data);
        DB::commit();
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
        $address = DeliveryAddress::findOrFail($id);
        $deleted = $address->delete();
        DB::commit();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'deleted_successfully']);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'fail_while_delete']);
        }
    }
}
