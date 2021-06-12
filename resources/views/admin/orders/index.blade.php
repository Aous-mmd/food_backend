@extends('layouts.app')
@section('content')
    <!-- Main Content -->
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Orders</h1>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Orders</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                <tr>
                                    <th width="30">Customer Name</th>
                                    <th width="30">Type</th>
                                    <th width="30">Status</th>
                                    <th width="30">Delivery Address</th>
                                    <th width="10">Price</th>
                                    <th width="30">Start Date</th>
                                    <th width="60">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr class="odd gradeX">
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->type }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ $order->delivery_address->name ? $order->delivery_address->name : '--'}}</td>
                                        <td>{{ $order->total_price }}</td>
                                        <td>{{ $order->started_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.edit',$order->id) }}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> &nbsp; &nbsp;
                                            <a href="#" style="color: #dc3545" data-toggle="tooltip" title="Delete" onclick="event.preventDefault();deleteItem('{{ $order->id }}','{{ route('admin.orders.destroy',$order->id) }}')"><i class="fa fa-trash"></i></a>&nbsp;
                                            &nbsp;
                                            <a href="{{ route('admin.order.details',$order->id) }}" style="color: #23ff64" data-toggle="tooltip" title="View Detail"><i class="fa fa-eye"></i></a>
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
@stop

@section('scripts')
    <script src="{!! asset('theme/vendor/datatables/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('theme/vendor/datatables/dataTables.bootstrap4.min.js') !!}"></script>
    <script src="{!! asset('theme/js/demo/datatables-demo.js') !!}"></script>
    <script>
        function deleteItem(id,url) {
            swal({
                title: '{!! trans('Are You Sure ?') !!}',
                type: "warning",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "{!! trans('Yes'); !!}",
                cancelButtonText: "{!! trans('No'); !!}",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {_token: '{!! csrf_token() !!}', _method : 'delete' }
                })
                    .done(function() {


                        swal({title: "{!! trans('Done') !!}", text: "{!! trans('Deleted Successfully') !!}", type: "success"},
                            function(){
                                location.reload();
                            }
                        );


                    })
                    .fail(function(e) {

                        swal("{!! trans('Fail') !!}",e.responseJSON.message, "error")

                    })
            });
        }
        function SubmitForm(formId)
        {
            $('#'+formId).submit();
        }
    </script>

@endsection