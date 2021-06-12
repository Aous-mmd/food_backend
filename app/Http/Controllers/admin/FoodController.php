<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Food\StoreFoodRequest;
use App\Http\Requests\Food\UpdateFoodRequest;
use App\Models\Category;
use App\Models\Extra;
use App\Models\Food;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
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
        $this->index_view   = 'admin.foods.index';
        $this->create_view  = 'admin.foods.create';
        $this->show_view    = 'admin.foods.show';
        $this->edit_view    = 'admin.foods.edit';
        $this->index_route  = 'admin.foods.index';

        $this->success_message = trans('admin.created_successfully');
        $this->update_success_message = trans('admin.update_success');
        $this->error_message = trans('admin.fail_while_create');
        $this->update_error_message = trans('admin.fail_while_update');
    }

    public function index()
    {
        $foods = Food::all();
        return view($this->index_view,compact('foods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view($this->create_view , compact('categories'));
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
        $categories = Category::all();
        $food = Food::find($id);
        return view ($this->edit_view,compact('food','categories'));
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
        $object = Food::find($id);
        $object->update($validated_data);
        Helper::handleImageReplace($request, $object, 'foods');
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
            $food = Food::findOrFail($id);
            $image = $food->image;
            $food->options()->detach();
            $deleted = $food->delete();
            if ($image) {
                Storage::disk('public_images')->delete($image->image_path);
                $image->delete();
            }
            if ($deleted) {
                return response()->json(['status' => 'success', 'message' => 'deleted_successfully']);
            } else {
                return response()->json(['status' => 'fail', 'message' => 'fail_while_delete']);
            }
        }
        return redirect()->route($this->index_route);
    }

    public function getOptions($id){
        $food = Food::find($id);
        $extras = Extra::all();
        $options = $food->options;
        return view ('admin.options.index',compact('options','food','extras'));
    }

    public function storeByCategoryId(StoreFoodRequest $request,$id)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $category = Category::find($id);
        $validated_data = array_merge( $validated_data, ['category_id' => $category->id]);
        $food = Food::create(Arr::except($validated_data,['image']));
        if($request->hasFile('image')) {
            $image_data = Helper::uploadFileTo($validated_data["image"], 'foods');
            $image = Image::create([
                'image_path' => $image_data["media_path"],
                'is_primary' => 'yes'
            ]);
            $food->image()->save($image);
        }
        DB::commit();
        return redirect()->route('admin.category.foods',$category->id)->with('error', $this->error_message);
    }
}