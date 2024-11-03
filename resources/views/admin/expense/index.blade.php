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
                                <h4>Expense Info</h4>
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
                                <h5 class=" float-left">Expense List</h5>
                                <h4 class="float-right">
                                    @if (Auth::user()->user_role == 1 || in_array('38', json_decode(Auth::user()->staff->role->permissions)))
                                        <a href="{{ route('expense.create') }}"
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
                                            <th>Voucher Image</th>
                                            <th>Project Name</th>
                                            <th>Expense Head</th>
                                            <th>Expense Sub-Head</th>
                                            <th>Amount Head</th>
                                            <th>Quantity</th>
                                            <th>Total Amount</th>
                                            <th>Purpose</th>
                                            <th>Approved/Not Approve</th>
                                            <th>Created By</th>
                                            @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('39', json_decode(Auth::user()->staff->role->permissions))
                                                || in_array('40', json_decode(Auth::user()->staff->role->permissions))))
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @php
                                            $totalAmount = 0;
                                        @endphp

                                        @foreach ($expenses as $key => $expense)
                                            @php
                                                $expenseHeads = json_decode($expense->expense_head_id, true) ?? [];
                                                $expenseSubHeads = json_decode($expense->expense_subhead_id, true) ?? [];
                                                $amountHeads = json_decode($expense->amount_head, true) ?? [];
                                                $quantities = json_decode($expense->quantity, true) ?? [];
                                            @endphp

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ asset($expense->voucher_image) }}" alt="" style="height: 50px; width: 50px">
                                                </td>
                                                <td>{{ $expense->project->project_name ?? 'No Projects' }}</td>
                                                <td>
                                                    {{ implode(', ', array_map(function($head) {
                                                        return App\Models\ExpenseHead::find($head)?->title ?? 'N/A';
                                                    }, $expenseHeads)) }}
                                                </td>

                                                <td>
                                                    {{ implode(', ', array_map(function($subHead) {
                                                        return App\Models\ExpenseSubHead::find($subHead ?? null)?->title ?? 'N/A';
                                                    }, $expenseSubHeads)) }}
                                                </td>

                                                <td>{{ implode(', ', $amountHeads ?? ['N/A']) }}</td>
                                                <td>{{ implode(', ', $quantities ?? ['N/A']) }}</td>
                                                <td>{{ $expense->amount ?? 'N/A' }}</td>
                                                <td>{{ $expense->purpose ?? 'N/A' }}</td>

                                                <td class="text-center">
                                                    @if ($expense->is_approve == 1)
                                                        <span class="btn-success btn-xs">Approved</span>
                                                    @else
                                                    <span class="btn-danger btn-xs">Not Approve</span>
                                                    @endif
                                                </td>

                                                <td>{{ $expense->createdBy->name ?? '' }}</td>
                                                <td class="d-flex flex-wrap" style="gap: 5px">
                                                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('39', json_decode(Auth::user()->staff->role->permissions))))
                                                        <a href="{{ route('expense.delete', $expense->id) }}" class="btn btn-danger btn-xs" id="delete">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    @endif

                                                    @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('40', json_decode(Auth::user()->staff->role->permissions))))
                                                        <a href="{{ route('expense.edit', $expense->id) }}" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>
                                                    @endif
                                                </td>
                                            </tr>

                                            @php
                                                $totalAmount += $expense->amount;
                                            @endphp
                                        @endforeach
                                        </tbody>

                                        <tfoot>
                                        <tr>
                                            <td class="text-right" colspan="7">Total:</td>
                                            <td>{{ $totalAmount }}</td>
                                            <td colspan="4"></td>
                                        </tr>
                                        </tfoot>
                                    </table>
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
