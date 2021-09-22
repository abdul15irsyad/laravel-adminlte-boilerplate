@extends('templates.dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('includes.header-dashboard',['content_title'=>$title])
    <!-- Main content -->
    <section class="content content-dashboard">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="permission-detail mb-5">
                        <h2 class="h2 font-weight-bold">{{ $permission->permission_title }}</h2>
                    </div>
                    <div class="form-group">
                        <label>Roles</label>
                        <div class="mb-4">
                            @forelse($permission->permission_roles as $permission_role)
                            <div class="text-pill text-sm bg-light-green">{{ $permission_role->role->role_name }}</div>
                            @empty
                            <span class="lead">No Role</span>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- ./card-body -->
                <div class="card-footer">
                    <div class="row justify-content-start">
                        <div class="col-md-auto col-5">
                            <a href="{{ route('permissions') }}" class="btn btn-default btn-block"><i class="fas fa-fw fa-chevron-left"></i> Back</a>
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