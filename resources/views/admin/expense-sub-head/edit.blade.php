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
                            <h4>Account Sub-Heads</h4>
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
                            <h5 class=" float-left">Account Sub-Heads Create</h5>
                            <h4 class="float-right">
                                @if(Auth::user()->user_role == 1 || in_array('18', json_decode(Auth::user()->staff->role->permissions)))
                                    <a href="{{ route('expense-sub-head.index') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i class="fas fa-plus"></i>Back</a>
                                @endif
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('expense-sub-head.update', $subHead->id) }}" method="post" id="basicform" data-parsley-validate="" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label>Expense Head<small class="text-danger">*</small></label>
                                            <select class="form-control select-active w-100 form-select select-nice" name="expense_head_id">
                                                <option value="0" disabled selected>Select Expense Head</option>
                                                @foreach($heads as $head)
                                                    <option value="{{ $head->id }}" {{$subHead->expense_head_id == $head->id ? 'selected':''}}>{{ $head->title ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="title">Title <small class="text-danger">*</small></label>
                                            <input id="title" type="text" name="title" value="{{ $subHead->title ?? "N/A" }}" required="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="form-check-input me-2 cursor" name="status" id="status" {{ $subHead->status == 1 ? 'checked': '' }} value="1">
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
