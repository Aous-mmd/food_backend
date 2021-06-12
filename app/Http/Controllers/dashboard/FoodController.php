<?php

namespace App\Http\Controllers\dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Food\StoreFoodRequest;
use App\Http\Requests\Food\UpdateFoodRequest;
use App\Models\Category;
use App\Models\Food;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFoodRequest $request)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $object = Food::create(Arr::except($validated_data, ['image']));
        if($request->hasFile('image')) {
            $image_data = Helper::uploadFileTo($validated_data["image"], 'foods');
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
    public function update(UpdateFoodRequest $request, $id)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $object = Food::findOrFail($id);
        $object->update($validated_data);
        Helper::handleImageReplace($request, $object, 'foods');
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
        $food = Food::findOrFail($id);
        $image = $food->image;
        $deleted = $food->delete();
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

    public function getFoodsByCategory($id){
        $category = Category::findOrFail($id);
        $foods = $category->foods->makeHidden('category_id');
        return response()->json(['msg'=>'All Foods Received','foods'=>$foods],200);
    }

}
