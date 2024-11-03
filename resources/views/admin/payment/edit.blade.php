@extends('admin.layouts.master')
@section('main-content')
    <style>
        .form-group.from_group_mobile {
            display: flex;
        }

        .form-group.from_group_mobile label {
            width: 250px;
        }

        @media (max-width: 576px) {
            .form-group.from_group_mobile label {
                width: 215px;
            }
            input#contact_number {
                height: 35px;
            }
        }

        .p-relative {
            position: relative;
        }

        ul.suggestCustomerNames {
            position: absolute;
            z-index: 999;
            width: 0;
            background: #eee7f2;
            margin-top: 2px;
            top: 33px;
        }

        ul.suggestCustomerNames li {
            padding: 5px 10px;
            margin-left: -550px;
            color: #000;
            border-bottom: 1px solid #ddd
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
                    <div class="col-xl-6 offset-xl-3 col-lg-10 offset-lg-1">
                        <div class="card">
                            <div class="card-header">
                                <h5 class=" float-left">Payment Info Edit</h5>
                                <h4 class="float-right">
                                    <a href="{{ route('payments.index') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i class="fas fa-plus"></i> List</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('payments.update', $payment->id)}}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-12 p-relative">
                                            <div class="form-group from_group_mobile">
                                                <label>Customer Name</label>
                                                <input type="text" id="searchName" value="{{$payment->customer->customer_name ?? ''}}"
                                                      name="customer_name" class="form-control searchResult @error('name') is-invalid @enderror"
                                                       placeholder="Search Customer Name" readonly />
                                                <input type="hidden" name="customer_name" value="{{$payment->customer->id ?? ''}}" id="searchResultId">
                                                <div class="p-0 m-0 rounded-md">
                                                    <ul style="list-style:none"
                                                        class="suggestCustomerNames w-full m-0 p-0">
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="customer_phone">Customer Phone</label>
                                                <input id="customer_phone" type="number" value="{{$payment->customer_phone ?? ''}}" name="customer_phone" data-parsley-trigger="change" autocomplete="off" class="form-control customerPhone" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="project_name">Project Name</label>
                                                <input id="project_name" type="text" value="{{$payment->project_name ?? ''}}"  name="project_name" data-parsley-trigger="change" autocomplete="off" class="form-control projectName" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="advance">Paid </label>
                                                <input id="advance" type="number" value="{{$payment->paid ?? ''}}" name="paid" data-parsley-trigger="change" autocomplete="off" class="form-control paid" readonly>
                                            </div>
                                            <input id="projectValue" type="hidden"  name="project_value" data-parsley-trigger="change" autocomplete="off" class="form-control projectValue">
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="due">Due</label>
                                                <input id="due" type="text" name="due" value="{{$payment->due ?? ''}}" data-parsley-trigger="change" autocomplete="off" class="form-control dueAmount" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="amount">Amount </label>
                                                <input id="amount" type="number" name="amount" value="{{$payment->amount ?? ''}}" data-parsley-trigger="change" autocomplete="off" class="form-control inputAmount">
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="">Next Due </label>
                                                <input id="" type="number" name="next_due" value="{{$payment->next_due ?? ''}}" data-parsley-trigger="change" autocomplete="off" class="form-control nextDue" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label>Payment Type</label>
                                                <select class="form-control" name="payment_type">
                                                    <option selected  value="">Please Select</option>
                                                    <option value="0" {{$payment->payment_type == 0 ? 'selected':''}}>Bkash</option>
                                                    <option value="1" {{$payment->payment_type == 1 ? 'selected':''}}>Bank</option>
                                                    <option value="2" {{$payment->payment_type == 2 ? 'selected':''}}>Cash</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="date">Date </label>
                                                <input id="date" type="date" value="{{$payment->date ?? ''}}" name="date" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="note">Note </label>
                                                <textarea class="form-control" name="note" id="note" cols="10" rows="3">{!! $payment->note ?? '' !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 pl-0">
                                            <p class="text-right">
                                                <button type="submit" class="btn btn-space btn-primary btn-sm">Submit</button>
                                            </p>
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

@push('js')
    <script>
        $(document).on('keyup', '#searchName', function() {
            let query = $(this).val();

            var url = "{{ route('customer.search.name') }}";

            $.ajax({
                url: url,
                method: 'post',
                data: {
                    search: query
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);

                    $('.suggestCustomerNames').empty();
                    $.each(response.data, function(index, resData) {

                        $('.suggestCustomerNames').append(
                            `<li style="margin-top:2px; background-color: #F3F3F9; cursor:pointer;" onmouseout="this.style.color='gray !important'" class="suggestion-btn px-4 py-1"
                                     data-id="${resData.id}" data-customer_name="${resData.customer_name}"
                                     data-customer_phone="${resData.customer_phone}"
                                     data-project_name="${resData.project_name}"
                                     data-project_value="${resData.project_value}"
                                     data-advance="${resData.advance}">${resData.customer_name}</li>`
                        );
                    });

                    $('.suggestion-btn').click(function() {
                        let suggestionId = $(this).data('id');
                        let suggestionName = $(this).data('customer_name');
                        let CustomerPhone = $(this).data('customer_phone');
                        let Project = $(this).data('project_name');
                        let projectValue = $(this).data('project_value');
                        let Paid = $(this).data('advance');
                        //console.log("suggestionName->", suggestionName);
                        //console.log("check->", Email, Phone);

                        $('.searchResult').val(suggestionName);
                        $('#searchResultId').val(suggestionId);
                        $('.customerPhone').val(CustomerPhone);
                        $('.projectName').val(Project);
                        $('.paid').val(Paid);
                        $('.projectValue').val(projectValue);

                        $('.suggestCustomerNames').empty();
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            })
        });


        //  <!-- Calculation Due Amount-->
        $(document).on('click', '.dueAmount', function() {
            var paidAmount = parseFloat($('.paid').val());
            var projectPrice = parseFloat($('.projectValue').val());
            console.log(paidAmount);

            if (!isNaN(projectPrice) && !isNaN(paidAmount)) {

                var dueAmount = projectPrice - paidAmount;
                $('.dueAmount').val(dueAmount);
                $('.dueAmount').attr('readonly', true);
            }
        });


        //  <!-- Calculation Next Due Amount-->
        $(document).on('input', '.inputAmount', function() {
            var input_amount = parseFloat($(this).val());
            var dueAmount = parseFloat($('.dueAmount').val());

            if (!isNaN(dueAmount) && !isNaN(input_amount)) {

                var nextDueAmount = dueAmount - input_amount;

                $('.nextDue').val(nextDueAmount);
            }
        });

    </script>


@endpush


