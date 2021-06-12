@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        @include('flash-message')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Discount</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.discounts.update', $discount->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right" for="category_id">Category</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        @foreach($categories as $category)
                                            <option value='{{ $category->id }}' {{ ($category->id == $discount->category_id) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right" for="day">Day</label>
                                    <select name="day" id="day" class="form-control">
                                        <option value="Saturday" {{ ('Saturday' == $discount->day) ? 'selected' : '' }}>@lang('restaurants.Saturday')</option>
                                        <option value="Sunday" {{ ('Sunday' == $discount->day) ? 'selected' : '' }}>@lang('restaurants.Sunday')</option>
                                        <option value="Monday" {{ ('Monday' == $discount->day) ? 'selected' : '' }}>@lang('restaurants.Monday')</option>
                                        <option value="Tuesday" {{ ('Tuesday' == $discount->day) ? 'selected' : '' }}>@lang('restaurants.Tuesday')</option>
                                        <option value="Wednesday" {{ ('Wednesday' == $discount->day) ? 'selected' : '' }}>@lang('restaurants.Wednesday')</option>
                                        <option value="Thursday" {{ ('Thursday' == $discount->day) ? 'selected' : '' }}>@lang('restaurants.Thursday')</option>
                                        <option value="Friday" {{ ('Friday' == $discount->day) ? 'selected' : '' }}>@lang('restaurants.Friday')</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Amount %</label>
                                    <input type="number" step="0.1" min="0" class="form-control" name="amount" value="{{ $discount->amount }}">
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