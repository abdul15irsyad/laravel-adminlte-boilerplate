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
            <!-- Info boxes -->
            <div class="row justify-content-center">
                <div class="col-12 col-sm-6 col-md-3">
                    @include('includes.info-box',[
                        'icon'=>'fas fa-users',
                        'big_text'=> $users->count(),
                        'text'=>'Users'])
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    @include('includes.info-box',[
                        'icon'=>'fas fa-user-cog',
                        'big_text'=> $roles->count(),
                        'text'=>'Role'])
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    @include('includes.info-box',[
                        'icon'=>'fas fa-bell',
                        'big_text'=> auth('web')->user()->unreadNotifications->count(),
                        'text'=>'Notifications'])
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('content-javascript')
<!-- ChartJS -->
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<script type="text/javascript">
    var ctx = document.getElementById('lineChart');
    var myChart = new Chart(ctx, {
        type: 'line', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Voucher',
                data: [ 12, 8, 6, 9, 10, 1, 45, 12, 22, 11, 7, 34],
                backgroundColor: '#007bff30',
                borderWidth: 0,
                borderColor: '#777',
                hoverBorderWidth: 2,
                hoverBorderColor: '#000'
            }]
        },
        options: {
            aspectRatio: 2,
            responsive: true,
            title: {
                display: false,
                text: 'Voucher yang dibuat oleh pelanggan',
                fontSize: 12,
                responsive: true
            },
            scales: {
                yAxes: [{
                    type: 'linear',
                    position: 'left',
                    ticks: {
                        min: 0,
                        stepSize: 5
                    },
                    gridLines: {
                        display: false,
                        color: '#007bff'
                    }
                }],
            },
            legend: {
                display: false,
                position: 'top',
                labels: {
                    fontColor: '#000'
                }
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    bottom: 0,
                    top: 0
                }
            },
            tooltips: {
                enabled: true,
                mode: 'nearest'
            }
        }
    });
</script>
@endsection