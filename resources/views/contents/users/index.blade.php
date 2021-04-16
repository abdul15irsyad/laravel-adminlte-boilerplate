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
            @include('includes.alert-dismissible',['message'=>session('message'),'type'=>session('type')])
            <div class="card">
                <div class="card-body">
                    <div class="text-right mb-3">
                        <a href="{{ route('users.create',['locale'=>config('app.locale')]) }}" class="btn btn-primary px-3">{{ __('users.create-user') }}</a>
                    </div>
                    <table class="table table-bordered table-striped yajra-datatable">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th>#</th>
                                <th>{{ __('dashboard.name') }}</th>
                                <th>{{ __('dashboard.username') }}</th>
                                <th>{{ __('dashboard.email') }}</th>
                                <th>{{ __('dashboard.role') }}</th>
                                <th>{{ __('dashboard.action') }}</th>
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
  $(document).ready( function () {
    let table = $('.yajra-datatable').DataTable({
        ...defaultDatatables,
        ajax: {
            url: "{{ route('api.v1.users') }}",
            dataType: "json",
            type: "POST",
            data: {
                username: <?= json_encode(auth('web')->user()->user_username) ?>,
                locale: <?= json_encode(config('app.locale')) ?>,
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'user_name', name: 'user_name'},
            {data: 'user_username', name: 'user_username'},
            {data: 'user_email', name: 'user_email'},
            {data: 'role.role_name', name: 'role.role_name'},
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