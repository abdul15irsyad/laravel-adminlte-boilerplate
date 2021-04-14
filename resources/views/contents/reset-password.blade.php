@extends('templates.master')

@section('body')

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h2 class="mb-0"><b>Laravel</b> Boilerplate</h2>
                <h4 class="mb-0">{{__('auth.reset-password')}}</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-default-warning text-center text-sm">
                    {!! __('auth.reset-password-desc') !!}
                </div>
                <form action="{{ route('reset.password.process',['locale'=>config('app.locale')]) }}" method="post" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group input-password">
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" placeholder="{{__('auth.your-new-password')}}" value="{{ old('new_password') }}">
                            <div class="input-group-append">
                                <div class="input-group-text btn-show-password">
                                    <span class="fas fa-eye" title="{{__('auth.show')}}"></span>
                                </div>
                            </div>
                            @error('new_password')
                            <span class="invalid-feedback d-block pl-2" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="input-group input-password">
                            <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" placeholder="{{__('auth.retype-your-new-password')}}">
                            <div class="input-group-append">
                                <div class="input-group-text btn-show-password">
                                    <span class="fas fa-eye" title="{{__('auth.show')}}"></span>
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
                            <button type="submit" class="btn btn-primary btn-block">{{__('auth.save-password')}}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <p class="text-center mb-1">
                    <a href="{{ route('login',['locale'=>config('app.locale')]) }}">{{__('auth.login')}}</a>
                </p>
            </div>
            <!-- /.card-footer -->
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    @include('includes.locale')
    @endsection