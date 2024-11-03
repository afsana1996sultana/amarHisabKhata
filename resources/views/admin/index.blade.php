@extends('admin.layouts.master')
@section('main-content')
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- ============================================================== -->
            <!-- pageheader  -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end pageheader  -->
            <!-- ============================================================== -->
            <div class="ecommerce-widget">
                <div class="row">
                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('1', json_decode(Auth::user()->staff->role->permissions))))
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Total Lead</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">{{ $total_lead ?? "" }}</h1>
                                    </div>
                                </div>
                                <div id="sparkline-revenue"></div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('2', json_decode(Auth::user()->staff->role->permissions))))
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Total Customer</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">{{ $total_customer ?? "" }}</h1>
                                    </div>
                                </div>
                                <div id="sparkline-revenue1"></div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('3', json_decode(Auth::user()->staff->role->permissions))))
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Current Project</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">{{$current_project ?? ''}}</h1>
                                    </div>
                                </div>
                                <div id="sparkline-revenue2"></div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('4', json_decode(Auth::user()->staff->role->permissions))))
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Total Project</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">{{$total_project ?? ''}}</h1>
                                    </div>

                                </div>
                                <div id="sparkline-revenue3"></div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('5', json_decode(Auth::user()->staff->role->permissions))))
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Total Expense Value</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">{{$total_expense_value ?? '0'}} Tk</h1>
                                    </div>

                                </div>
                                <div id="sparkline-revenue4"></div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('6', json_decode(Auth::user()->staff->role->permissions))))
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Total Staff</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">{{$total_staff ?? ''}}</h1>
                                    </div>

                                </div>
                                <div id="sparkline-revenue5"></div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('7', json_decode(Auth::user()->staff->role->permissions))))
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Total Project Value</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">{{$total_project_value ?? '0'}} Tk</h1>
                                    </div>

                                </div>
                                <div id="sparkline-revenue6"></div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('8', json_decode(Auth::user()->staff->role->permissions))))
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted">Current Project Value</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">{{ $current_project_value ?? "0" }} Tk</h1>
                                    </div>
                                </div>
                                <div id="sparkline-revenue7"></div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row" style="background-color: #fff; display: flex; justify-content: space-between; margin-left: 0px; margin-right: 0px;">
                    <div id="myChart" style="flex: 1; max-width: 45%; height: 500px;"></div>
                    <div id="myPlot" style="flex: 1; max-width: 45%; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            const data = google.visualization.arrayToDataTable([
                ['Country', 'Classic IT'],
                ['Income',85],
                ['Expense',76],
                ['Ongoing Project',55],
                ['Completed Project',44],
                ['Profit',38]
            ]);
            const options = {
                title: 'Classic Interior Management BarChart',
                backgroundColor: { fill: 'transparent' },
                colors: ['#5e6dff']
            };
            const chart = new google.visualization.BarChart(document.getElementById('myChart'));
            chart.draw(data, options);
        }
    </script>

    <script>
        const xArray = ["Income", "Expense", "Ongoing Project", "Completed Project", "Profit"];
        const yArray = [55, 49, 44, 24, 15];
        const layout = {
            title: "Classic Interior Management PieChart",
            paper_bgcolor: 'rgba(0,0,0,0)',
            plot_bgcolor: 'rgba(0,0,0,0)',
        };
        const data = [{
            labels: xArray,
            values: yArray,
            type: "pie",
            marker: {
                colors: ['#5e6dff', '#d9aaf0', '#ffdbe6', '#dffaff', '#fff2d5']
            }
        }];
        Plotly.newPlot("myPlot", data, layout);
    </script>
@endsection
