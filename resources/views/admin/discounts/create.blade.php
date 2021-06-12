@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        @include('flash-message')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Create Discount</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.discounts.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right" for="category_id">Category</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right" for="day">Day</label>
                                    <select name="day" id="day" class="form-control">
                                        <option value="Saturday">@lang('restaurants.Saturday')</option>
                                        <option value="Sunday">@lang('restaurants.Sunday')</option>
                                        <option value="Monday">@lang('restaurants.Monday')</option>
                                        <option value="Tuesday">@lang('restaurants.Tuesday')</option>
                                        <option value="Wednesday">@lang('restaurants.Wednesday')</option>
                                        <option value="Thursday">@lang('restaurants.Thursday')</option>
                                        <option value="Friday">@lang('restaurants.Friday')</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Amount %</label>
                                    <input type="number" step="0.1" min="0" class="form-control" name="amount">
                                </div>
                            </div>
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