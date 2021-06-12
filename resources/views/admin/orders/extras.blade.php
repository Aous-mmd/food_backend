@extends('layouts.app')
@section('content')
    <!-- Main Content -->


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Extras</h1>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Order Extras</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                <tr>
                                    <th width="30">Extra Name</th>
                                    <th width="30">Quantity</th>
                                    <th width="30">Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($extras as $extra)
                                    <tr class="odd gradeX">
                                        <td>{{ $extra->name }}</td>
                                        <td>{{ $extra->pivot->quantity }}</td>
                                        <td>{{ $extra->pivot->price }}</td>
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