<?php

namespace App\Http\Controllers\dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExtraCategory\StoreExtraCategoryRequest;
use App\Http\Requests\ExtraCategory\UpdateExtraCategoryRequest;
use App\Models\ExtraCategory;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExtraCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $extra_categories=ExtraCategory::with('image:imageable_id,image_path')->get();
        return response()->json(['msg'=>'All Extra Categories Received','extra_categories'=>$extra_categories],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExtraCategoryRequest $request)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $object = ExtraCategory::create(Arr::except($validated_data, ['image']));
        if($request->hasFile('image')) {
            $image_data = Helper::uploadFileTo($validated_data["image"], 'extra_categories');
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
    public function update(UpdateExtraCategoryRequest $request, $id)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $object = ExtraCategory::findOrFail($id);
        $object->update($validated_data);
        Helper::handleImageReplace($request, $object, 'extra_categories');
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
        $category = ExtraCategory::findOrFail($id);
        $image = $category->image;
        $deleted = $category->delete();
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
