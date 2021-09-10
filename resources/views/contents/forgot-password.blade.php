@extends('templates.master')

@section('style')
<style>
    .bg-photo{
        background-image: url(https://images.unsplash.com/photo-1515378960530-7c0da6231fb1?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=720&q=80);
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
                            <h4 class="mb-0">Forgot Password</h4>
                        </div>
                        <div class="card-body">
                            @include('includes.alert-dismissible',['message'=>session('message'),'type'=>session('type')])
                            <p class="text-center text-sm">We will send link by email to change your password</p>
                            <form action="{{ route('forgot.password.process') }}" method="post" autocomplete="off">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="example@email.com" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary btn-block">Send Email</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{ route('login') }}" class="btn btn-transparent text-dark"><i class="fas fa-fw fa-chevron-left"></i> Back to Login</a>
                        </div>
                    <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.login-box -->
            </div>
        </div>
    </div>
@endsection