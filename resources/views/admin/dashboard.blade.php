@extends('layouts.admin.app')

@section('title')
    <title>Admin Dashboard</title>
@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $todayOrder }}</h3>

                            <p>Today Orders</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ getDeliveryChargesCurrency().' '.$todayEarning }}</h3>

                            <p>Today Earning</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $todayCook }}</h3>

                            <p>Today Registered Cook</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $todayCustomer }}</h3>

                            <p>Today Registered Customer</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalOrder }}</h3>

                            <p>Total Orders</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ getDeliveryChargesCurrency().' '.$totalEarning }}</h3>

                            <p>Total Earning</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalCook }}</h3>

                            <p>Total Registered Cook</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $totalCustomer }}</h3>

                            <p>Total Registered Customer</p>
                        </div>
                    </div>
                </div>
         
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
            <!-- Left col -->
                <section class="col-lg-12 connectedSortable">
        
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Order Chart
                            </h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            
                            <div id="orderChart" style="width: 100%;height:300px;"></div>

                        </div>
                    </div>

                </section>
            <!-- /.Left col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->

    </section>
    <!-- /.content -->

@endsection

@push('scripts')

    <script type="text/javascript">

        var monthArray = {!! json_encode($monthArray) !!};
        var orderDataArray = {!! json_encode($orderDataArray) !!};

        var dom = document.getElementById("orderChart");

        var myChart = echarts.init(dom);

        $(window).on('load', resize);
        $(window).on('resize', resize);
    
        function resize() {

            setTimeout(function () {

                myChart.resize();
            }, 200);
        }

        var app = {};

        var option;

        option = {
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: ['Order']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: monthArray,
            },
            yAxis: {
                type: 'value',
                axisLine: {
                show: true,  
                },
                axisTick: {
                    show: true,
                    alignWithLabel : true
                }
            },
            series: [
                {
                    name: 'Orders',
                    type: 'line',
                    showSymbol: false,
                    smooth: true,
                    data: orderDataArray,
                },
            ]
        };

        if (option && typeof option === 'object') {
            myChart.setOption(option);
        }

    </script>

@endpush