@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        @include('flash-message')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Create User</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.users.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">User Name</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">First Name</label>
                                    <input type="text" class="form-control" name="first_name" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Email</label>
                                    <input type="text" class="form-control" name="email" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="img">Image</label>
                                    <input class="form-control" type="file" id="img" name="image" accept="image/*">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="password" class="form-control-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="form-group col-md">
                                    <label for="password_confirmation"
                                           class="form-control-label">Password Confirmation</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="form-control">
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