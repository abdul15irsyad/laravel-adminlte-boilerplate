@extends('templates.master')

@section('body')

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <h2 class="mb-0"><b>Laravel</b> Boilerplate</h2>
        <h4 class="mb-0">{{__('auth.forgot-password')}}</h4>
      </div>
      <div class="card-body">
        @if(session('message'))
        <div class="alert alert-default-{{ session('type') }} alert-dismissible text-sm">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          {{ session('message') }}
        </div>
        @endif
        <p class="text-center text-sm">{{__('auth.forgot-password-desc')}}</p>
        <form action="{{ route('forgot.password.process',['locale'=>config('app.locale')]) }}" method="post" autocomplete="off">
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
              <button type="submit" class="btn btn-primary btn-block">{{__('auth.send')}}</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <p class="text-center mb-1">
          <a href="{{ route('login',['locale'=>config('app.locale')]) }}">{{__('auth.login')}}</a>
        </p>
      </div>
      <!-- /.card-footer -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->
  @include('includes.locale')
  @endsection