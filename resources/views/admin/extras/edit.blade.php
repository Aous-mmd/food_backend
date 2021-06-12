@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        @include('flash-message')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Extra</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.extras.update', $extra->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $extra->name }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="img">Image</label>
                                    <input class="form-control" type="file" id="img" name="image" accept="image/*"
                                           value="{{ $extra->image ? $extra->image : asset('media/blank.png') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right" for="category_id">Category</label>
                                    <select name="extra_category_id" id="category_id" class="form-control">
                                        @foreach($categories as $category)
                                            <option value='{{ $category->id }}' {{ ($category->id == $extra->extra_category_id) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="text-md-right">Description</label>
                                <textarea name="description" class="form-control" rows="4" cols="50">{{ $extra->description }}</textarea>
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