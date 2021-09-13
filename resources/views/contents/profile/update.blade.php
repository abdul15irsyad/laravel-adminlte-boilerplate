@extends('templates.dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('includes.header-dashboard',['content_title'=>$title])
    <!-- Main content -->
    <section class="content content-dashboard">
        <div class="container-fluid">
            <form action="{{ route('profile.update') }}" method="post" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="eg: John Doe" value="{{ old('name',$user->user_name) }}">
                                @error('name')
                                <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="d-block mb-0">Username</label>
                            <span class="text-sm text-secondary">Minimum 3 characters and only lowercase letters (a-z), numbers (0-9), or underscore ("_")</span>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="eg: johndoe8" value="{{ old('username',$user->user_username) }}">
                                @error('username')
                                <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="eg: example@email.com" value="{{ old('email',$user->user_email) }}">
                                @error('email')
                                <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="role" name="role" value="{{ $user->role->role_name }}" disabled>
                            </div>
                        </div>
                    </div>
                    <!-- ./card-body -->
                    <div class="card-footer">
                        <div class="row justify-content-end">
                            <div class="col-md-auto col-5">
                                <a href="{{ route('profile') }}" class="btn btn-transparent btn-block">Cancel</a>
                            </div>
                            <div class="col-md-auto col-7">
                                <input type="submit" class="btn btn-primary btn-block" value="Save Changes">
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