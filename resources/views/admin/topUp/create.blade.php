@extends('admin.layouts.master')
@section('main-content')
<style>
    .form-group.from_group_mobile {
        display: flex;
    }

    .form-group.from_group_mobile label {
        width: 200px;
    }

    @media (max-width: 576px) {
        .form-group.from_group_mobile label {
            width: 215px;
        }
        input#mobile_number {
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
                            <h4>Top UP</h4>
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
                            <h5 class=" float-left">Top UP Create</h5>
                            <h4 class="float-right">
                                @if(Auth::user()->user_role == 1 || in_array('14', json_decode(Auth::user()->staff->role->permissions)))
                                    <a href="{{ route('top-up.index') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i class="fas fa-plus"></i>Back</a>
                                @endif
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('top-up.store') }}" method="post"  data-parsley-validate="">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="project_name">Project Name <small class="text-danger">*</small></label>
                                            <select name="project_name" id="project_name" class="form-control">
                                                <option value="">Select Project</option>
                                                @foreach($projects as $item)
                                                <option value="{{$item->project_name}}">{{$item->project_name}}</option>
                                                @endforeach
                                                <input type="hidden" class="form-control" name="project_id" id="project_id">
                                            </select>

                                            {{-- <input id="project_name" type="text" name="project_name" value="{{ old('project_name') }}" required="" class="form-control"> --}}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="purpose">Purpose <small class="text-danger">*</small></label>
                                            <input id="purpose" type="text" name="purpose" value="{{ old('purpose') }}" required="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="amount">Amount <small class="text-danger">*</small></label>
                                            <input id="amount" type="text" name="amount" value="{{ old('amount') }}" required="" class="form-control">
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
            $('#project_name').on('change', function() {
                var project_name = $(this).val();

                if (project_name != 0) {
                    $.ajax({
                        url: "{{ route('project-payment.ajax', '') }}/" + project_name,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#project_id').val(data.project_id);
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: " + error);
                        }
                    });
                } else {
                    $('#project_id').val('');
                }
            });

        });

    </script>
@endpush


