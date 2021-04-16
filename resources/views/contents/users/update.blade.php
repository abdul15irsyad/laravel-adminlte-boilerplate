@extends('templates.dashboard')

@section('content-style')
<!-- Select2 css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('includes.header-dashboard',['content_title'=>$title])
    <!-- Main content -->
    <section class="content content-dashboard">
        <div class="container-fluid">
            <form action="{{ route('users.update',['locale'=>config('app.locale'),'id'=>$user->id]) }}" method="post" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ __('users.name') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="{{ __('users.name-placeholder') }}" value="{{ old('name',$user->user_name) }}">
                                @error('name')
                                <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="d-block mb-0">{{ __('users.username') }}</label>
                            <span class="text-sm text-secondary">{{ __('users.username-desc') }}</span>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="{{ __('users.username-placeholder') }}" value="{{ old('username',$user->user_username) }}">
                                @error('username')
                                <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('users.email') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{ __('users.email-placeholder') }}" value="{{ old('email',$user->user_email) }}">
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
                        <div class="form-group">
                            <label for="role">{{ __('users.role') }}</label>
                            <div class="input-group">
                                <select class="form-control select2 @error('role') is-invalid @enderror" id="role" name="role">
                                    @foreach($roles as $role)
                                    <option value="{{ $role->role_slug }}" <?= old('role',$user->role->role_slug)==$role->role_slug ? 'selected' : '' ?>>{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- ./card-body -->
                    <div class="card-footer">
                        <div class="row justify-content-end">
                            <div class="col-md-auto col-5">
                                <a href="{{ route('users',['locale'=>config('app.locale')]) }}" class="btn btn-default btn-block">{{ __('users.cancel') }}</a>
                            </div>
                            <div class="col-md-auto col-7">
                                <input type="submit" class="btn btn-primary btn-block" value="{{ __('users.save-user') }}">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });
</script>
@endsection