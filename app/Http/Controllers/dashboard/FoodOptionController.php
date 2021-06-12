<?php

namespace App\Http\Controllers\dashboard;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Option\StoreOptionRequest;
use App\Http\Requests\Option\UpdateOptionRequest;
use App\Models\Food;
use App\Models\FoodOption;
use App\Models\Image;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FoodOptionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOptionRequest $request)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $option = Option::create(Arr::except($validated_data, ['image','price','food_id']));
        if($request->hasFile('image')) {
            $image_data = Helper::uploadFileTo($validated_data["image"], 'options');
            $image = Image::create([
                'image_path' => $image_data["media_path"],
                'is_primary' => 'yes'
            ]);
            $option->image()->save($image);
        }
        $food = Food::find($validated_data['food_id']);
        $food->options()->attach($option->id, ['price' => $validated_data['price']]);
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
    public function update(UpdateOptionRequest $request, $id)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $object = Option::find($id);
        $object->update($validated_data);
        Helper::handleImageReplace($request, $object, 'options');
        $food_option = Food::find($validated_data['food_id'])->options()->find($id);
        if(!isset($food_option)){
            return response()->json(['msg'=>'cant update on food ID'],422);
        }
        else{
            $food_option->pivot->update(['price' => $validated_data['price']]);
            DB::commit();
            return response()->json(['msg'=>'Updated Successfully'],200);
        }
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
        $option = Option::findOrFail($id);
        $image = $option->image;
        $deleted = $option->delete();
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

    public function getOptionsByFoodId($id){
        $food_options=FoodOption::where('food_id',$id)->pluck('option_id');
        $options=Option::WhereIn('id',$food_options)->with('foodOptions.extras')->get();
        return response()->json(['msg'=>'All options & extras Received','options'=>$options],200);
    }
}
