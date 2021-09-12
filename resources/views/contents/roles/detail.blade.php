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
                    <div class="form-group">
                        <label>Role Name</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $role->role_name }}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <div class="input-group mb-3">
                            <textarea class="form-control" id="desc" name="desc" rows="3" disabled>{{ $role->role_desc }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Permissions</label>
                        <div class="input-group">
                            @foreach($role->permission_roles as $permission_role)
                            <div class="text-pill text-sm">{{ $permission_role->permission->permission_title }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Users in this role</label>
                        <table class="table table-striped yajra-datatable">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- ./card-body -->
                <div class="card-footer">
                    <div class="row justify-content-start">
                        <div class="col-md-auto col-5">
                            <a href="{{ route('roles') }}" class="btn btn-default btn-block"><i class="fas fa-fw fa-chevron-left"></i> Back</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-footer -->
            </div>
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('content-javascript')
<!-- Select2 javascript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/b-1.6.5/b-flash-1.6.5/b-print-1.6.5/fh-3.1.8/r-2.2.7/sp-1.2.2/datatables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Select Permissions',
            theme: 'bootstrap4',
        });

        let table = $('.yajra-datatable').DataTable({
            ...defaultDatatables,
            pageLength: 5,
            ajax: {
                url: "{{ route('api.v1.users') }}",
                dataType: "json",
                type: "POST",
                data: {
                    username: '<?= json_encode(auth('web')->user()->user_username) ?>',
                    page: 'detail-role',
                    role: '<?= $role->role_slug ?>',
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'user_name', name: 'user_name'},
                {data: 'user_username', name: 'user_username'},
                {data: 'user_email', name: 'user_email'},
            ]
        });
    });
</script>
@endsection