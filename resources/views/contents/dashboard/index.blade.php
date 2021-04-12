@extends('templates.dashboard')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('includes.header-dashboard',['content_title'=>$title])

    <!-- Main content -->
    <section class="content content-dashboard">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-tag"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">ECP</span>
                            <span class="info-box-number">20 <small>People</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Customers</span>
                            <span class="info-box-number">20 <small>People</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tags"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Active Promo</span>
                            <span class="info-box-number">20 <small>Promos</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-qrcode"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Vouchers</span>
                            <span class="info-box-number">20 <small>Vouchers</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
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