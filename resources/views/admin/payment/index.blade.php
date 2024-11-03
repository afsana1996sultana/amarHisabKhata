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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class=" float-left">Payment List</h5>
                                <h4 class="float-right">
                                    @if (Auth::user()->user_role == 1 || in_array('46', json_decode(Auth::user()->staff->role->permissions)))
                                        <a href="{{ route('payments.create') }}"
                                            class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i
                                                class="fas fa-plus"></i> Create</a>
                                    @endif
                                </h4>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Customer Name</th>
                                            <th>Customer Phone</th>
                                            <th>Project Name</th>
                                            <th>Project Value</th>
                                            <th>Total Paid</th>
                                            <th>Current Amount</th>
                                            <th>Previous Due</th>
                                            <th>Current Due</th>
                                            <th>Payment Type</th>
                                            <th>Payment Proof</th>
                                            <th>Note</th>
                                            <th>Date</th>
                                            <th>Created By</th>
                                            @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('47', json_decode(Auth::user()->staff->role->permissions))))
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalPaid = 0;
                                        @endphp

                                        @foreach ($payments as $payment)
                                            @php
                                                $project = \App\Models\Project::find($payment->project_id);
                                                $paymentPaid = $project->advance ?? '';
                                                $paid = $payment->paid;
                                                $amount = $payment->amount;

                                                if ($loop->last) {
                                                    $totalPaid = $paymentPaid + $amount;
                                                } else {
                                                    $totalPaid = $paid + $amount;
                                                }
                                            @endphp

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $payment->customer_name ?? '' }}</td>
                                                <td>{{ $payment->customer_phone ?? '' }}</td>
                                                <td>{{ $payment->project_name ?? '' }}</td>
                                                <td>{{ $payment->project_value ?? '' }}</td>
                                                <td>{{ $totalPaid ?? '' }}</td>
                                                <td>{{ $payment->amount ?? '' }}</td>
                                                <td>{{ $payment->due ?? '' }}</td>
                                                <td>{{ $payment->next_due ?? '' }}</td>
                                                <td>{{ $payment->payment_type ?? '' }}</td>
                                                <td>
                                                    <img src="{{asset($payment->payment_image)}}" alt="" style="height: 50px; width: 50px">
                                                </td>
                                                <td>{!! $payment->note ?? '' !!}</td>
                                                <td>{{ $payment->date ?? '' }}</td>
                                                <td>{{ $payment->user->name ?? '' }}</td>
                                                <td class="text-right">
                                                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('47', json_decode(Auth::user()->staff->role->permissions))))
                                                        <a href="{{ route('payments.delete', $payment->id) }}" class="btn btn-danger btn-xs" id="delete">Delete</a>
                                                    @endif
                                                </td>
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
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endpush
