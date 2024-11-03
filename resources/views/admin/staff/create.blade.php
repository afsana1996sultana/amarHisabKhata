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
                            <h4>Staff Info</h4>
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
                            <h5 class=" float-left">Staff Create</h5>
                            <h4 class="float-right">
                                @if(Auth::user()->user_role == 1 || in_array('6', json_decode(Auth::user()->staff->role->permissions)))
                                    <a href="{{ route('staff.index') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i class="fas fa-plus"></i> List</a>
                                @endif
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{route('staff.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="name">Staff Name <small class="text-danger"> *</small></label>
                                            <input id="name" type="text" name="name" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                        </div>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="email">Staff Email <small class="text-danger"> *</small></label>
                                            <input id="email" type="email" name="email" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                        </div>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="phone">Staff Phone <small class="text-danger"> *</small></label>
                                            <input id="phone" type="number" name="phone" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                        </div>
                                        @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="form-group from_group_mobile">
                                            <label for="password">Staff Password <small class="text-danger"> *</small></label>
                                            <input id="password" type="password" name="password" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 mt-3">
                                        <div class="form-group from_group_mobile">
                                            <label for="role">Role <small class="text-danger"> *</small></label>
                                            <select class="form-control select-active w-100 form-select select-nice" name="roles_id" id="roles_id">
                                                <option value="">Select Role</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('roles_id'))
                                            <span class="text-danger">{{ $errors->first('roles_id') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="address">Address </label>
                                            <textarea class="form-control" name="address" id="address" cols="10" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="image">Profile Image
                                                <small class="text-success">(Preferred size: 250X51)</small>
                                            </label>
                                            <input id="imageUpload" type="file" name="image" data-parsley-trigger="change" accept="image/*" autocomplete="off" class="form-control">
                                        </div>
                                        <div class="mt-2">
                                            <img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 250px; max-height: 51px;">
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



