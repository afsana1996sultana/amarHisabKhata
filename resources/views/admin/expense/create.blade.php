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
                    <div class="col-xl-6 offset-xl-3 col-lg-10 offset-lg-1">
                        <div class="card">
                            <div class="card-header">
                                <h5 class=" float-left">Expense Create</h5>
                                <h4 class="float-right">
                                    @if(Auth::user()->user_role == 1 || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
                                        <a href="{{ route('expense.request.list') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i class="fas fa-plus"></i> List</a>
                                    @endif
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('expense.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="expense_head_id">Expense Head<small class="text-danger">*</small></label>
                                                    <select class="form-control select-active w-100 form-select select-nice" name="expense_head_id" id="expense_head_id">
                                                    <option value="">Select Expense Head</option>
                                                    @foreach($heads as $head)
                                                        <option value="{{ $head->id }}">{{ $head->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="expense_subhead_id">Expense Sub-Head</label>
                                                <select class="form-control select-active w-100 form-select select-nice" name="expense_subhead_id" id="expense_subhead_id">
                                                    <option value="">Select Expense Sub-Head</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="type">Expense Type <small class="text-danger">*</small></label>
                                                <select class="form-control select-active w-100 form-select select-nice" name="type" id="type">
                                                    <option value="">Select Type</option>
                                                    <option value="Project Wish">Project Wish</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3" id="project_section" style="display: none;">
                                            <div class="form-group from_group_mobile">
                                                <label for="project_id">Project <small class="text-danger">*</small></label>
                                                <select class="form-control select-active w-100 form-select select-nice" name="project_id" id="project_id">
                                                    <option value="">Select Project</option>
                                                    @foreach($projects as $project)
                                                        <option value="{{ $project->project_name }}">{{ $project->project_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="amount">Amount <small class="text-danger">*</small></label>
                                                <input id="amount" type="number" name="amount" autocomplete="off" class="form-control">
                                            </div>
                                            @if ($errors->has('amount'))
                                                <span class="text-danger">{{ $errors->first('amount') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="voucher_image">Voucher Upload <small class="text-danger">*</small>
                                                    <small class="text-success">(Preferred size: 250X51)</small>
                                                </label>
                                                <input id="imageUpload" type="file" name="voucher_image" data-parsley-trigger="change" accept="image/*" autocomplete="off" class="form-control" required>
                                            </div>
                                            <div class="mt-2">
                                                <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 250px; max-height: 51px;">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="purpose">Purpose <small class="text-danger">*</small></label>
                                                <textarea class="form-control" name="purpose" id="purpose" cols="10" rows="3"></textarea>
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
        $('#expense_head_id').on('change', function() {
            var headId = $(this).val();

            if(headId != 0) {
                var url = '/expense/subheads/' + headId;
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        var subHeadSelect = $('#expense_subhead_id');
                        subHeadSelect.empty();
                        subHeadSelect.append('<option value="">Select Expense Sub-Head</option>');

                        $.each(data, function(key, subHead) {
                            subHeadSelect.append('<option value="' + subHead.id + '">' + subHead.title + '</option>');
                        });
                    }
                });
            } else {
                $('#expense_subhead_id').empty();
                $('#expense_subhead_id').append('<option value="">Select Expense Sub-Head</option>');
            }
        });

        $('#type').on('change', function() {
            var selectedType = $(this).val();
            if (selectedType === "Project Wish") {
                $('#project_section').show();
            } else {
                $('#project_section').hide();
            }
        });
    </script>
    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                imagePreview.src = '#';
            }
        });
    </script>
@endpush



