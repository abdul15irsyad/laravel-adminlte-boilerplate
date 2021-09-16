@extends('templates.dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('includes.header-dashboard',['content_title'=>$title])
    <!-- Main content -->
    <section class="content content-dashboard">
        <div class="container-fluid">
            @if(session('message'))
            @include('includes.alert-dismissible',['message'=>session('message'),'type'=>session('type')])
            @endif
            <form action="{{ route('profile.change-password') }}" method="post" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="old_password" class="d-block">Old Password</label>
                            <div class="input-group input-password">
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" placeholder="********" value="{{ old('old_password') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text btn-show-password">
                                        <span class="fas fa-eye" title="Show"></span>
                                    </div>
                                </div>
                            </div>
                            @error('old_password')
                            <span class="invalid-feedback d-block pl-2" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="d-block mb-0">New Password</label>
                            <span class="text-sm text-secondary">Minimum 8 characters and must contain lowercase letters (a-z), uppercase (A-Z), and numbers (0-9)</span>
                            <div class="input-group input-password">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="********" value="{{ old('password') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text btn-show-password">
                                        <span class="fas fa-eye" title="Show"></span>
                                    </div>
                                </div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback d-block pl-2" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <div class="input-group input-password">
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" placeholder="retype your new password">
                                <div class="input-group-append">
                                    <div class="input-group-text btn-show-password">
                                        <span class="fas fa-eye" title="Show"></span>
                                    </div>
                                </div>
                            </div>
                            @error('confirm_password')
                            <span class="invalid-feedback d-block pl-2" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- ./card-body -->
                    <div class="card-footer">
                        <div class="row justify-content-end">
                            <div class="col-md-auto col-5">
                                <a href="{{ route('profile') }}" class="btn btn-transparent btn-block">Cancel</a>
                            </div>
                            <div class="col-md-auto col-7">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-fw fa-save"></i> Save Changes</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-footer -->
                </div>
            </form>
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection