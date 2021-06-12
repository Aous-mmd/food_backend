@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        @include('flash-message')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Order Status</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md">
                                    <label class="text-md-right">Customer Name</label>
                                    <input type="text" class="form-control" name="customer_name" value="{{$order->customer_name}}" readonly>
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">Customer Phone</label>
                                    <input type="text" class="form-control" name="customer_phone" value="{{$order->customer_phone}}" readonly>
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">Customer Email</label>
                                    <input type="text" class="form-control" name="customer_email" value="{{$order->customer_email}}" readonly>
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">Total Price</label>
                                    <input type="text" class="form-control" name="total_price" value="{{$order->total_price}}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md">
                                    <label class="text-md-right" for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="pending" {{ ('pending' == $order->status) ? 'selected' : '' }}>@lang('orders.pending')</option>
                                        <option value="accept" {{ ('accept' == $order->status) ? 'selected' : '' }}>@lang('orders.accept')</option>
                                        <option value="reject" {{ ('reject' == $order->status) ? 'selected' : '' }}>@lang('orders.reject')</option>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">Type</label>
                                    <input type="text" class="form-control" name="type" value="{{$order->type}}" readonly>
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">Delivery Address</label>
                                    <input type="text" class="form-control" name="delivery_address_id" value="{{$order->delivery_address->name}}" readonly>
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-md-right">Start Date</label>
                                    <input type="text" class="form-control" name="started_at" value="{{$order->started_at}}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md">
                                    <label class="text-md-right">Description</label>
                                    <textarea name="description" class="form-control" rows="4" cols="50" readonly>{{ $order->description }}</textarea>
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