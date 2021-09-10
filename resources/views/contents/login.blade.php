@extends('templates.master')

@section('style')
<style>
    .bg-photo{
        background-image: url(https://images.unsplash.com/photo-1554415707-6e8cfc93fe23?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=720&q=80);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
    }
</style>
@endsection

@section('body')
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 bg-photo">
            </div>
            <div class="col-lg-8 hold-transition login-page elevation-3">
                <div class="login-box">
                    <!-- /.login-logo -->
                    <div class="card card-outline card-primary">
                        <div class="card-header text-center">
                            <h2 class="mb-0"><b>Laravel</b> Boilerplate</h2>
                            <h4 class="mb-0">Login</h4>
                        </div>
                        <div class="card-body">
                            @include('includes.alert-dismissible',['message'=>session('message'),'type'=>session('type')])
                            <form action="{{ route('login') }}" method="post" autocomplete="off">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="username" placeholder="Username or Email" value="{{ old('username') }}">
                                </div>
                                <div class="input-group input-password mb-3">
                                    <input type="password" class="form-control" name="password" placeholder="********">
                                    <div class="input-group-append">
                                        <div class="input-group-text btn-show-password">
                                            <span class="fas fa-eye" title="Show"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <!-- /.col -->
                                    <div class="col-md-6 col-12">
                                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('forgot.password') }}" class="btn btn-transparent text-dark">Forgot Password?</a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.login-box -->
            </div>
        </div>
    </div>
@endsection