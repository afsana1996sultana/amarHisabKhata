@extends('admin.layouts.master')


@section('main-content')
    <style>
        .print {
            padding: 3px 20px;
            font-size: 20px;
            border-radius: 5px;
        }

    </style>
    <div class=" dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title"> </h2>
                        <p class="pageheader-text"></p>
                        <div class="page-breadcrumb d-flex align-items-center justify-content-around">
                            <nav aria-label="breadcrumb">
                                <h2 class="mb-0">Admin Send Report</h2>
                            </nav>
                            <button class="btn btn-primary btn-sm d-inline print"
                                    onclick="invoiceFunction('invoice_print')">Print
                                <i class="fa fa-print"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="invoice_print">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 col-xl-8 offset-xl-2 card">
                            <div class="card">
                                <div class="card-header text-center">
                                    <img src="{{ asset('frontend/dbbl.jpg') }}" width="500px"  alt="">
                                    <h2 class="card-title mt-2">Transaction Summary</h2>
                                    <h3 style="text-decoration: underline;">Office Copy</h3>
                                </div>
                            </div>
                            <div>
                                <p style="font-size:20px">
                                    <strong style="width:200px">Transition Type : </strong>
                                    <span>{{ $payment->transaction_type ?? "" }}</span>
                                </p>
                                <p style="font-size:20px">
                                    <strong style="width:200px">Transition ID : </strong>
                                    <span>{{ $payment->transaction_id ?? "" }}</span>
                                </p>
                                <p style="font-size:20px">
                                    <strong style="width:200px">Transition Date : </strong>
                                    <span>{{ date('d M Y',strtotime($payment->created_at)) ?? "" }}</span>
                                </p>
                                <p style="font-size:20px">
                                    <strong style="width:200px">Initiator ID : </strong>
                                    <span>{{ $payment->initiator_id ?? "" }}</span>
                                </p>
                                <p style="font-size:20px">
                                    <strong style="width:200px">From Account : </strong>
                                    <span>{{ $payment->form_account ?? "" }}</span>
                                </p>
                                <p style="font-size:20px">
                                    <strong style="width:200px">Biller ID : </strong>
                                    <span>{{ $payment->biller_id ?? "" }}</span>
                                </p>
                                <p style="font-size:20px">
                                    <strong style="width:200px">Biller Name : </strong>
                                    <span>{{ $payment->biller_name ?? "" }}</span>
                                </p>
                                <p style="font-size:20px">
                                    <strong style="width:200px">Depositor Mobile No : </strong>
                                    <span>{{ $payment->mobile_number ?? "" }}</span>
                                </p>
                                <p style="font-size:20px">
                                    <strong style="width:200px">Trade License Number : </strong>
                                    <span>{{ $payment->trade_license_number ?? "" }}</span>
                                </p>
                                <p style="font-size:20px">
                                    <strong style="width:200px">Year : </strong>
                                    <span>{{ date('Y',strtotime($payment->created_at)) ?? "" }}</span>
                                </p>
                                <p style="font-size:20px">
                                    <strong style="width:200px">Total Amount : </strong>
                                    <span>BDT {{ $payment->total_amount ?? "" }}</span>
                                </p>
                                <p style="font-size:20px">
                                    <strong style="width:200px">Fee : </strong>
                                    <span>BDT {{ $payment->fee ?? "" }}</span>
                                </p>
                                <p style="font-size:20px">
                                    <strong style="width:200px">Gemerated Time : </strong>
                                    <span>{{ $payment->created_at ? $payment->created_at->format('Y-m-d h:i:s') : "" }}</span>
                                </p>
                            </div>
                            <h3 class="mt-4 d-block">This is a system generated report of DBBL</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
@endsection
