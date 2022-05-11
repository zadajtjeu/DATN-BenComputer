@extends('layouts.admin')

@section('title') {{ __('Dashboard') }} @endsection

@section('page_title')
{{ __('Dashboard') }}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-3 col-6">

        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totals_overview['new_order_total'] }}</h3>
                <p>{{ __('New Orders') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">

        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totals_overview['order_total'] }}</h3>
                <p>{{ __('Orders') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">

        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totals_overview['product_total'] }}</h3>
                <p>{{ __('Products') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-box"></i>
            </div>
            <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">

        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totals_overview['user_total'] }}</h3>
                <p>{{ __('Users') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">{{ __('More info') }} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

</div>


<div class="row">

    <section class="col-lg-6 connectedSortable">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    {{ __('Statistic order') }}
                </h3>
                <div class="card-tools">
                    <form method="post" class="row">
                        @csrf
                        <div class="col-auto">
                            <select name="month" id="select_month"
                                class="select-filter-order form-control">
                                <option>-- {{ __('Month') }} --</option>
                                <option value="1">{{ __('January') }}</option>
                                <option value="2">{{ __('February') }} </option>
                                <option value="3">{{ __('March') }}</option>
                                <option value="4">{{ __('April') }}</option>
                                <option selected value="5">{{ __('May') }}</option>
                                <option value="6">{{ __('June') }}</option>
                                <option value="7">{{ __('July') }}</option>
                                <option value="8">{{ __('August') }}</option>
                                <option value="9">{{ __('September') }}</option>
                                <option value="10">{{ __('October') }} </option>
                                <option value="11">{{ __('November') }} </option>
                                <option value="12">{{ __('December') }} </option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <select name="year" id="select_year"
                                class="select-filter-order form-control">
                                <option>-- {{ __('Year') }} --</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option selected value="2022">2022</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <input type="button" id="btn-date-filter-order"
                            class="btn btn-primary btn-sm"
                            value="{{ __('Search') }}"
                            data-url="{{ route('admin.statistic.selectMonthOrder') }}">
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body" id="graph-container">
                <canvas id="line-chart"></canvas>
            </div>
        </div>

    </section>


    <section class="col-lg-6 connectedSortable">

        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-th mr-1"></i>
                    {{ __('Statistic revenue') }}
                </h3>

                <div class="card-tools">
                    <form method="post row">
                        @csrf
                        <div class="col-auto">
                            <select class="form-control"
                                id="select-filter-revenue"
                                data-url="{{ route('admin.statistic.selectYearRevenue') }}">
                                <option>-- {{ __('titles.select_year') }} --
                                </option>
                                <option value="2020">
                                    2020</option>
                                <option value="2021">2021</option>
                                <option selected value="2022">2022</option>
                            </select>
                        </div>
                    </form>
                </div>

            </div>
            <div class="card-body" id="graph-container2">
                <canvas id="chart_revenue"></canvas>
            </div>
        </div>

    </section>

</div>

@endsection

@section('addjs')
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // loadRevenue();
            if($('#btn-date-filter-order')){
                loadOrder();
            }

            if($('#select-filter-revenue')){
                loadRevenue();
            }

            function loadCanvas(total_order){
                $('#line-chart').remove();
                $('#graph-container').append('<canvas id="line-chart"><canvas>');
                var barChart = $('#line-chart');
                var myChart = new Chart(barChart, {
                    type: 'bar',
                    data: {
                        labels: ['{{ __('Week') }} 1','{{ __('Week') }} 2','{{ __('Week') }} 3','{{ __('Week') }} 4'],
                        datasets: [{
                                label: '{{ __('Total orders') }}',
                                data: total_order.split(','),
                                backgroundColor: 'rgba(0, 128, 128, 0.7)',
                                borderColor: 'rgba(0, 128, 128, 0.7)',
                                borderWidth: 1
                            },
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    precision: 0
                                }
                            }]
                        },
                    }
                });
            }

            function loadOrder(){
                var month = $('#select_month').val();
                var year = $('#select_year').val();
                var url = $('#btn-date-filter-order').data('url');
                $.ajax({
                    url: url,
                    method: 'post',
                    data: {
                        month: month,
                        year: year,
                    },
                    success: function(data) {
                        loadCanvas(data);
                    },
                    error: function (error) {
                       toastr.error(error);
                    },
                });
            }

            $('#btn-date-filter-order').click(function() {
                var month = $('#select_month').val();
                var year = $('#select_year').val();
                var url = $(this).data('url');
                $.ajax({
                    url: url,
                    method: 'post',
                    data: {
                        month: month,
                        year: year,
                    },
                    success: function(data) {
                        loadCanvas(data);
                    },
                    error: function (error) {
                        toastr.error(error);
                    },
                });
            });

            function loadCanvasRevenue(month,revenue){
                $('#chart_revenue').remove();
                $('#graph-container2').append('<canvas id="chart_revenue"><canvas>');
                var lineChart = $('#chart_revenue');
                var myChartt = new Chart(lineChart, {
                    type: 'line',
                    data: {
                        labels: month.split(','),
                        datasets: [{
                                label: '{{ __('Revenue') }}',
                                data: revenue.split(','),
                                fill: false,
                                borderColor: 'rgb(75, 192, 192)',
                                tension: 0.1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        },
                    }
                });
            }

            function loadRevenue(){
                var year = $('#select-filter-revenue').val();
                var url = $('#select-filter-revenue').data('url');
                $.ajax({
                    url: url,
                    method: "post",
                    data: {
                        year1: year,
                    },
                    success: function(data) {
                        loadCanvasRevenue(data['month'],data['revenue']);
                    },
                    error: function (error) {
                        toastr.error(error);
                    },
                });
            }

            $('#select-filter-revenue').change(function() {
                var year = $(this).val();
                var url = $(this).data('url');
                $.ajax({
                    url: url,
                    method: "post",
                    data: {
                        year1: year,
                    },
                    success: function(data) {
                        loadCanvasRevenue(data['month'],data['revenue']);
                    },
                    error: function (error) {
                        toastr.error(error);
                    },
                });

            });
        });
    </script>
@endsection
