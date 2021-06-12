<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Option\StoreOptionRequest;
use App\Http\Requests\Option\UpdateOptionRequest;
use App\Models\Food;
use App\Models\FoodOption;
use App\models\FoodOptionExtra;
use App\Models\Image;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OptionController extends Controller
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
        $this->index_view   = 'admin.options.index';
        $this->create_view  = 'admin.options.create';
        $this->show_view    = 'admin.options.show';
        $this->edit_view    = 'admin.options.edit';
        $this->index_route  = 'admin.options.index';

        $this->success_message = trans('admin.created_successfully');
        $this->update_success_message = trans('admin.update_success');
        $this->error_message = trans('admin.fail_while_create');
        $this->update_error_message = trans('admin.fail_while_update');
    }

    public function storeByFoodId(StoreOptionRequest $request,$id)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $option = Option::create(Arr::except($validated_data, ['image','price']));
        if($request->hasFile('image')) {
            $image_data = Helper::uploadFileTo($validated_data["image"], 'options');
            $image = Image::create([
                'image_path' => $image_data["media_path"],
                'is_primary' => 'yes'
            ]);
            $option->image()->save($image);
        }
        $food = Food::find($id);
        $food->options()->attach($option->id, ['price' => $validated_data['price']]);
        DB::commit();
        return redirect()->route('admin.foods.options',$food->id)->with('error', $this->error_message);
    }

    public function editByFoodId($food_id,$id)
    {
        $option = Option::find($id);
        $food_option = Option::find($id)->foods()->find($food_id);
        //dd($option->foods->first()->pivot->price);
        $food = Food::find($food_id);
        return view ($this->edit_view,compact('option','food','food_option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateByFoodId(UpdateOptionRequest $request,$food_id,$id)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $object = Option::find($id);
        $object->update($validated_data);
        Helper::handleImageReplace($request, $object, 'options');
        $food_option = Food::find($food_id)->options()->find($id);
        $food_option->pivot->update(['price' => $validated_data['price']]);
        DB::commit();
        return redirect()->route('admin.foods.options',$food_id)->with('error', $this->update_error_message);
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
            $option = Option::findOrFail($id);
            $option->foods()->detach();
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
        return redirect()->route($this->index_route);
    }

    public function addExtra(Request $request,$id){
        $foodOption = FoodOption::where([
            'food_id' => $request->food_id,
            'option_id' => $id
        ])->first();

        $extra_id = $request->extra_id;
        $price = $request->price ;

        FoodOptionExtra::create([
            'food_option_id'=> $foodOption->id,
            'extra_id' => $extra_id,
            'price' => $price
        ]);
        return redirect()->route('admin.foods.options',$request->food_id)->with('error', $this->error_message);
    }
}
