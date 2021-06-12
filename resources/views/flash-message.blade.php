@if ($message = \Session::get('success'))
    <div class="alert alert-success alert-elevate fade show" role="alert">
        <div class="alert-icon"><i class="flaticon2-check-mark"></i></div>
        <div class="alert-text">
            {{ $message }}
        </div>
    </div>
@endif

@if ($message = \Session::get('logout'))

    <script>

        setTimeout(function() {
            $('#logout_form').submit();
        }, 5000);

    </script>
@endif




@if ($message = \Session::get('error'))
    <div class="alert alert-danger alert-elevate fade show" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">
            {{ $message }}
        </div>
    </div>
@endif

@if ($message = \Session::get('errors'))

    <div class="alert alert-danger alert-elevate fade show" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">
            @foreach($message->all() as $error)
                <strong>{{ $error }}</strong><br>
            @endforeach
        </div>
    </div>
@endif


@if ($message = \Session::get('warning'))
    <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = \Session::get('info'))
    <div class="alert alert-info alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif


{{--@if ($errors->any())
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Please check the form below for errors
    </div>
@endif--}}
