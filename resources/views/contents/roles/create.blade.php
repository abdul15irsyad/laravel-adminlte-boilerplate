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
            <form action="{{ route('roles.create') }}" method="post" autocomplete="off">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @if($errors->has('name') || $errors->has('slug')) is-invalid @endif" id="name" name="name" placeholder="eg: Copywritter" value="{{ old('name') }}">
                                @error('name')
                                <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                                @enderror
                                @if(!$errors->has('name') && $errors->has('slug'))
                                <span class="invalid-feedback pl-2" role="alert">{{ $errors->first('slug') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc">Description <span class="text-sm text-secondary font-weight-normal">(optional)</span></label>
                            <div class="input-group mb-3">
                                <textarea class="form-control @error('desc') is-invalid @enderror" id="desc" name="desc" placeholder="write description here..." rows="3">{{ old('desc') }}</textarea>
                                @error('desc')
                                <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="permission">Permissions</label>
                            <div class="input-group">
                                <select class="form-control select2 @error('permission') is-invalid @enderror" id="permission" name="permission[]" multiple>
                                    @foreach($permissions as $permission)
                                    <option value="{{ $permission->permission_slug }}" <?= in_array($permission->permission_slug,old('permission') ?? []) ? 'selected' : '' ?>>{{ $permission->permission_title }}</option>
                                    @endforeach
                                </select>
                                @error('permission')
                                <span class="invalid-feedback pl-2" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- ./card-body -->
                    <div class="card-footer">
                        <div class="row justify-content-end">
                            <div class="col-md-auto col-5">
                                <a href="{{ route('roles') }}" class="btn btn-transparent btn-block">Cancel</a>
                            </div>
                            <div class="col-md-auto col-7">
                                <input type="submit" class="btn btn-primary btn-block" value="Create Role">
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
            placeholder: 'Select Permissions',
            theme: 'bootstrap4',
        });
    });
</script>
@endsection