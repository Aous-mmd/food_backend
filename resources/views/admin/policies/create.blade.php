@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        @include('flash-message')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Create Policy</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.policies.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Title</label>
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Description</label>
                                    <textarea name="description" class="form-control" rows="4" cols="50"></textarea>
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