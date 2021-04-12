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
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            lengthMenu: [
                [5, 10, 20, 50],
                [5, 10, 20, 50]
            ],
            language: {
                emptyTable: "Tidak ada data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(Disaring dari _MAX_ data)",
                lengthMenu: "Tampilkan _MENU_ per halaman",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "<span title='Selanjutnya'><i class='fa fa-forward'></i></span>",
                    previous: "<span title='Sebelumnya'><i class='fa fa-backward'></i></span>"
                },
                processing: "Memuat...",
                search: "_INPUT_",
                searchPlaceholder: "Cari disini...",
                zeroRecords: "Tidak ditemukan",
            },
        }
        var defaultLanguageDatepicker = {
            days: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            daysShort: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            daysMin: ["Mi", "Sn", "Sl", "Ra", "Ka", "Ju", "Sa"],
            months: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            monthsShort: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            today: "Hari ini",
            clear: "Hapus",
            titleFormat: "MM yyyy",
            /* Leverages same syntax as 'format' */
            weekStart: 1
        }
        var defaultDatepicker = {
            autoclose: true,
            format: 'd MM yyyy',
            language: "in",
            startDate: new Date(),
            todayHighlight: true,
            todayBtn: "linked",
        }
        var gateButton = (item, moduleGate) => {
            var actionList = new DOMParser().parseFromString(item.action, "text/xml")
            var btnShow = actionList.documentElement.querySelector('.btn-show')
            if (btnShow) {
                if (!moduleGate.show) {
                    var parent = btnShow.parentElement
                    parent.remove()
                }
            }
            var btnEdit = actionList.documentElement.querySelector('.btn-edit')
            if (btnEdit) {
                if (!moduleGate.edit) {
                    var parent = btnEdit.parentElement
                    parent.remove()
                }
            }
            var btnDeleteModal = actionList.documentElement.querySelector('.btn-delete-modal')
            if (btnDeleteModal) {
                if (!moduleGate.delete) {
                    var parent = btnDeleteModal.parentElement
                    parent.remove()
                }
            }
            var temp = document.createElement('div')
            temp.appendChild(actionList.documentElement)
            item.action = temp.innerHTML
        }
    </script>
    @yield('content-javascript')
    @endsection