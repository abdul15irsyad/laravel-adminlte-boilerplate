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
            @if(session('message'))
            @include('includes.alert-dismissible',['message'=>session('message'),'type'=>session('type')])
            @endif
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped yajra-datatable text-sm">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Permission Name</th>
                                <th>Roles</th>
                                <th>Action</th>
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
            order: [[0,'asc']],
            ajax: {
                url: "{{ route('api.v1.permissions') }}",
                dataType: "json",
                type: "POST",
                data: {
                    username: <?= json_encode(auth('web')->user()->user_username) ?>,
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                {data: 'permission_title', name: 'permission_title'},
                {
                    data: 'permission_roles', 
                    name: 'permission_roles',
                    orderable: false,
                    render: (data,type,row) => {
                        let pillText = text => '<div class="text-pill text-xs bg-light-green">' + text + '</div>'
                        if(data.length == 0) return '<span class="text-sm">No Permission</span>'
                        else{
                            // max show permission
                            let result = '', max = 4
                            data.forEach((permission_role,index)=>{
                                if(index < max) result += pillText(permission_role.role.role_name)
                            })
                            result += (data.length > max) ? pillText('etc . . .') : ''
                            return result
                        }
                    }
                },
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