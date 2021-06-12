@extends('layouts.app')
@section('content')
    <!-- Main Content -->


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Restaurants</h1>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Restaurants</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                <tr>
                                    <th width="10">Id</th>
                                    <th width="30">Name</th>
                                    <th width="30">Phone</th>
                                    <th width="50">Min Order</th>
                                    <th width="30">Open Date</th>
                                    <th width="30">Close Date</th>
                                    <th width="50">Address</th>
                                    <th width="120">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($restaurants as $restaurant)
                                    <tr class="odd gradeX">
                                        <td>{{ $restaurant->id }}</td>
                                        <td>{{ $restaurant->name }}</td>
                                        <td>{{ $restaurant->phone }}</td>
                                        <td>{{ $restaurant->min_order }}$</td>
                                        <td>{{ $restaurant->from_day }}, {{ $restaurant->open_time }}</td>
                                        <td>{{ $restaurant->to_day }}, {{ $restaurant->close_time }}</td>
                                        <td>{{ $restaurant->address }}</td>
                                        <td>
                                            <a href="{{ route('admin.restaurants.edit',$restaurant->id) }}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> &nbsp; &nbsp;
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>
    <!-- /.container-fluid -->
@stop

@section('scripts')
        <script src="{!! asset('theme/vendor/datatables/jquery.dataTables.min.js') !!}"></script>
        <script src="{!! asset('theme/vendor/datatables/dataTables.bootstrap4.min.js') !!}"></script>
        <script src="{!! asset('theme/js/demo/datatables-demo.js') !!}"></script>

@endsection