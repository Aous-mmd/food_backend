<?php

namespace App\Http\Controllers\admin;

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
        $this->index_view   = 'admin.extra_categories.index';
        $this->create_view  = 'admin.extra_categories.create';
        $this->show_view    = 'admin.extra_categories.show';
        $this->edit_view    = 'admin.extra_categories.edit';
        $this->index_route  = 'admin.extra-categories.index';

        $this->success_message = trans('admin.created_successfully');
        $this->update_success_message = trans('admin.update_success');
        $this->error_message = trans('admin.fail_while_create');
        $this->update_error_message = trans('admin.fail_while_update');
    }
    public function index()
    {
        $categories = ExtraCategory::all();
        return view($this->index_view,compact('categories'));
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
        $category=ExtraCategory::find($id);
        return view ($this->edit_view,compact('category'));
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
        $object = ExtraCategory::find($id);
        $object->update($validated_data);
        Helper::handleImageReplace($request, $object, 'extra_categories');
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
            $category = ExtraCategory::findOrFail($id);
            $image = $category->image;
            $category->extras()->delete();
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

    public function getExtras($id){
        $category = ExtraCategory::findOrFail($id);
        $extras = $category->extras;
        return view ('admin.extra_categories.extras',compact('extras','category'));
    }
}

