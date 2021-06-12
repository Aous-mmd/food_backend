@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        @include('flash-message')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Restaurant Information</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.restaurants.update', $restaurant->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{$restaurant->name}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="{{$restaurant->phone}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{$restaurant->email}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md">
                                    <label class="text-md-right">Street</label>
                                    <input type="text" class="form-control" name="street" value="{{$restaurant->street}}">
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">Build Number</label>
                                    <input type="text" class="form-control" name="build_number" value="{{$restaurant->build_number}}">
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">Min Order</label>
                                    <input type="number" step="0.1" min="0" class="form-control" name="min_order" value="{{$restaurant->min_order}}">
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">Owner Name</label>
                                    <input type="text" class="form-control" name="owner" value="{{$restaurant->owner}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md">
                                    <label class="text-md-right">Open From Day</label>
                                    <select name="from_day" id="from_day" class="form-control">
                                        <option value="Saturday" {{ ('Saturday' == $restaurant->from_day) ? 'selected' : '' }}>@lang('restaurants.Saturday')</option>
                                        <option value="Sunday" {{ ('Sunday' == $restaurant->from_day) ? 'selected' : '' }}>@lang('restaurants.Sunday')</option>
                                        <option value="Monday" {{ ('Monday' == $restaurant->from_day) ? 'selected' : '' }}>@lang('restaurants.Monday')</option>
                                        <option value="Tuesday" {{ ('Tuesday' == $restaurant->from_day) ? 'selected' : '' }}>@lang('restaurants.Tuesday')</option>
                                        <option value="Wednesday" {{ ('Wednesday' == $restaurant->from_day) ? 'selected' : '' }}>@lang('restaurants.Wednesday')</option>
                                        <option value="Thursday" {{ ('Thursday' == $restaurant->from_day) ? 'selected' : '' }}>@lang('restaurants.Thursday')</option>
                                        <option value="Friday" {{ ('Friday' == $restaurant->from_day) ? 'selected' : '' }}>@lang('restaurants.Friday')</option>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">Open To Day</label>
                                    <select name="to_day" id="to_day" class="form-control">
                                        <option value="Saturday" {{ ('Saturday' == $restaurant->to_day) ? 'selected' : '' }}>@lang('restaurants.Saturday')</option>
                                        <option value="Sunday" {{ ('Sunday' == $restaurant->to_day) ? 'selected' : '' }}>@lang('restaurants.Sunday')</option>
                                        <option value="Monday" {{ ('Monday' == $restaurant->to_day) ? 'selected' : '' }}>@lang('restaurants.Monday')</option>
                                        <option value="Tuesday" {{ ('Tuesday' == $restaurant->to_day) ? 'selected' : '' }}>@lang('restaurants.Tuesday')</option>
                                        <option value="Wednesday" {{ ('Wednesday' == $restaurant->to_day) ? 'selected' : '' }}>@lang('restaurants.Wednesday')</option>
                                        <option value="Thursday" {{ ('Thursday' == $restaurant->to_day) ? 'selected' : '' }}>@lang('restaurants.Thursday')</option>
                                        <option value="Friday" {{ ('Friday' == $restaurant->to_day) ? 'selected' : '' }}>@lang('restaurants.Friday')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Open From Time</label>
                                    <input type="time" class="form-control" name="open_time" value="{{$restaurant->open_time}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Open To Time</label>
                                    <input type="time" class="form-control" name="close_time" value="{{ $restaurant->close_time }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="img">Logo</label>
                                    <input class="form-control" type="file" id="img" name="image" accept="image/*" value="{{ $restaurant->image ?? asset('media/blank.png') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md">
                                    <label class="text-md-right">Facebook</label>
                                    <input type="text" class="form-control" name="facebook" value="{{$restaurant->facebook}}">
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">Instagram</label>
                                    <input type="text" class="form-control" name="instagram" value="{{$restaurant->instagram}}">
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">WhatsApp</label>
                                    <input type="text" class="form-control" name="whatsapp" value="{{$restaurant->whatsapp}}">
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">Twitter</label>
                                    <input type="text" class="form-control" name="twitter" value="{{$restaurant->twitter}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md">
                                    <label class="text-md-right">Android App URL</label>
                                    <input type="text" class="form-control" name="android_url" value="{{$restaurant->android_url}}">
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">Iphone App URL</label>
                                    <input type="text" class="form-control" name="iphone_url" value="{{ $restaurant->iphone_url }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md">
                                    <label class="text-md-right">Address</label>
                                    <textarea name="address" class="form-control" rows="4" cols="50">{{$restaurant->address}}</textarea>
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