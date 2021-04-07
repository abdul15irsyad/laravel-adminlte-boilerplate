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
                <div class="alert alert-default-warning text-center">
                    Minimal <b>8 karakter</b> dan harus mengandung huruf kecil <b>(a-z)</b>, huruf besar <b>(A-Z)</b>, dan angka <b>(0-9)</b>
                </div>
                <form action="{{ route('reset.password') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <div class="input-group input-password">
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" placeholder="kata sandi baru anda" value="{{ old('new_password') }}">
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
                            <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" placeholder="ketik ulang kata sandi anda">
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
                    <input type="hidden" name="token" value="{{ old('token',$token) }}">
                    <div class="row">
                        <div class="col-6">
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <p class="mb-1">
                    <a href="{{ route('login') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Masuk</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->
    @endsection