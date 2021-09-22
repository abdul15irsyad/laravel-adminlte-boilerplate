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
                    <div class="form-group">
                        <label class="mb-0">User</label>
                        <div class="lead">{{ $activity_log->causer->user_username }}</div>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">Description</label>
                        <div class="lead">{{ $activity_log->description }}</div>
                    </div>
                    @if(isset($activity_log->subject))
                    <div class="form-group">
                        <label class="mb-0">Object</label>
                        @if($activity_log->subject_type == 'App\Models\User')
                        <div class="lead">{{ $activity_log->subject->user_username }}</div>
                        @elseif($activity_log->subject_type == 'App\Models\Role')
                        <div class="lead">{{ $activity_log->subject->role_name }}</div>
                        @else
                        <div class="lead">-</div>
                        @endif
                    </div>
                    @endif
                </div>
                <!-- ./card-body -->
                <div class="card-footer">
                    <div class="row justify-content-start">
                        <div class="col-md-auto col-5">
                            <a href="{{ route('activity-log') }}" class="btn btn-default btn-block"><i class="fas fa-fw fa-chevron-left"></i> Back</a>
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