@extends('layouts.app')
@section('content')
    <!-- Main Content -->
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ $food->name }} Options</h1>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">{{ $food->name }} Options</h6>
                        <a data-toggle="modal" data-target="#option_create_modal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-plus fa-sm "></i>Add New Option to {{ $food->name }}</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                <tr>
                                    <th width="30">Name</th>
                                    <th width="50">Description</th>
                                    <th width="30">Price</th>
                                    <th width="120">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($options as $option)
                                    <tr class="odd gradeX">
                                        <td>{{ $option->name }}</td>
                                        <td>{{ $option->description }}</td>
                                        <td>{{ $option->pivot->price }}</td>
                                        <td>
                                            <a href="{{ route('admin.foods.options.edit',['food_id'=>$food->id,'id'=>$option->id]) }}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> &nbsp; &nbsp;
                                            <a href="#" style="color: #dc3545" data-toggle="tooltip" title="Delete" onclick="event.preventDefault();deleteItem('{{ $option->id }}','{{ route('admin.options.destroy',$option->id) }}')"><i class="fa fa-trash"></i></a>
                                            &nbsp;&nbsp;
                                            <a data-toggle="tooltip" onclick="addExtra('{{ $option->id }}')" style="color: #23ff64" title="Add Extra"><i class="fas fa-plus"></i></a>
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
    <div class="modal fade" id="option_create_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">New Option to {{ $food->name }}</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.foods.options',$food->id) }}" method="POST" id="option_create_form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group has-feedback {{ $errors->has('price') ? 'has-error' : '' }}">
                            <label>Price</label>
                            <input type="number" min="0" step="0.1" class="form-control" name="price" value="{{ old('price') }}">
                            @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group has-feedback {{ $errors->has('description') ? 'has-error' : '' }}">
                            <label>Description</label>
                            <textarea name="description" cols="30" rows="10" class="form-control">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group has-feedback {{ $errors->has('image') ? 'has-error' : '' }}">
                            <label>Image</label>
                            <input type="file" name="image">
                            @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="SubmitForm('option_create_form')">Save
                        changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_extra_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title" id="myModalLabel">Add Extra To Food Option</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="add_extra_form">
                        @csrf
                        <input name="food_id" value="{{ $food->id }}" type="hidden" class="form-control">
                        <div class="form-group has-feedback {{ $errors->has('extra') ? 'has-error' : '' }}">
                            <label for="extra">Extra</label>
                            <select name="extra_id" id="extra" class="form-control">
                                @foreach($extras as $extra)
                                    <option value="{{ $extra->id }}">{{ $extra->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('extra'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('extra') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group has-feedback {{ $errors->has('price') ? 'has-error' : '' }}">
                            <label for="price">Price</label>
                            <input name="price" id="price" type="number" min="0" step="0.1" class="form-control">
                            @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="SubmitForm('add_extra_form')">Save
                        changes
                    </button>
                </div>
            </div>
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

    <script>
        function addExtra(optionId) {
            var modalObj = $('#add_extra_modal');
            var url = '{{ route("admin.option.extra", ":id") }}';
            url = url.replace(':id', optionId);
            modalObj.find('form').attr('action',url);
            modalObj.modal('show');
        }
    </script>

@endsection