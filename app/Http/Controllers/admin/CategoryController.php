<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Extra;
use App\Models\FoodOption;
use App\models\FoodOptionExtra;
use App\models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
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
        $this->index_view   = 'admin.categories.index';
        $this->create_view  = 'admin.categories.create';
        $this->show_view    = 'admin.categories.show';
        $this->edit_view    = 'admin.categories.edit';
        $this->index_route  = 'admin.categories.index';

        $this->success_message = trans('admin.created_successfully');
        $this->update_success_message = trans('admin.update_success');
        $this->error_message = trans('admin.fail_while_create');
        $this->update_error_message = trans('admin.fail_while_update');
    }
    public function index()
    {
        $extras =Extra::all();
        $categories=Category::all();
        return view($this->index_view,compact('categories','extras'));
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
    public function store(StoreCategoryRequest $request)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $object = Category::create(Arr::except($validated_data, ['image']));
        if($request->hasFile('image')) {
            $image_data = Helper::uploadFileTo($validated_data["image"], 'categories');
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
        $category=Category::find($id);
        return view ($this->edit_view,compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $validated_data = $request->validated();
        //dd($validated_data);
        DB::beginTransaction();
        $object = Category::find($id);
        $object->update($validated_data);
        Helper::handleImageReplace($request, $object, 'categories');
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
            DB::beginTransaction();
            $category = Category::findOrFail($id);
            $image = $category->image;
            $category->foods()->delete();
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
        return redirect()->route($this->index_route);
    }

    public function addExtra(Request $request,$id){
        $category = Category::findOrFail($id);
        $extra_id = $request->extra_id;
        $price = $request->price;
        $foodIds = $category->foods->pluck('id');
        $foodOptionIds = FoodOption::whereIn('food_id',$foodIds)->pluck('id');
        foreach ($foodOptionIds as $foodOptionId)
        {
            FoodOptionExtra::create([
                'food_option_id'=> $foodOptionId,
                'extra_id' => $extra_id,
                'price' => $price
            ]);
        }
        return redirect()->route($this->index_route)->with('error', $this->error_message);

    }

    public function getFoods($id){
       $category = Category::findOrFail($id);
       $foods = $category->foods;
        return view ('admin.categories.foods',compact('foods','category'));
    }
}

