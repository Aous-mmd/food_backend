@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        @include('flash-message')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.users.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">User Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">First Name</label>
                                    <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-md-right">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="img">Image</label>
                                    <input class="form-control" type="file" id="img" name="image" accept="image/*"
                                           value="{{ $user->image ? $user->image : asset('media/blank.png') }}">
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