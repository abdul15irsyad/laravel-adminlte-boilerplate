@extends('templates.dashboard')

@section('content-style')
<!-- Datatables css -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/b-1.6.5/b-flash-1.6.5/b-print-1.6.5/fh-3.1.8/r-2.2.7/sp-1.2.2/datatables.min.css" />
@endsection

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
            <div class="card">
                <div class="card-body">
                    <div class="text-left mb-3">
                        <a href="{{ route('users.create') }}" class="btn btn-primary px-3">Create User</a>
                    </div>
                    <table class="table table-striped yajra-datatable">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Modal Delete -->
<div class="modal fade modal-delete" id="modal-delete" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure want to delete <b class="nickname"></b> ?</p>
                <p class="text-sm text-danger">This action cannot be undo!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-transparent" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger btn-delete-modal"><i class="far fa-fw fa-trash-alt"></i> Delete</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content-javascript')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/b-1.6.5/b-flash-1.6.5/b-print-1.6.5/fh-3.1.8/r-2.2.7/sp-1.2.2/datatables.min.js"></script>
<script type="text/javascript">
    $(document).ready( function () {
        let table = $('.yajra-datatable').DataTable({
            ...defaultDatatables,
            ajax: {
                url: "{{ route('api.v1.users') }}",
                dataType: "json",
                type: "POST",
                data: {
                    username: <?= json_encode(auth('web')->user()->user_username) ?>,
                    page: 'users',
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'user_name', name: 'user_name'},
                {data: 'user_username', name: 'user_username'},
                {data: 'user_email', name: 'user_email'},
                {data: 'role.role_name', name: 'role.role_name'},
                {
                    data: 'user_status',
                    name: 'user_status',
                    orderable: false,
                    searchable: true,
                    render: (data, type, row)=>{
                        let color = data == 'Active' ? "green" : "red"
                        return '<span class="text-pill text-xs bg-light-' + color + '">' + data + '</span>'
                    }
                },
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ]
        });
        
        // add event after datatables draw done
        table.on('draw.dt', function(e, settings, json) {
            // show confirmation modal on delete
            let btnDeletes = document.querySelectorAll('.btn-delete')
            btnDeletes.forEach(btnDelete => {
                let deleteModal = document.querySelector('#modal-delete')
                let nickname = deleteModal.querySelector('.nickname')
                let dataLink = btnDelete.getAttribute('data-link')
                let dataNickname = btnDelete.getAttribute('data-nickname')
                btnDelete.addEventListener('click', e => {
                    e.preventDefault()
                    // show confirmation modal on delete
                    nickname.innerHTML = dataNickname
                    $('#modal-delete').modal('show')
                    let btnDeleteModal = deleteModal.querySelector('.btn-delete-modal')
                    btnDeleteModal.setAttribute('href',dataLink)
                })
            })
        });
    });
</script>
@endsection