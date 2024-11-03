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
                            <h4>Withdraw</h4>
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
                            <h5 class=" float-left">Withdraw Create</h5>
                            <h4 class="float-right">
                                @if(Auth::user()->user_role == 1 || in_array('14', json_decode(Auth::user()->staff->role->permissions)))
                                    <a href="{{ route('withdraw.index') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i class="fas fa-plus"></i>Back</a>
                                @endif
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('withdraw.store') }}" method="post"  data-parsley-validate="">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="date">Date <small class="text-danger">*</small></label>
                                           <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="amount">Amount <small class="text-danger">*</small></label>
                                            <input id="amount" type="number" name="amount" value="{{ old('amount') }}" placeholder="enter amount" required="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="purpose">Purpose <small class="text-danger">*</small></label>
                                            <textarea name="purpose" class="form-control" id="purpose" cols="30" rows="2" placeholder="write your purpose..."></textarea>
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
