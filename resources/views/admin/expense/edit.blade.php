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
    </style>

    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <div class="page-breadcrumb">
                            <h4>Edit Expense Info</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ecommerce-widget">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
                        <div class="card">
                            <div class="card-header">
                                <h5 class=" float-left">Expense Update</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('expense.update', $expenses->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="project_id">Project Name <small class="text-danger">*</small></label>
                                                <select class="form-control select-active w-100 form-select select-nice" name="project_id" id="project_id">
                                                    <option value="">Select Project</option>
                                                    @foreach($projects as $project)
                                                        <option value="{{ $project->id }}" {{ $expenses->project_id == $project->id ? 'selected' : '' }}>
                                                            {{ $project->project_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-5">
                                            <table id="expenseTable" class="jsgrid-table mb-5">
                                                <tr class="jsgrid-header-row">
                                                    <th class="" style="width: 320px;">Expense Head</th>
                                                    <th class="" style="width: 320px;">Expense SubHead</th>
                                                    <th style="width:180px;">Quantity</th>
                                                    <th style="width:180px;">Amount</th>
                                                </tr>
                                                @php
                                                    $expense_heads = json_decode($expenses->expense_head_id, true);
                                                    $expense_subheads = json_decode($expenses->expense_subhead_id, true);
                                                    $quantities = json_decode($expenses->quantity, true);
                                                    $amount_heads = json_decode($expenses->amount_head, true);
                                                @endphp

                                                @foreach($expense_heads as $index => $head)
                                                    <tr class="jsgrid-insert-row pb-4 append-coloum">
                                                        <td class="jsgrid-cell jsgrid-align-center" style="width: 100px;">
                                                            <select name="expense_head_id[]" class="form-control select-active w-100 form-select select-nice" required>
                                                                <option value="">Select Expense Head</option>
                                                                @foreach ($heads as $expenseHead)
                                                                    <option value="{{ $expenseHead->id }}" @if($expenseHead->id == $head) selected @endif>
                                                                        {{ $expenseHead->title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="jsgrid-cell jsgrid-align-center" style="width: 100px;">
                                                            <select name="expense_subhead_id[]" class="form-control select-active w-100 form-select select-nice" required>
                                                                <option value="">Select Expense SubHead</option>
                                                                @foreach ($subHeads as $subHead)
                                                                    <option value="{{ $subHead->id }}" @if($subHead->id == $expense_subheads[$index]) selected @endif>
                                                                        {{ $subHead->title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="jsgrid-cell">
                                                            <input type="number" class="form-control quantity" name="quantity[]" value="{{ $quantities[$index] }}" required style="width:150px;">
                                                        </td>
                                                        <td class="jsgrid-cell">
                                                            <input type="number" class="form-control amount_head" name="amount_head[]" value="{{ $amount_heads[$index] }}" required style="width:150px;">
                                                        </td>
                                                        <td class="jsgrid-cell p-3 ml-2" style="width:50px;">
                                                            <a href="#" class="btn-space btn-sm btn btn-dark" onclick="plus()"><i class="fas fa-plus"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach


                                            </table>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="amount">Total Amount</label>
                                                <input id="totalamount" type="number" name="amount" class="form-control" value="{{ $expenses->amount }}" readonly>
                                            </div>
                                        </div>


                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="voucher_image">Voucher Upload <small class="text-danger">*</small></label>
                                                <input id="imageUpload" type="file" name="voucher_image" class="form-control" accept="image/*">
                                            </div>
                                            <div class="mt-2">
                                                @if($expenses->voucher_image)
                                                    <img id="imagePreview" src="{{ asset($expenses->voucher_image) }}" alt="Image Preview" style="max-width: 250px; max-height: 51px;">
                                                @else
                                                    <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 250px; max-height: 51px;">
                                                @endif
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="purpose">Purpose <small class="text-danger">*</small></label>
                                                <textarea class="form-control" name="purpose" id="purpose" cols="10" rows="3">{{ $expenses->purpose }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 pl-0">
                                            <p class="text-right">
                                                <a href="{{ route('expense.request.list') }}" class="btn btn-space btn-light btn-sm">Cancel</a>
                                                <button type="submit" class="btn btn-space btn-primary btn-sm">Update</button>
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
        $(document).on('change', 'tr.jsgrid-insert-row select[name="expense_head_id[]"]', function(e) {
            e.preventDefault();
            var headId = $(this).val();
            var $tr = $(this).closest('tr');
            $.ajax({
                type: 'GET',
                url: '/expense/subheads/' + headId,
                success: function(data) {
                    var expenseSubHead = data.sub_heads;
                    $tr.find('select[name="expense_subhead_id[]"]').empty();
                    $.each(expenseSubHead, function(key, value) {
                        $tr.find('select[name="expense_subhead_id[]"]').append(
                            '<option value="' + value.id + '">' + value.title + '</option>'
                        );
                    });
                }
            });
        });

        function calculateTotalAmount() {
            var totalAmount = 0;
            $('#expenseTable .append-coloum').each(function() {
                var amount = parseFloat($(this).find('.amount_head').val()) || 0;
                var quantity = parseFloat($(this).find('.quantity').val()) || 0;
                totalAmount += amount * quantity;
            });
            $('#totalamount').val(totalAmount.toFixed(2));
        }

        $(document).on('keyup', '.amount_head, .quantity', function() {
            calculateTotalAmount();
        });

        function plus() {
            $(".append-coloum:last").after(`
                <tr class="jsgrid-insert-row pb-4 append-coloum">
                    <td class="jsgrid-cell jsgrid-align-center" style="width: 100px;">
                        <select name="expense_head_id[]" class="form-control select-active w-100 form-select select-nice" id="expense_head_id" required>
                            <option value="">Select Expense Head</option>
                            @foreach ($heads as $expenseHead)
            <option value="{{ $expenseHead->id }}">{{ $expenseHead->title }}</option>
                            @endforeach
            </select>
        </td>
        <td class="jsgrid-cell jsgrid-align-center" style="width: 100px;">
            <select name="expense_subhead_id[]" class="form-control select-active w-100 form-select select-nice" id="expense_subhead_id" required>
                <option value="">Select Expense SubHead</option>
            </select>
        </td>
        <td class="jsgrid-cell">
            <input type="number" class="form-control quantity" name="quantity[]" required style="width:150px;">
        </td>
        <td class="jsgrid-cell">
            <input type="number" class="form-control amount_head" name="amount_head[]" required style="width:150px;">
        </td>
        <td class="jsgrid-cell p-3 ml-2" style="width:50px;">
            <a href="#" class="btn-space btn-sm btn btn-danger" onclick="removeElement(this)"><i class="fas fa-trash"></i></a>
        </td>
    </tr>
`);
        }

        function removeElement(e) {
            $(e).closest('.append-coloum').remove();
            calculateTotalAmount();
        }

        $('#imageUpload').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagePreview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endpush
