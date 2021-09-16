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
                <div class="card">
                    <div class="card-body">
                        <div class="role-detail">
                            <span class="h2 font-weight-bold d-block mb-0">{{ $user->user_name }}</span>
                            <p class="lead">{{ $user->user_username }} · {{ $user->user_email }}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-normal mb-0">Role</label>
                            <span class="h3 font-weight-bold d-block mb-0">{{ $user->role->role_name }}</span>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-normal d-block mb-0">Status</label>
                            <span class="text-pill text-sm bg-light-{{ $user->user_status == 'Active' ? 'green' : 'red' }}">{{ $user->user_status }}</span>
                        </div>
                    </div>
                    <!-- ./card-body -->
                    <div class="card-footer">
                        <div class="row justify-content-start">
                            <div class="col-md-auto col-5">
                                <a href="{{ route('users') }}" class="btn btn-default btn-block"><i class="fas fa-fw fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-footer -->
                </div>
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