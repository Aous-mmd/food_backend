<?php

namespace App\Http\Controllers\dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Extra\StoreExtraRequest;
use App\Http\Requests\Extra\UpdateExtraRequest;
use App\Models\Extra;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExtraController extends Controller
{
    /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
    public function index()
    {
        $extras = Extra::with(['image:imageable_id,image_path','extra_category:id,name'])->get();
        return response()->json(['msg'=>'All Extras Received','extras'=>$extras],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExtraRequest $request)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $object = Extra::create(Arr::except($validated_data, ['image']));
        if($request->hasFile('image')) {
            $image_data = Helper::uploadFileTo($validated_data["image"], 'extras');
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
    public function update(UpdateExtraRequest $request, $id)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $object = Extra::findOrFail($id);
        $object->update($validated_data);
        Helper::handleImageReplace($request, $object, 'extras');
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
        $extra = Extra::findOrFail($id);
        $image = $extra->image;
        $deleted = $extra->delete();
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
