@extends('templates.dashboard')

@section('content-style')
<!-- Datatables css -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/b-1.6.5/b-flash-1.6.5/b-print-1.6.5/fh-3.1.8/r-2.2.7/sp-1.2.2/datatables.min.css" />
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('includes.header-dashboard',['content_title'=>$title])
    <!-- Main content -->
    <section class="content content-dashboard">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped yajra-datatable">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>{{ __('dashboard.name') }}</th>
                                <th>{{ __('dashboard.username') }}</th>
                                <th>{{ __('dashboard.email') }}</th>
                                <th class="text-center">{{ __('dashboard.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('content-javascript')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/b-1.6.5/b-flash-1.6.5/b-print-1.6.5/fh-3.1.8/r-2.2.7/sp-1.2.2/datatables.min.js"></script>
<script type="text/javascript">
  $(function () {
    let table = $('.yajra-datatable').DataTable({
        ...defaultDatatables,
        ajax: {
            url: "{{ route('api.users') }}",
            dataType: "json",
            type: "POST",
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'user_name', name: 'user_name'},
            {data: 'user_username', name: 'user_username'},
            {data: 'user_email', name: 'user_email'},
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false
            },
        ]
    });
  });
</script>
@endsection