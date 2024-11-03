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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
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
                                <h5 class=" float-left">Payment Info Create</h5>
                                <h4 class="float-right">
                                    @if(Auth::user()->user_role == 1 || in_array('21', json_decode(Auth::user()->staff->role->permissions)))
                                        <a href="{{ route('payments.index') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i class="fas fa-plus"></i> List</a>
                                    @endif
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('payments.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <input id="project_id" type="hidden" name="project_id" class="form-control">
                                        <div class="col-12 p-relative">
                                            <div class="form-group from_group_mobile">
                                                <label>Project Name<small class="text-danger">*</small></label>
                                                <select class="form-control select-active w-100 form-select select-nice" name="project_name" id="project_name">
                                                    <option value="0">Select Project</option>
                                                    @foreach($projects as $project)
                                                        <option value="{{ $project->project_name }}" {{ old('project_name')== $project->project_name ? 'selected' : '' }}>{{ $project->project_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="customer_name">Customer Name</label>
                                                <input id="customer_name" type="text" name="customer_name" class="form-control" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="customer_phone">Customer Phone</label>
                                                <input id="customer_phone" type="text" name="customer_phone" class="form-control" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="project_value">Project Value</label>
                                                <input id="project_value" type="text" name="project_value" class="form-control" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="advance">Paid</label>
                                                <input id="paid" type="number" name="paid" class="form-control paid" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="due">Due</label>
                                                <input id="due" type="number" name="due" class="form-control" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="amount">Amount</label>
                                                <input id="amount" type="number" name="amount" data-parsley-trigger="change" autocomplete="off" class="form-control inputAmount">
                                            </div>
                                            <span id="amount-error" class="text-danger" style="display: none;">Amount cannot be greater than Due.</span>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="next_due">Next Due</label>
                                                <input id="next_due" type="number" name="next_due" class="form-control nextDue" readonly>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label>Payment Type </label>
                                                <select class="form-control" name="payment_type">
                                                    <option selected value="">Please Select</option>
                                                    <option value="Bkash">Bkash</option>
                                                    <option value="Bank">Bank</option>
                                                    <option value="Cash">Cash</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile" id="payment_image_group" style="display: none;">
                                                <label for="payment_image">Upload Payment Proof <small class="text-danger">*</small>
                                                    <small class="text-success">(Preferred size: 250X51)</small>
                                                </label>
                                                <input id="payment_image" type="file" name="payment_image"
                                                       data-parsley-trigger="change" accept="image/*" autocomplete="off"
                                                       class="form-control">
                                            </div>
                                            @if ($errors->has('payment_image'))
                                                <span class="text-danger">{{ $errors->first('payment_image') }}</span>
                                            @endif

                                            <div class="mt-2">
                                                <img id="imagePreview" src="#" alt="Image Preview"
                                                     style="display: none; max-width: 250px; max-height: 51px;">
                                            </div>
                                        </div>



                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="date">Date </label>
                                                <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}">
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="note">Note </label>
                                                <textarea class="form-control" name="note" id="note" cols="10" rows="3"></textarea>
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
    <script type="text/javascript">
        {{--$(document).ready(function() {--}}
        {{--    // Function to validate the amount--}}
        {{--    function validateAmount() {--}}
        {{--        var due = parseFloat($('#due').val());--}}
        {{--        var amount = parseFloat($('#amount').val());--}}

        {{--        if (amount > due) {--}}
        {{--            $('#amount-error').show();--}}
        {{--            $('#amount').val(0);--}}
        {{--        } else {--}}
        {{--            $('#amount-error').hide();--}}
        {{--        }--}}
        {{--    }--}}

        {{--    function calculateNextDue() {--}}
        {{--        var due = parseFloat($('#due').val());--}}
        {{--        var amount = parseFloat($('#amount').val());--}}
        {{--        var nextDue = due - amount;--}}

        {{--        // Ensure nextDue is not negative--}}
        {{--        if (nextDue < 0) {--}}
        {{--            nextDue = 0;--}}
        {{--        }--}}

        {{--        $('#next_due').val(nextDue);--}}
        {{--    }--}}

        {{--    // Validate amount on input change--}}
        {{--    $('#amount').on('input', function() {--}}
        {{--        validateAmount();--}}
        {{--        calculateNextDue();--}}
        {{--    });--}}


        {{--    $('#customer_name').on('change', function(){--}}
        {{--        var customer_name = $(this).val();--}}
        {{--        if(customer_name != 0) {--}}
        {{--            $.ajax({--}}
        {{--                url: "{{ route('customerPayment.ajax', '') }}/" + customer_name,--}}
        {{--                type: "GET",--}}
        {{--                dataType: "json",--}}
        {{--                success: function(data) {--}}
        {{--                    console.log('Received Data', data)--}}
        {{--                    $('#project_id').val(data.project_id);--}}
        {{--                    $('#customer_phone').val(data.customer_phone);--}}
        {{--                    $('#project_name').val(data.project_name);--}}
        {{--                    $('#project_value').val(data.project_value);--}}
        {{--                    $('#advance').val(data.advance);--}}
        {{--                    var due = data.project_value - data.advance;--}}
        {{--                    $('#due').val(due);--}}
        {{--                    validateAmount();--}}
        {{--                    calculateNextDue();--}}
        {{--                },--}}
        {{--                error: function(xhr, status, error) {--}}
        {{--                    console.error("AJAX Error: " + error);--}}
        {{--                }--}}
        {{--            });--}}
        {{--        } else {--}}
        {{--            // Clear the fields if no customer is selected--}}
        {{--            $('#project_id').val('');--}}
        {{--            $('#customer_phone').val('');--}}
        {{--            $('#project_name').val('');--}}
        {{--            $('#project_value').val('');--}}
        {{--            $('#advance').val('');--}}
        {{--            $('#due').val('');--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}


            $(document).ready(function() {
                function validateAmount() {
                    var due = parseFloat($('#due').val());
                    var amount = parseFloat($('#amount').val());

                    if (amount > due) {
                        $('#amount-error').show();
                        $('#amount').val(0);
                    } else {
                        $('#amount-error').hide();
                    }
                }


                function calculateNextDue() {
                    var due = parseFloat($('#due').val());
                    var amount = parseFloat($('#amount').val());
                    var nextDue = due - amount;

                    if (nextDue < 0) {
                        nextDue = 0;
                    }

                    $('#next_due').val(nextDue);
                }


                $('#amount').on('input', function() {
                    validateAmount();
                    calculateNextDue();
                });

                $('#project_name').on('change', function() {
                    var project_name = $(this).val();

                    if (project_name != 0) {
                        $.ajax({
                            url: "{{ route('project-payment.ajax', '') }}/" + project_name,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                //console.log('Received Data', data);
                                $('#project_id').val(data.project_id);
                                $('#customer_name').val(data.customer_name);
                                $('#customer_phone').val(data.customer_phone);
                                $('#project_value').val(data.project_value);
                                $('#advance').val(data.advance);
                                $('#paid').val(data.paid);
                                $('#due').val(data.due);

                                var due = data.due;

                                if (due === 0) {
                                    // Clear fields if due is 0
                                    $('#project_id').val('');
                                    $('#customer_name').val('');
                                    $('#customer_phone').val('');
                                    $('#project_value').val('');
                                    $('#advance').val('');
                                    $('#paid').val('');
                                    $('#due').val('');
                                    $('#next_due').val('');

                                    $("#project_name option[value='" + project_name + "']").remove();
                                } else {

                                    $("#project_name option[value='" + project_name + "']").prop('disabled', false);
                                }

                                validateAmount();
                                calculateNextDue();
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX Error: " + error);
                            }
                        });
                    } else {
                        $('#project_id').val('');
                        $('#customer_name').val('');
                        $('#customer_phone').val('');
                        $('#project_value').val('');
                        $('#advance').val('');
                        $('#due').val('');
                        $('#next_due').val('');
                        $('#paid').val('');
                    }
                });


            function togglePaymentImageField() {
                var paymentType = $('select[name="payment_type"]').val();

                if (paymentType === 'Bkash' || paymentType === 'Bank') {
                    $('#payment_image_group').show();
                } else {
                    $('#payment_image_group').hide();
                    $('#imagePreview').hide().attr('src', ''); // Hide and clear image preview if hidden
                }
            }

            togglePaymentImageField();


            $('select[name="payment_type"]').on('change', function() {
                togglePaymentImageField();
            });

            document.getElementById('payment_image').addEventListener('change', function (event) {
                const imagePreview = document.getElementById('imagePreview');
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }

                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                    imagePreview.src = '#';
                }
            });
        });

    </script>
@endpush


