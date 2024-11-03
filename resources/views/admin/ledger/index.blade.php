@extends('admin.layouts.master')
@section('main-content')
    <style>
        h5.card_header {
            font-size: 24px;
            text-align: center;
        }
        .page-breadcrumb h4 {
            font-size: 26px;
        }

        .card {
            position: relative;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0,0,0,.125);
        }

        .card-body {
            padding: 50px !important;
            text-align: center;
        }
    </style>
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- ============================================================== -->
            <!-- pageheader  -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title"> </h2>
                        <p class="pageheader-text"></p>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <h4>Cashbook History</h4>
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
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pb-3">
                        <h5 class="card_header">Income</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="metric-value d-inline-block">
                                    <h1 class="card_value">{{ number_format($totalIncome, 0) }} TK</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pb-3">
                        <h5 class="card_header">Expense</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="metric-value d-inline-block">
                                    <h1 class="card_value">{{ number_format($totalExpense, 0) }} TK</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pb-3">
                        <h5 class="card_header">Deposit</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="metric-value d-inline-block">
                                    <h1 class="card_value">{{ number_format($totalDeposit, 0) }} TK</h1>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pb-3">
                        <h5 class="card_header">Withdraw</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="metric-value d-inline-block">
                                    <h1 class="card_value">{{ number_format($totalwithdraw, 0) }} TK</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pb-3">
                        <h5 class="card_header">Total(Income+Deposit)</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="metric-value d-inline-block">
                                    <h1 class="card_value">{{ number_format($SumOfIncome, 0) }} TK</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pb-3">
                        <h5 class="card_header">Total(Expense+Withdraw)</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="metric-value d-inline-block">
                                    <h1 class="card_value">{{ number_format($SumOfExpense, 0) }} TK</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 pb-3"></div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 pb-3">
                        <h5 class="card_header">Total Balance</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="metric-value d-inline-block">
                                    <h1 class="card_value">{{ number_format($Balance, 0) }} TK</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 pb-3"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
