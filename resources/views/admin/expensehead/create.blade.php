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
                            <h4>Account Heads</h4>
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
                            <h5 class=" float-left">Account Heads Create</h5>
                            <h4 class="float-right">
                                @if(Auth::user()->user_role == 1 || in_array('14', json_decode(Auth::user()->staff->role->permissions)))
                                    <a href="{{ route('expense-head.index') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i class="fas fa-plus"></i>Back</a>
                                @endif
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('expense-head.store') }}" method="post" id="basicform" data-parsley-validate="" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="title">Title <small class="text-danger">*</small></label>
                                            <input id="title" type="text" name="title" value="{{ old('title') }}" required="" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="form-check-input me-2 cursor" name="status" id="status" checked value="1">
                                            <label class="form-check-label cursor" for="status">Status</label>
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
@endpush
