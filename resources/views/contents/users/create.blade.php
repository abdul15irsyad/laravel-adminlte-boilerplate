@extends('templates.dashboard')

@section('content-css')
<!-- Select2 css -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('includes.header-dashboard',['content_title'=>$title])
    <!-- Main content -->
    <section class="content content-dashboard">
        <div class="container-fluid">
            <form action="{{ route('users.add',['locale'=>config('app.locale')]) }}" method="post" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ __('users.name') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="{{ __('users.name-placeholder') }}" value="{{ old('name') }}">
                                @error('name')
                                <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="d-block mb-0">{{ __('users.username') }}</label>
                            <span class="text-sm text-secondary">{{ __('users.username-desc') }}</span>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="{{ __('users.username-placeholder') }}" value="{{ old('username') }}">
                                @error('username')
                                <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('users.email') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{ __('users.email-placeholder') }}" value="{{ old('email') }}">
                                @error('email')
                                <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="d-block mb-0">{{ __('users.password') }}</label>
                            <span class="text-sm text-secondary">{{ __('users.password-desc') }}</span>
                            <div class="input-group input-password">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="********" value="{{ old('password') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text btn-show-password">
                                        <span class="fas fa-eye" title="{{ __('auth.show') }}"></span>
                                    </div>
                                </div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback d-block pl-2" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">{{ __('users.confirm-password') }}</label>
                            <div class="input-group input-password">
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" placeholder="{{ __('users.confirm-password-placeholder') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text btn-show-password">
                                        <span class="fas fa-eye" title="{{ __('auth.show') }}"></span>
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
                                <a href="{{ route('users',['locale'=>config('app.locale')]) }}" class="btn btn-default btn-block">{{ __('users.cancel') }}</a>
                            </div>
                            <div class="col-md-auto col-7">
                                <input type="submit" class="btn btn-primary btn-block" value="{{ __('users.add-user') }}">
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

@section('content-javascript')
<!-- Select2 javascript -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection