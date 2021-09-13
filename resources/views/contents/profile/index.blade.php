@extends('templates.dashboard')

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
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                        <div class="text-center">
                            {{-- <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/default-user.jpg') }}" alt="User profile picture"> --}}
                        </div>
                        <h3 class="profile-username text-center mb-0">{{ $user->user_name }}</h3>
                        <p class="text-muted text-center">{{ $user->user_username }}</p>
                        <ul class="list-group list-group-bordered mb-2">
                            <li class="list-group-item">
                                <b>Joined</b> <a class="float-right">{{ date_format($user->created_at,'F Y') }}</a>
                            </li>
                        </ul>
                        <a href="{{ route('profile.update') }}" class="btn btn-primary btn-block">Edit Profile</a>
                        <a href="{{ route('profile.change.password') }}" class="btn btn-primary btn-block">Change Password</a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <!-- Profile Detail Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Profile Detail</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="profile-detail mb-3">
                                <strong>Email</strong>
                                <p class="text-muted h5 font-weight-normal">
                                    {{ $user->user_email }}
                                    @if($user->email_verified_at)
                                    <span class="text-pill text-xs bg-light-green text-success m-0"><i class="fas fa-check-circle"></i> verified</span>
                                    @endif
                                </p>
                                @if(!$user->email_verified_at)
                                @include('includes.alert',['message'=>'Please verified your email!','type'=>'warning','class'=>null])
                                @endif
                            </div>
                            <hr>
                            <div class="profile-detail mb-3">
                                <strong>Role</strong>
                                <p class="text-muted h5 font-weight-normal">{{ $user->role->role_name }}</p>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
              </div>
        </div>
        <!--/. container-fluid -->
    </section>
</div>
@endsection