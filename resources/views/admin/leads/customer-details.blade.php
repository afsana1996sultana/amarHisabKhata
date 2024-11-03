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
                                <h4>Customer Info</h4>
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
                                <h5 class=" float-left">Customer View</h5>
                                <h4 class="float-right">
                                    @if (Auth::user()->user_role == 1 || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
                                        <a href="{{ route('customer.index') }}" class="btn btn-outline-dark btn-xs float-end"
                                            style="padding: 4px 12px"><i class="fas fa-plus"></i>Customer List</a>
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
                                                Customer
                                            </button>

                                            <div class="row mt-5">
                                                <div class="col-12">
                                                    <h5>Customer Info</h5>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-weight:600" scope="col">Customer Name
                                                                </th>
                                                                <th style="font-weight:600" scope="col">Customer Phone
                                                                </th>
                                                                <th style="font-weight:600" scope="col">Email
                                                                </th>
                                                                <th style="font-weight:600" scope="col">Address</th>
                                                                <th style="font-weight:600" scope="col">Priority</th>
                                                                <th style="font-weight:600" scope="col">Description
                                                                </th>
                                                                <th style="font-weight:600" scope="col">Status</th>
                                                                <th style="font-weight:600" scope="col">Created By</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="color: #000">{{ $customer->lead_name ?? '' }}
                                                                </td>
                                                                <td style="color: #000">{{ $customer->lead_phone ?? '' }}
                                                                </td>
                                                                <td style="color: #000">{{ $customer->email ?? '' }}
                                                                </td>
                                                                <td style="color: #000">{{ $customer->address ?? '' }}</td>
                                                                <td style="color: #000">{{ $customer->priority ?? '' }}
                                                                </td>
                                                                <td style="color: #000">{{ $customer->description ?? '' }}
                                                                </td>
                                                                <td style="color: #000">{{$customer->status == 1 ? 'Active':'Inactive'}}</td>
                                                                <td style="color: #000">{{ $customer->user->name ?? '' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="row mt-5">
                                                <div class="col-12">
                                                    <h5>Project Info</h5>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th style="font-weight:600" scope="col">Sl. No.</th>
                                                                <th style="font-weight:600" scope="col">Project Name</th>
                                                                <th style="font-weight:600" scope="col">Project Value</th>
                                                                <th style="font-weight:600" scope="col">Advance</th>
                                                                <th style="font-weight:600" scope="col">Project Duration</th>
                                                                <th style="font-weight:600" scope="col">Status</th>
                                                                <th style="font-weight:600" scope="col">Created By</th>
                                                                <th style="font-weight:600" scope="col">Date</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($project as $item)
                                                                <tr>
                                                                    <td style="color: #000">{{ $loop->iteration }}</td>
                                                                    <td style="color: #000">
                                                                        {{ $item->project_name ?? '' }}</td>
                                                                    <td style="color: #000">{{ $item->project_value ?? '' }}
                                                                    </td>
                                                                    <td style="color: #000">
                                                                        {{ $item->advance ?? '' }}</td>
                                                                    <td style="color: #000">{{ $item->project_duration ?? '' }}
                                                                    </td>
                                                                    </td>
                                                                    <td style="color: #000">{{ $item->status == 0 ? 'Ongoing':'Completed' }}</td>
                                                                    <td style="color: #000">{{ $item->user->name ?? '' }}</td>
                                                                    <td style="color: #000">{{ $item->date ?? '' }}</td>
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
