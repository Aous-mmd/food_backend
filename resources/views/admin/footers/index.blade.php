@extends('layouts.app')
@section('content')
    <!-- Main Content -->
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Footers</h1>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Footers</h6>
                        <a href="{{ route('admin.footers.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-plus fa-sm "></i>Add New Footer</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                <tr>
                                    <th width="30">Title</th>
{{--                                    <th width="30">Link</th>--}}
                                    <th width="120">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($footers as $footer)
                                    <tr class="odd gradeX">
                                        <td>{{ $footer->title }}</td>
{{--                                        <td>{{ $footer->link }}</td>--}}
                                        <td>
                                            <a href="{{ route('admin.footers.edit',$footer->id) }}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> &nbsp; &nbsp;
                                            <a href="#" style="color: #dc3545" data-toggle="tooltip" title="Delete" onclick="event.preventDefault();deleteItem('{{ $footer->id }}','{{ route('admin.footers.destroy',$footer->id) }}')"><i class="fa fa-trash"></i></a>
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