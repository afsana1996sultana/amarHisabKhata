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
                    <div class="col-xl-6 offset-xl-3 col-lg-10 offset-lg-1">
                        <div class="card">
                            <div class="card-header">
                                <h5 class=" float-left">Project Info Edit</h5>
                                <h4 class="float-right">
                                    @if(Auth::user()->user_role == 1 || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
                                        <a href="{{ route('project.index') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i class="fas fa-plus"></i> List</a>
                                    @endif
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('project.update', $project->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-12">
                                            <input id="lead_id" type="hidden" name="lead_id" class="form-control" value="{{$project->lead_id ?? ''}}">
                                            <div class="form-group from_group_mobile">
                                                <label>Customer Name<small class="text-danger">*</small></label>
                                                <select class="form-control select-active w-100 form-select select-nice" name="customer_name" id="customer_name">
                                                    <option value="0">Select Customer</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->lead_name }}"
                                                            {{ old('customer_name', $project->customer_name ?? '') == $customer->lead_name ? 'selected' : '' }}>
                                                            {{ $customer->lead_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="customer_phone">Customer Phone<small class="text-danger">*</small></label>
                                                <input id="customer_phone" type="number" name="customer_phone" value="{{$project->customer_phone}}" data-parsley-trigger="change" autocomplete="off" class="form-control" readonly>
                                            </div>
                                            @if ($errors->has('customer_phone'))
                                                <span class="text-danger">{{ $errors->first('customer_phone') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="customer_email">Customer Email </label>
                                                <input id="customer_email" type="email" name="customer_email" value="{{$project->customer_email}}" data-parsley-trigger="change" autocomplete="off" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="address">Address </label>
                                                <textarea class="form-control" name="address" id="address" cols="10" rows="3" readonly>{!! $project->address !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="project_name">Project Name<small class="text-danger">*</small></label>
                                                <input id="project_name" type="text"  name="project_name" value="{{$project->project_name}}" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                            </div>
                                            @if ($errors->has('project_name'))
                                                <span class="text-danger">{{ $errors->first('project_name') }}</span>
                                            @endif
                                        </div>
{{--                                        <div class="col-12 mt-3">--}}
{{--                                            <div class="form-group from_group_mobile">--}}
{{--                                                <label for="project_value">Project Value<small class="text-danger">*</small></label>--}}
{{--                                                <input id="project_value" type="number" name="project_value" value="{{$project->project_value}}" data-parsley-trigger="change" autocomplete="off" class="form-control">--}}
{{--                                            </div>--}}
{{--                                            @if ($errors->has('project_value'))--}}
{{--                                                <span class="text-danger">{{ $errors->first('project_value') }}</span>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 mt-3">--}}
{{--                                            <div class="form-group from_group_mobile">--}}
{{--                                                <label for="advance">Advance </label>--}}
{{--                                                <input id="advance" type="number" name="advance" value="{{$project->advance}}" data-parsley-trigger="change" autocomplete="off" class="form-control">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 mt-3">--}}
{{--                                            <div class="form-group from_group_mobile">--}}
{{--                                                <label for="paid" style="display: none">Paid </label>--}}
{{--                                                <input id="paid" type="hidden" name="paid" value="{{$project->paid}}" data-parsley-trigger="change" autocomplete="off" class="form-control">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-12 mt-3">--}}
{{--                                            <div class="form-group from_group_mobile">--}}
{{--                                                <label for="due">Due </label>--}}
{{--                                                <input id="due" type="number" name="due" value="{{$project->due}}" data-parsley-trigger="change" autocomplete="off" class="form-control" readonly>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="project_duration">Project Duration </label>
                                                <input id="project_duration" type="text" name="project_duration" value="{{$project->project_duration}}" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="description">Description </label>
                                                <textarea class="form-control" name="description" id="description" cols="10" rows="3">{!! $project->description !!}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="date">Date </label>
                                                <input id="date" type="date" name="date" value="{{ old('date', isset($project->date) ? $project->date : date('Y-m-d')) }}"
                                                       data-parsley-trigger="change" autocomplete="off" class="form-control">
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
        $(document).ready(function() {
            // Handle customer selection change
            $('#customer_name').on('change', function(){
                console.log('customer');
                var customer_name = $(this).val();
                console.log('custom', customer_name);
                if (customer_name != 0) {
                    $.ajax({
                        url: "{{ route('customerName.ajax', '') }}/" + customer_name,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log('Received Data', data);
                            $('#lead_id').val(data.lead_id);
                            $('#customer_phone').val(data.customer_phone);
                            $('#customer_email').val(data.customer_email);
                            $('#address').val(data.address);
                            $('#description').val(data.description);
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: " + error);
                        }
                    });
                } else {
                    // Clear the fields if no customer is selected
                    $('#lead_id').val('');
                    $('#customer_phone').val('');
                    $('#customer_email').val('');
                    $('#customer_phone').val('');
                    $('#address').val('');
                    $('#description').val('');
                }
            });


            /*
            function calculateDue() {
                var projectValue = parseFloat($('#project_value').val());
                var advance = parseFloat($('#advance').val());

                if (isNaN(projectValue)) projectValue = 0;
                if (isNaN(advance)) advance = 0;

                if (advance > projectValue) {
                    alert('Advance cannot be greater than Project Value!');
                    $('#advance').val('');
                    $('#due').val(projectValue);
                } else {
                    var due = projectValue - advance;

                    if (!isNaN(due)) {
                        $('#due').val(due);
                    }
                }
            }

            $('#project_value, #advance').on('input', function() {
                calculateDue();
            });

             */
        });

    </script>
@endpush

