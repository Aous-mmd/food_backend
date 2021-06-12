<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Extra\StoreExtraRequest;
use App\Http\Requests\Extra\UpdateExtraRequest;
use App\Models\Extra;
use App\Models\ExtraCategory;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExtraController extends Controller
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
        $this->index_view   = 'admin.extras.index';
        $this->create_view  = 'admin.extras.create';
        $this->show_view    = 'admin.extras.show';
        $this->edit_view    = 'admin.extras.edit';
        $this->index_route  = 'admin.extras.index';

        $this->success_message = trans('admin.created_successfully');
        $this->update_success_message = trans('admin.update_success');
        $this->error_message = trans('admin.fail_while_create');
        $this->update_error_message = trans('admin.fail_while_update');
    }
    public function index()
    {
        $extras = Extra::all();
        return view($this->index_view,compact('extras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ExtraCategory::all();
        return view($this->create_view , compact('categories'));
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
        $categories = ExtraCategory::all();
        $extra=Extra::find($id);
        return view ($this->edit_view,compact('extra','categories'));
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
        $object = Extra::find($id);
        $object->update($validated_data);
        Helper::handleImageReplace($request, $object, 'extras');
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
            $extra = Extra::findOrFail($id);
            $image = $extra->image;
            $deleted =  $extra->delete();
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

    public function storeByCategoryId(StoreExtraRequest $request,$id)
    {
        $validated_data = $request->validated();
        DB::beginTransaction();
        $category = ExtraCategory::find($id);
        $validated_data = array_merge( $validated_data, ['extra_category_id' => $category->id]);
        $extra = Extra::create(Arr::except($validated_data,['image']));
        if($request->hasFile('image')) {
            $image_data = Helper::uploadFileTo($validated_data["image"], 'extras');
            $image = Image::create([
                'image_path' => $image_data["media_path"],
                'is_primary' => 'yes'
            ]);
            $extra->image()->save($image);
        }
        DB::commit();
        return redirect()->route('admin.category.get.extras',$category->id)->with('error', $this->error_message);
    }
}


