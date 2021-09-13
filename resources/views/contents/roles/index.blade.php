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
                    <div class="text-right mb-3">
                        <a href="{{ route('roles.create') }}" class="btn btn-primary">Create Role</a>
                    </div>
                    <table class="table table-striped yajra-datatable">
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
            ajax: {
                url: "{{ route('api.v1.roles') }}",
                dataType: "json",
                type: "POST",
                data: {
                    username: <?= json_encode(auth('web')->user()->user_username) ?>,
                },
                dataSrc: json => json.data.map(item => {
                    // permission pill text
                    let pillText = (text,classes=null) => {
                        let wrapper = '<div class="text-pill text-xs bg-light-green '+classes+'">'
                        wrapper += text
                        wrapper += '</div>'
                        return wrapper
                    }
                    if(item.permission_roles.length == 0){
                        item.permissions = '<span class="text-sm">No Permission</span>'
                    }else{
                        item.permissions = ''
                        // max show permission
                        let max = 4
                        item.permission_roles.forEach((permission_role,i)=>{
                            if(i < max){
                                item.permissions += pillText(permission_role.permission.permission_title)
                            }
                        })
                        if(item.permission_roles.length > max){
                            item.permissions += pillText('etc . . .')
                        }
                    }
                    return item
                }),
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'role_name', name: 'role_name'},
                {data: 'permissions', name: 'permissions', orderable: false},
                {
                    data: 'users.length', 
                    name: 'users_length',
                    render: (data, type, row) => {
                        if(data == 0) return '<span class="text-sm">empty</span>'
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