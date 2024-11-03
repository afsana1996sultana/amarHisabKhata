@extends('admin.layouts.master')
@section('main-content')
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
                                <h4>Payment Info</h4>
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
                    <div class="col-md-8 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <h5 class=" float-left">Payment View</h5>
                                <h4 class="float-right">
                                    <a href="{{ route('payments.index') }}" class="btn btn-outline-dark btn-xs float-end"
                                       style="padding: 4px 12px"><i class="fas fa-plus"></i> List</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <table id="" >
                                    <tr>
                                        <th class="col-md-6">Customer Name:</th>
                                        <td class="col-md-6">{{$payment->customer->customer_name ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-6">Customer Phone:</th>
                                        <td class="col-md-6">{{$payment->customer_phone ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-6">Project Name:</th>
                                        <td class="col-md-6">{{$payment->project_name ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-6">Paid:</th>
                                        <td class="col-md-6">{{$payment->paid ?? ''}}</td>
                                    </tr>

                                    <tr>
                                        <th class="col-md-6">Previous Due</th>
                                        <td class="col-md-6">{{$payment->due ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-6">Current Given Amount</th>
                                        <td class="col-md-6">{{$payment->amount ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-6">Current Due</th>
                                        <td class="col-md-6">{{$payment->next_due ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-6">Date</th>
                                        <td class="col-md-6">{{$payment->date ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <th class="col-md-6">Note</th>
                                        <td class="col-md-6">{!! $payment->note ?? '' !!}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


