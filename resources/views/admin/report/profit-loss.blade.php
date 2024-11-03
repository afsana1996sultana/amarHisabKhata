@extends('admin.layouts.master')
@section('main-content')
    <style>
        .active-projects thead tr th {
            text-align: start;
        }

        .styled-selects {
            border: 1px solid lightgray;
            width: 40% !important;
            padding-top: 3px;
            padding-bottom: 5px;
            margin-right: 5px;
        }
    </style>

    <script>
        function invoiceFunction(el) {
            let restorepage = document.body.innerHTML;
            let printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
            location.reload()
        }
    </script>

    <div class="page-titles">
        <ol class="breadcrumb">
            <li>
                <h5 class="bc-title">Report</h5>
            </li>
        </ol>
    </div>

    <!-- Main content -->
    <div class="container-fluid profitLossDiv">
        <div class="row card p-2">
            <div class="box box-primary no-print">
                <h3 class="text-center mt-3">Project Wise Profit Loss Report</h3>
                <form action="{{ route('report.profit-loss-filter') }}" method="get">
                    <div class="col-12 col-md-4 offset-md-4">
                        <div class="invoice-basic-information no-print d-flex items-center">
                            <select id="projectSelect" class="styled-selects projectId" required name="project_id">
                                <option selected disabled value="">Select Project</option>
                                {{--<option value="">All</option>--}}
                                @foreach($projects as $project)
                                    <option value="{{$project->id}}">{{$project->project_name ?? ''}}</option>
                                @endforeach
                            </select>
                            <input type="text" name="date_range" value="{{ request('date_range') }}" class="form-control" placeholder="Date Range" />
                            <button type="submit" class="btn btn-sm btn-success action__button d-flex" style="align-items: center; gap:5px; background: #5969ff">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row card p-2">
            <div class="col-lg-12">
                <div class="no-print mb-2" style="text-align: right;">
                    <button class="btn btn-sm btn-success action__button" style="background: #5969ff"
                            onclick="invoiceFunction('profitPrint')">
                        <i class="fa fa-print"></i> Print Report
                    </button>
                </div>
                <div class="container" id="profitPrint">
                    <div class="row" id="salesData">
                        @if(request()->has('project_id') || request()->has('date_range'))
                            @if(!empty($projectList) && count($projectList) > 0)
                                <div style="margin-left: 350px" class="text-center">
                                    <h5>Project Wise Profit/Loss Report</h5>
                                    <h6>Report Date : {{ $start_date }} - {{ $end_date }} </h6>
                                </div>
                                <div class="col-md-12">
                                    <h4>Gross {{ $profitLossLabel }}</h4>
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                        <tr>
                                            <th>Description</th>
                                            <th>Value</th>
                                        </tr>
                                        <tr>
                                            <td>Project Name</td>
                                            <td>{{ $projectName }}</td>
                                        </tr>
                                        <tr>
                                            <td>Customer Name</td>
                                            <td>{{ $projectCustomer }}</td>
                                        </tr>
                                        <tr>
                                            <td>Project Value</td>
                                            <td>{{ $projectValue }} TK</td>
                                        </tr>
                                        <tr>
                                            <td>Sales</td>
                                            <td>{{ $currentPaid ?? 0}} TK</td>
                                        </tr>
                                        <tr>
                                            <td>Total Cost</td>
                                            <td>{{ $expenseTotal }} TK</td>
                                        </tr>
                                        <tr>
                                            <td>{{ $profitLossLabel }}</td>
                                            <td>{{ $profitLossValue }} TK</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center" id="noRecords">
                                    <h5>No records found for this project & the selected date range.</h5>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('input[name="date_range"]').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });
    </script>
@endpush

