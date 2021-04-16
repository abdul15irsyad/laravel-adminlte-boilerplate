@extends('templates.master')

@section('style')
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}} ">
@yield('content-style')
@endsection

@section('body')

<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed layout-navbar-fixed">
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
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            lengthMenu: [
                [5, 10, 20, 50],
                [5, 10, 20, 50]
            ],
            language:<?= json_encode(__('dashboard.datatables-language')) ?>,
        };
        let defaultLanguageDatepicker = <?= json_encode(__('dashboard.datepicker-language')) ?>;
        let defaultDatepicker = {
            autoclose: true,
            format: 'd MM yyyy',
            language: "in",
            startDate: new Date(),
            todayHighlight: true,
            todayBtn: "linked",
        }
        let gateButton = (item, moduleGate) => {
            let actionList = new DOMParser().parseFromString(item.action, "text/xml")
            let btnShow = actionList.documentElement.querySelector('.btn-show')
            if (btnShow) {
                if (!moduleGate.show) {
                    let parent = btnShow.parentElement
                    parent.remove()
                }
            }
            let btnEdit = actionList.documentElement.querySelector('.btn-edit')
            if (btnEdit) {
                if (!moduleGate.edit) {
                    let parent = btnEdit.parentElement
                    parent.remove()
                }
            }
            let btnDeleteModal = actionList.documentElement.querySelector('.btn-delete-modal')
            if (btnDeleteModal) {
                if (!moduleGate.delete) {
                    let parent = btnDeleteModal.parentElement
                    parent.remove()
                }
            }
            let temp = document.createElement('div')
            temp.appendChild(actionList.documentElement)
            item.action = temp.innerHTML
        }
    </script>
    @yield('content-javascript')
    @endsection