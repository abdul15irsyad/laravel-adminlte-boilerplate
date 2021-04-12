@extends('templates.master')

@section('body')

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h2 class="mb-0"><b>Admin</b>LTE</h2>
                <h4 class="mb-0">Reset Password</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-default-warning text-center text-sm">
                    Minimum <b>8 characters</b> and must contain lowercase letters <b>(a-z)</b>, uppercase <b>(A-Z)</b>, and number <b>(0-9)</b>
                </div>
                <form action="{{ route('reset.password.process') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group input-password">
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" placeholder="Your new password" value="{{ old('new_password') }}">
                            <div class="input-group-append">
                                <div class="input-group-text btn-show-password">
                                    <span class="fas fa-eye" title="tampilkan"></span>
                                </div>
                            </div>
                            @error('new_password')
                            <span class="invalid-feedback d-block pl-2" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="input-group input-password">
                            <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" placeholder="Retype your new password">
                            <div class="input-group-append">
                                <div class="input-group-text btn-show-password">
                                    <span class="fas fa-eye" title="tampilkan"></span>
                                </div>
                            </div>
                        </div>
                        @error('confirm_password')
                        <span class="invalid-feedback d-block pl-2" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <input type="hidden" name="token" value="{{ old('token',$token->token) }}">
                    <div class="row">
                        <div class="col-6">
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block">Change Password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <p class="text-center mb-1">
                    <a href="{{ route('login') }}">Back to Login</a>
                </p>
            </div>
            <!-- /.card-footer -->
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    @endsection