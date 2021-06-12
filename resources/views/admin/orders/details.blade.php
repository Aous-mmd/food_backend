@extends('layouts.app')
@section('content')
    <!-- Main Content -->


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Order Details</h1>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                <tr>
                                    <th width="30">Food</th>
                                    <th width="30">Quantity</th>
                                    <th width="30">Price</th>
                                    <th width="30">Extras</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($details as $detail)
                                    <tr class="odd gradeX">
                                        <td>{{ $detail->food_option->food->name ?? '---' }} {{ $detail->food_option->option->name ?? '---' }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>{{ $detail->price }}</td>
                                        <td><a href="{{ route('admin.detail.extras',$detail->id) }}" style="color: #23ff64" data-toggle="tooltip" title="View Extras"><i class="fa fa-eye"></i></a>
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