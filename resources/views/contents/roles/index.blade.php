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
                        <a href="{{ route('roles.create') }}" class="btn btn-primary px-3">Create Role</a>
                    </div>
                    <table class="table table-striped yajra-datatable text-sm">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Permissions</th>
                                <th>Users</th>
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
                @include('includes.alert',['message'=>'','type'=>'danger','class'=>'p-2 mb-1 message-warning'])
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
    $(function () {
        let table = $('.yajra-datatable').DataTable({
            ...defaultDatatables,
            order: [[0,'asc']],
            ajax: {
                url: "{{ route('api.v1.roles') }}",
                dataType: "json",
                type: "POST",
                data: {
                    username: <?= json_encode(auth('web')->user()->user_username) ?>,
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                {data: 'role_name', name: 'role_name'},
                {
                    data: 'permission_roles', 
                    name: 'permission_roles', 
                    orderable: false,
                    render: (data,type,row) => {
                        let pillText = text => '<div class="text-pill text-xs bg-light-green">' + text + '</div>'
                        if(data.length == 0) return '<span class="text-sm">No Permission</span>'
                        else{
                            // max show permission
                            let result = '', max = 4
                            data.forEach((permission_role,index)=>{
                                if(index < max) result += pillText(permission_role.permission.permission_title)
                            })
                            result += (data.length > max) ? pillText('etc . . .') : ''
                            return result
                        }
                    }
                },
                {
                    data: 'users.length', 
                    name: 'users_length',
                    render: (data, type, row) => {
                        if(data == 0) return '<span class="text-sm text-secondary">empty</span>'
                        return data > 1 ? (data + ' users') : (data + ' user')
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
            let deleteModal = document.querySelector('#modal-delete')
            let nickname = deleteModal.querySelector('.nickname')
            let messageWarning = deleteModal.querySelector('.message-warning')
            btnDeletes.forEach(btnDelete => {
                let dataLink = btnDelete.getAttribute('data-link')
                let dataNickname = btnDelete.getAttribute('data-nickname')
                let dataUserCount = parseInt(btnDelete.getAttribute('data-user-count'))
                btnDelete.addEventListener('click', e => {
                    e.preventDefault()
                    // show confirmation modal on delete
                    nickname.innerHTML = dataNickname
                    // if user in deleted role not empty
                    console.log(dataUserCount)
                    if(dataUserCount > 0){
                        messageWarning.style.display = 'block'
                        messageWarning.innerHTML = `There is ${dataUserCount} users, delete the role will also delete the users!`
                    } else {
                        messageWarning.style.display = 'none'
                    }
                    $('#modal-delete').modal('show')
                    let btnDeleteModal = deleteModal.querySelector('.btn-delete-modal')
                    btnDeleteModal.setAttribute('href',dataLink)
                })
            })
        });
    });
</script>
@endsection