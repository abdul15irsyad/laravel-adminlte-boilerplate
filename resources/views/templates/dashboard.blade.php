@extends('templates.master')

@section('style')
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}} ">
@yield('content-style')
@endsection

@section('body')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        @include('includes.navbar-dashboard')

        @include('includes.sidebar-dashboard')

        @yield('content')

        @include('includes.footer-dashboard')
    </div>
    <!-- ./wrapper -->
    @endsection

    @section('javascript')
    <!-- overlayScrollbars -->
    <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('adminlte/dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('adminlte/dist/js/pages/dashboard2.js') }}"></script>
    <script type="text/javascript">
        let defaultDatatables = {
            search: {
                caseInsensitive: false
            },
            order: [1,'asc'],
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            lengthMenu: [
                [5, 10, 20, 50],
                [5, 10, 20, 50]
            ],
            language: {
                searchPlaceholder: "search here..."
            },
        };
        let defaultDatepicker = {
            autoclose: true,
            format: 'd MM yyyy',
            language: "en",
            startDate: new Date(),
            todayHighlight: true,
            todayBtn: "linked",
        }
    </script>
    @yield('content-javascript')
    @endsection