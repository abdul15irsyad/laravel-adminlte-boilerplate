@extends('templates.master')

@section('body')

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <h2 class="mb-0"><b>Admin</b>LTE</h2>
        <h4 class="mb-0">Lupa Kata Sandi</h4>
      </div>
      <div class="card-body">
        <p class="text-center">Kami akan mengirim ke email anda, link untuk mengubah kata sandi anda.</p>
        @if(session('message'))
        <div class="alert alert-default-{{ session('alert_type') }} alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          {{ session('message') }}
        </div>
        @endif
        <form action="{{ route('forgot.password') }}" method="post" autocomplete="off">
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
              <button type="submit" class="btn btn-primary btn-block">Kirim</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <div class="card-footer">
        <p class="mb-1">
          <a href="{{ route('login') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Kembali</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->
  @endsection