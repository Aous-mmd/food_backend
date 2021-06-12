<!doctype html>
<html>
<head>
    @include('includes.header')
    @yield('styles')
</head>

<body>

<div id="wrapper">
        @include('includes.sidebar')
        <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">
        @include('includes.navbar')

    <div id="main" class="row">

        @yield('content')

    </div>
                </div>
                </div>
            </div>

    <footer class="row">
        @include('includes.footer')
    </footer>

<!-- Bootstrap core JavaScript-->
<script src="{!! asset('theme/vendor/jquery/jquery.min.js') !!}"></script>
<script src="{!! asset('theme/vendor/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>

<!-- Core plugin JavaScript-->
<script src="{!! asset('theme/vendor/jquery-easing/jquery.easing.min.js') !!}"></script>

<!-- Custom scripts for all pages-->
<script src="{!! asset('theme/js/sb-admin-2.min.js') !!}"></script>

<!-- Page level plugins -->
<script src="{!! asset('theme/vendor/chart.js/Chart.min.js') !!}"></script>

<!-- Page level custom scripts -->
<script src="{!! asset('theme/js/demo/chart-area-demo.js') !!}"></script>
<script src="{!! asset('theme/js/demo/chart-pie-demo.js') !!}"></script>
<script src="{!! asset('theme/js/demo/chart-bar-demo.js') !!}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script src="{!! asset('theme/vendor/datatables/dataTables.bootstrap4.js') !!}"></script>
<script src="{!! asset('theme/vendor/datatables/jquery.dataTables.js') !!}"></script>

<script src="{!! asset('theme/js/select2.min.js') !!}"></script>
@yield('scripts')

</body>
</html>
