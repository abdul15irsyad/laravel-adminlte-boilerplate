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
                        'text'=>'Roles'])
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    @include('includes.info-box',[
                        'icon'=>'fas fa-key',
                        'big_text'=> $permissions->count(),
                        'text'=>'Permissions'])
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Sales
                        </h3>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                            </li>
                            </ul>
                        </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                        <div class="tab-content p-0">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                <canvas id="revenue-chart-canvas" height="300" style="height: 300px; display: block; width: 577px;" width="577" class="chartjs-render-monitor"></canvas>
                            </div>
                            <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <canvas id="sales-chart-canvas" height="300" style="height: 300px; display: block; width: 577px;" class="chartjs-render-monitor" width="577"></canvas>
                            </div>
                        </div>
                        </div><!-- /.card-body -->
                    </div>
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
<!-- ChartJS -->
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('js/chart.js') }}"></script>
@endsection