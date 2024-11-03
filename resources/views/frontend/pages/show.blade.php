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
                                <h4>Payment Send Admin</h4>
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
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class=" float-left">Payment Send Admin</h5>
                                <a href="{{ route('customer.index') }}" class=" btn btn-primary float-right">Back</a>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('customer.paymentSendAdmin',$payment->id) }}"  method="post" id="basicform" data-parsley-validate="" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-md-8 offset-md-1 col-lg-8 offset-lg-2">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div class="form-group">
                                                        <label for="city">Transaction Type <small class="text-danger">*</small></label>
                                                        <input id="city" type="text" name="transaction_type" value="{{ $payment->transaction_type ?? "" }}" data-parsley-trigger="change" required=""  autocomplete="off" class="form-control" style="height: 50px">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div class="form-group">
                                                        <label for="initiator_id">Initiator ID <small class="text-danger">*</small></label>
                                                        <input id="initiator_id" type="text" name="initiator_id" value="{{ $payment->initiator_id ?? "" }}" data-parsley-trigger="change" required=""  autocomplete="off" class="form-control" style="height: 50px">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div class="form-group">
                                                        <label for="form_account">Form Account <small class="text-danger">*</small></label>
                                                        <input id="form_account" type="text" name="form_account" value="{{ $payment->form_account ?? "" }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control" style="height: 50px">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div class="form-group">
                                                        <label for="biller_name">Biller Name <small class="text-danger">*</small></label>
                                                        <input id="biller_name" type="text" name="biller_name" value="{{ $payment->biller_name ?? "" }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control" style="height: 50px">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div class="form-group">
                                                        <label for="trade_license_number">Trade license number <small class="text-danger">*</small></label>
                                                        <input id="trade_license_number" type="text" name="trade_license_number" value="{{ $payment->trade_license_number ?? "" }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control" style="height: 50px">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div class="form-group">
                                                        <label for="fee">Fee <small class="text-danger">*</small></label>
                                                        <input id="fee" type="number" name="fee" value="{{ $payment->fee ?? "" }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control" style="height: 50px">
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div class="form-group">
                                                        <label for="form_account">Percentage <small class="text-danger">*</small></label>
                                                        <input id="percentage" type="number" name="percentage" value="{{ $payment->percentage ?? "" }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control" style="height: 50px">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-sm-12 pl-0">
                                                    <p class="text-right">
                                                        <button type="submit" class="btn btn-space btn-primary btn-lg">Submit</button>
                                                        <button type="reset" class="btn btn-space btn-secondary btn-lg">Cancel</button>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
