@extends('templates.master')

@section('body')

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h2 class="mb-0"><b>Admin</b>LTE</h2>
                <h4 class="mb-0">Masuk</h4>
            </div>
            <div class="card-body">
                @if(session('message'))
                <div class="alert alert-default-{{ session('alert_type') }} alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('message') }}
                </div>
                @endif
                <form action="{{ route('login') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="username atau email" value="{{ old('username') }}">
                    </div>
                    <div class="input-group input-password mb-3">
                        <input type="password" class="form-control" name="password" placeholder="********">
                        <div class="input-group-append">
                            <div class="input-group-text btn-show-password">
                                <span class="fas fa-eye" title="tampilkan"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-right">
                        <!-- /.col -->
                        <div class="col-md-6 col-12">
                            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <p class="text-center mb-1">
                    <a href="{{ route('forgot.password') }}">Lupa kata sandi</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    @endsection