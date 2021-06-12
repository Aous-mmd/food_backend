@extends('layouts.app')
@section('content')
    <!-- Main Content -->


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Feedback</h1>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Feedback</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                <tr>
                                    <th width="30">Email</th>
                                    <th width="100">Description</th>
                                    <th width="30">Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($feedbacks as $feedback)
                                    <tr class="odd gradeX">
                                        <td>{{ $feedback->email }}</td>
                                        <td>{{ $feedback->description }}</td>
                                        <td>
                                            <a href="#" style="color: #dc3545" data-toggle="tooltip" title="Delete" onclick="event.preventDefault();deleteItem('{{ $feedback->id }}','{{ route('admin.feedbacks.destroy',$feedback->id) }}')"><i class="fa fa-trash"></i></a>
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
    </script>

@endsection