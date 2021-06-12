@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        @include('flash-message')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Delivery Address</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.delivery-addresses.update', $delivery_address->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{$delivery_address->name}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Code</label>
                                    <input type="text" class="form-control" name="code" value="{{$delivery_address->code}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Min Delivery</label>
                                    <input type="number" step="0.1" min="0" class="form-control" name="min_delivery" value="{{$delivery_address->min_delivery}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Delivery Cost</label>
                                    <input type="number" step="0.1" min="0" class="form-control" name="delivery_cost" value="{{$delivery_address->delivery_cost}}">
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