@extends('templates.master')

@section('body')
<body>
    <div class="container-fluid hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <h2 class="mb-0"><b>Laravel</b> Boilerplate</h2>
                    <h4 class="mb-0">Forgot Password</h4>
                </div>
                <div class="card-body">
                    @if(session('message'))
                    @include('includes.alert-dismissible',['message'=>session('message'),'type'=>session('type')])
                    @endif
                    <p class="text-center text-sm">We will send link by email to change your password</p>
                    <form action="{{ route('forgot-password.process') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="example@email.com" value="{{ old('email') }}">
                            @error('email')
                            <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Send</button>
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
@endsection