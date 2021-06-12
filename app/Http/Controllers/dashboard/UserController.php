<?php

namespace App\Http\Controllers\dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::with('image:imageable_id,image_path')->get();
        return response()->json(['msg'=>'All Users Received','users'=>$users],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $password = bcrypt($request->password);
        $validated_data['password'] = $password;
        $object = User::create(Arr::except($validated_data, ['image']));
        if($request->hasFile('image')) {
            $image_data = Helper::uploadFileTo($validated_data["image"], 'users');
            $image = Image::create([
                'image_path' => $image_data["media_path"],
                'is_primary' => 'yes'
            ]);
            $object->image()->save($image);
        }
        DB::commit();
        return response()->json(['msg'=>'Added Succefully'],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $object = User::findOrFail($id);
        if ($request->has('password') && $request->password) {
            $password = bcrypt($request->password);
            $validated_data['password'] = $password;
        } else {
            unset($validated_data['password']);
        }
        $object->update($validated_data);
        Helper::handleImageReplace($request, $object, 'users');
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
        $user = User::findOrFail($id);
        $image = $user->image;
        $deleted = $user->delete();
        if ($image) {
            Storage::disk('public_images')->delete($image->image_path);
            $image->delete();
        }
        DB::commit();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'deleted_successfully']);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'fail_while_delete']);
        }
    }
}
