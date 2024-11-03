@extends('admin.layouts.master')
@section('main-content')
    <style>
        .header-logo {
            height: 100px;
            width: 200px;
            margin-left: 90px;
        }

        div#invoice_print {
            width: 30cm;
            margin: 0 auto;
            padding: 0;
        }

        div#invoice_print td {
            padding-left: 10px !important;
        }

        .table td {
            padding: 0 !important;
        }

        .header-right p strong {
            color: #000;
        }

        @media print {
            .header-right span {
                display: block;
                width: 100%
            }

            .najmul {
                display: block
            }

            .subtotal__price th,
            .subtotal__price td {
                padding: 10px !important;
            }
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
                                <h4>Project Info</h4>
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
                    <div class="col-md-11 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <h5 class=" float-left">Project View</h5>
                                <h4 class="float-right">
                                    @if (Auth::user()->user_role == 1 || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
                                        <a href="{{ route('project.index') }}" class="btn btn-outline-dark btn-xs float-end"
                                            style="padding: 4px 12px"><i class="fas fa-plus"></i> List</a>
                                    @endif
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div id="invoice_print" class="border p-4">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="logo">
                                                        <img src="{{ asset($setting->header_logo) }}" alt=""
                                                            class="header-logo">
                                                    </div>
                                                </div>
                                                <div class="col-5 offset-3">
                                                    <div class="header-right">
                                                        <h4 class="text-black">{{ $setting->site_name ?? '' }}</h4>
                                                        <span><strong>Address: </strong>{!! $setting->address ?? '' !!}</span> <br>
                                                        <span><strong>Mobile No:
                                                            </strong>{{ $setting->contact_number ?? '' }}</span> <br>
                                                        <span><strong>Email : </strong>{{ $setting->email ?? '' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <button
                                                style="border: 1px solid #ddd; padding: 5px 30px; text-transform: uppercase; font-weight: 500; position: absolute; left: 50%; transform: translateX(-50%);cursor:auto">
                                                Project
                                            </button>

                                            <div class="row mt-5">
                                                <div class="col-12">
                                                    <h5>Project INFORMATION</h5>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-weight:600" scope="col">Customer Name
                                                                </th>
                                                                <th style="font-weight:600" scope="col">Customer Phone
                                                                </th>
                                                                <th style="font-weight:600" scope="col">Customer Email
                                                                </th>
                                                                <th style="font-weight:600" scope="col">Address</th>
                                                                <th style="font-weight:600" scope="col">Project Name</th>
                                                                <th style="font-weight:600" scope="col">Project Value
                                                                </th>
                                                                <th style="font-weight:600" scope="col">Advance</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="color: #000">{{ $project->customer_name ?? '' }}
                                                                </td>
                                                                <td style="color: #000">{{ $project->customer_phone ?? '' }}
                                                                </td>
                                                                <td style="color: #000">{{ $project->customer_email ?? '' }}
                                                                </td>
                                                                <td style="color: #000">{{ $project->address ?? '' }}</td>
                                                                <td style="color: #000">{{ $project->project_name ?? '' }}
                                                                </td>
                                                                <td style="color: #000">{{ $project->project_value ?? '' }}
                                                                </td>
                                                                <td style="color: #000">{{ $project->advance ?? '' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="row mt-5">
                                                <div class="col-12">
                                                    <h5>Payment INFORMATION</h5>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-weight:600" scope="col">Sl. No.</th>
                                                                <th style="font-weight:600" scope="col">Project Name</th>
                                                                <th style="font-weight:600" scope="col">Customer Name
                                                                </th>
                                                                <th style="font-weight:600" scope="col">Customer Phone
                                                                </th>
                                                                <th style="font-weight:600" scope="col">Project Name</th>
                                                                <th style="font-weight:600" scope="col">Project Value</th>
                                                                <th style="font-weight:600" scope="col">Total Paid</th>
                                                                <th style="font-weight:600" scope="col">Current Amount</th>
                                                                <th style="font-weight:600" scope="col">Previous Due</th>
                                                                <th style="font-weight:600" scope="col">Current Due</th>
                                                                <th>Payment Type</th>
                                                                <th>Payment Proof</th>
                                                                <th style="font-weight:600" scope="col">Note</th>
                                                                <th style="font-weight:600" scope="col">Date</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($payment as $pay)
                                                                @php
                                                                    $project = \App\Models\Project::find(
                                                                        $pay->project_id,
                                                                    );
                                                                    $paymentPaid = $project->advance;
                                                                    $paid = $pay->paid;
                                                                    $amount = $pay->amount;

                                                                    if ($loop->first) {
                                                                        $totalPaid = $paymentPaid + $amount;
                                                                    } else {
                                                                        $totalPaid = $paid + $amount;
                                                                    }
                                                                @endphp
                                                                <tr>
                                                                    <td style="color: #000">{{ $loop->iteration }}</td>
                                                                    <td style="color: #000">
                                                                        {{ $pay->project_name ?? '' }}</td>
                                                                    <td style="color: #000">{{ $pay->customer_name ?? '' }}
                                                                    </td>
                                                                    <td style="color: #000">
                                                                        {{ $pay->customer_phone ?? '' }}</td>
                                                                    <td style="color: #000">{{ $pay->project_name ?? '' }}
                                                                    </td>
                                                                    <td style="color: #000">{{ $pay->project_value ?? '' }}
                                                                    </td>
                                                                    <td style="color: #000">{{ $totalPaid ?? '' }}</td>
                                                                    <td style="color: #000">{{ $pay->amount ?? '' }}</td>
                                                                    <td style="color: #000">{{ $pay->due ?? '' }}</td>
                                                                    <td style="color: #000">{{ $pay->next_due ?? '' }}</td>
                                                                    <td>{{ $pay->payment_type ?? '' }}</td>
                                                                    <td>
                                                                        <img src="{{asset($pay->payment_image)}}" alt="" style="height: 40px; width: 40px">
                                                                    </td>
                                                                    <td style="color: #000">{{ $pay->note ?? '' }}</td>
                                                                    <td style="color: #000">{{ $pay->date ?? '' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
