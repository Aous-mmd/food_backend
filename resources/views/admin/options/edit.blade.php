@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        @include('flash-message')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Option</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.foods.options.update', ['food_id'=>$food->id,'id'=>$option->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $option->name }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Price</label>
                                    <input type="number" min="0" step="0.1" class="form-control" name="price" value="{{ $food_option->pivot->price }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="img">Image</label>
                                    <input class="form-control" type="file" id="img" name="image" accept="image/*"
                                           value="{{ $option->image ? $option->image : asset('media/blank.png') }}">
                                </div>
                            </div>
                            <div class="row">
                                <label class="text-md-right">Description</label>
                                <textarea name="description" class="form-control" rows="4" cols="50">{{ $option->description }}</textarea>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group col-md-12 mb-0">
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>

    </script>

@endsection