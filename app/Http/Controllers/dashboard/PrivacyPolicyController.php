<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Policy\StorePolicyRequest;
use App\Http\Requests\Policy\UpdatePolicyRequest;
use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $policies = Policy::all();
        return response()->json(['msg'=>'All Policies Received','policies'=>$policies],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePolicyRequest $request)
    {
        $validated_data = $request->validated();
        Policy::create($validated_data);
        return response()->json(['msg'=>'Added Succefully'],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePolicyRequest $request, $id)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $object = Policy::findOrFail($id);
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
        $policy = Policy::findOrFail($id);
        $deleted = $policy->delete();
        DB::commit();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'deleted_successfully']);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'fail_while_delete']);
        }
    }
}

