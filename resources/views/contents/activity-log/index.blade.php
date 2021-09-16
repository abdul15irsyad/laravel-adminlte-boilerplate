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
                    <table class="table table-striped yajra-datatable text-sm">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th>#</th>
                                <th>User</th>
                                <th>Description</th>
                                <th>On</th>
                                <th>Datetime</th>
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
@endsection

@section('content-javascript')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/b-1.6.5/b-flash-1.6.5/b-print-1.6.5/fh-3.1.8/r-2.2.7/sp-1.2.2/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    $(function () {
        let table = $('.yajra-datatable').DataTable({
            ...defaultDatatables,
            order: false,
            ajax: {
                url: "{{ route('api.v1.activities') }}",
                dataType: "json",
                type: "POST",
                data: {
                    username: <?= json_encode(auth('web')->user()->user_username) ?>,
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'causer.user_username', name: 'causer.user_username'},
                {data: 'description', name: 'description'},
                {
                    data: 'subject', 
                    name: 'subject',
                    defaultContent: "-",
                    render: (data,type,row) => {
                        return data?.user_username
                    }
                },
                {
                    data: 'created_at', 
                    name: 'created_at',
                    render: data => {
                        date = moment(data);
                        if(date.diff(moment(),'months') == 0){
                            return date.fromNow() 
                        }else if(date.year() == moment().year()){
                            return date.format('h a [·] MMMM Do')
                        }else{
                            return date.format('h a [·] MMMM Do[,] YYYY')
                        }
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

    });
</script>
@endsection