@extends('admin.layouts.master')
@section('main-content')
    <style>
        .form-group.from_group_mobile {
            display: flex;
        }


        .form-group.from_group_mobile label {
            width: 250px;
        }
        td.jsgrid-cell {
            padding: 5px;
        }

        table#expenseTable {
            width: -webkit-fill-available;
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
            <!-- ============================================================== -->
            <!-- pageheader  -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title"></h2>
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
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
                        <div class="card">
                            <div class="card-header">
                                <h5 class=" float-left">Expense Create</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{route('expense.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="project_id">Project Name<small class="text-danger">*</small></label>
                                                <select class="form-control select-active w-100 form-select select-nice"
                                                        name="project_id" id="project_id">
                                                    <option value="">Select Project</option>
                                                    @foreach($projects as $project)
                                                        <option
                                                            value="{{ $project->id }}">{{ $project->project_name }}</option>
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


                                                <tr class="jsgrid-insert-row pb-4 append-coloum">
                                                    <td class="jsgrid-cell jsgrid-align-center" style="width: 100px;">
                                                        <select name="expense_head_id[]"
                                                                class="form-control select-active w-100 form-select select-nice"
                                                                id="expense_head_id" required>
                                                            <option value="">Select Expense Head</option>
                                                            @foreach ($heads as $expense)
                                                                <option
                                                                    value="{{ $expense->id }}">{{ $expense->title }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('expense_head_id[]')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center" style="width: 100px;">
                                                        <select name="expense_subhead_id[]"
                                                                class="form-control select-active w-100 form-select select-nice"
                                                                id="expense_subhead_id" required>
                                                            <option value="">Select Expense SubHead</option>
                                                        </select>
                                                        @error('expense_subhead_id[]')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="jsgrid-cell">
                                                        <input type="number" class="form-control quantity"
                                                               name="quantity[]" required
                                                               style="width:170px; height: 38px;">
                                                        @error('quantity')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="jsgrid-cell">
                                                        <input type="number" class="form-control amount_head"
                                                               name="amount_head[]" required
                                                               style="width:170px; height: 38px;">
                                                        @error('amount_head')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                    <td class="jsgrid-cell p-3 ml-2" style="width:50px;">
                                                        <a href="#" class="add-row btn-space btn btn-sm btn-dark"
                                                           onclick="plus()"><i
                                                                class="fas fa-plus"></i></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="amount">Total Amount</label>
                                                <input id="totalamount" type="number" name="amount" autocomplete="off"
                                                       class="form-control" readonly>
                                            </div>
                                            @if ($errors->has('amount'))
                                                <span class="text-danger">{{ $errors->first('amount') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="voucher_image">Voucher Upload <small
                                                        class="text-danger">*</small>
                                                    <small class="text-success">(Preferred size: 250X51)</small>
                                                </label>
                                                <input id="imageUpload" type="file" name="voucher_image"
                                                       data-parsley-trigger="change" accept="image/*" autocomplete="off"
                                                       class="form-control">
                                            </div>
                                            <div class="mt-2">
                                                <img id="imagePreview" src="#" alt="Image Preview"
                                                     style="display: none; max-width: 250px; max-height: 51px;">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="purpose">Purpose <small
                                                        class="text-danger">*</small></label>
                                                <textarea class="form-control" name="purpose" id="purpose" cols="10"
                                                          rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 pl-0">
                                            <p class="text-right">
                                                @if(Auth::user()->user_role == 1 || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
                                                    <a href="{{route('expense.request.list')}}" class="btn btn-space btn-light btn-sm">Cancel</a>
                                                @endif

                                                <button type="submit" class="btn btn-space btn-primary btn-sm">Submit
                                                </button>
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
                    //console.log('data ki ase', expenseSubHead);
                    $tr.find('select[name="expense_subhead_id[]"]')
                        .empty();
                    $.each(expenseSubHead, function(key, value) {
                        $tr.find('select[name="expense_subhead_id[]"]').append(
                            '<option value="' + value.id + '">' + value.title +
                            '</option>'
                        );
                    });
                },
                error: function(xhr, status, error) {
                    //console.error(xhr.responseText);
                }
            });
        });


        document.getElementById('imageUpload').addEventListener('change', function (event) {
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


        function calculateTotalAmount() {
            var totalAmount = 0;


            $('#expenseTable .append-coloum').each(function () {
                var amount = parseFloat($(this).find('.amount_head').val()) || 0;
                var quantity = parseFloat($(this).find('.quantity').val()) || 0;
                totalAmount += amount * quantity;
            });

            $('#totalamount').val(totalAmount.toFixed(2));
        }


        $(document).on('keyup', '.amount_head, .quantity', function () {
            calculateTotalAmount();
        });


        function plus() {
            $(".append-coloum:last").after(`
        <tr class="jsgrid-insert-row pb-4 append-coloum">
            <td class="jsgrid-cell jsgrid-align-center" style="width: 100px;">
                <select name="expense_head_id[]" class="form-control select-active w-100 form-select select-nice" id="expense_head_id" required>
                    <option value="">Select Expense Head</option>
                    @foreach ($heads as $expense)
            <option value="{{ $expense->id }}">{{ $expense->title }}</option>
                    @endforeach
            </select>
        </td>
        <td class="jsgrid-cell jsgrid-align-center" style="width: 100px;">
            <select name="expense_subhead_id[]" class="form-control select-active w-100 form-select select-nice" id="expense_subhead_id" required>
                <option value="">Select Expense SubHead</option>
            </select>
        </td>
        <td class="jsgrid-cell">
            <input type="number" class="form-control quantity" name="quantity[]" required style="width:170px; height: 38px;">
        </td>
        <td class="jsgrid-cell">
            <input type="number" class="form-control amount_head" name="amount_head[]" required style="width:170px; height: 38px;">
        </td>
        <td class="jsgrid-cell p-3 ml-2" style="width:50px;">
            <a href="#" class="add-row btn-space btn-sm btn btn-danger" onclick="removeElement(this)"><i class="fas fa-trash"></i></a>
        </td>
    </tr>
`);
        }



        function removeElement(button) {
            $(button).closest('.append-coloum').remove();
            calculateTotalAmount();
        }

    </script>
@endpush



