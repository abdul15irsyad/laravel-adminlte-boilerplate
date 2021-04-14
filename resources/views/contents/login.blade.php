@extends('templates.master')

@section('body')

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h2 class="mb-0"><b>Laravel</b> Boilerplate</h2>
                <h4 class="mb-0">{{__('auth.login')}}</h4>
            </div>
            <div class="card-body">
                @if(session('message'))
                <div class="alert alert-default-{{ session('type') }} alert-dismissible text-sm">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('message') }}
                </div>
                @endif
                <form action="{{ route('login',['locale'=>config('app.locale')]) }}" method="post" autocomplete="off">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="{{__('auth.username-or-email')}}" value="{{ old('username') }}">
                    </div>
                    <div class="input-group input-password mb-3">
                        <input type="password" class="form-control" name="password" placeholder="********">
                        <div class="input-group-append">
                            <div class="input-group-text btn-show-password">
                                <span class="fas fa-eye" title="{{__('auth.show')}}"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <!-- /.col -->
                        <div class="col-md-6 col-12">
                            <button type="submit" class="btn btn-primary btn-block">{{__('auth.login')}}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <p class="text-center mb-1">
                    <a href="{{ route('forgot.password',['locale'=>config('app.locale')]) }}">{{__('auth.forgot-password')}}</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    @include('includes.locale')
    @endsection