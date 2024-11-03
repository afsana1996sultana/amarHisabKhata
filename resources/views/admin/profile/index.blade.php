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

        input#current_password {
            height: 35px;
        }

        input#confirm_password {
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
                            <h4>Profile Update</h4>
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
                <div class="col-xl-3 col-lg-4">
                    <div class="card">
                        <div class="employee__history__photo">
                            @if ($user->image)
                                <img style="height: 120px;width: 120px;border-radius: 50%; margin-left: 170px"
                                     src="{{ asset($user->image) }}" alt="">
                            @else
                                <img style="height: 120px;width: 120px;border-radius: 50%"
                                     src="{{ asset('/images/employee/female.webp') }}" alt="">
                            @endif
                            <h3 class="employee_name"></h3>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Name</strong>
                                <span>{{$user->name ?? ''}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Email</strong>
                                <span>{{$user->email ?? ''}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Phone</strong>
                                <span>{{$user->phone ?? ''}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong>Address</strong>
                                <span>{!! $user->address ?? '' !!}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Profile Update Section -->
                <div class="col-xl-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class=" float-left">Profile Update</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="post" id="basicform" data-parsley-validate="" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="site_name">Name</label>
                                            <input id="site_name" type="text" name="name" value="{{ Auth::user()->name ?? old('name') }}" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="email">Email</label>
                                            <input id="email" type="text" name="email" readonly value="{{ Auth::user()->email ?? old('email') }}" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="phone">Phone </label>
                                            <input id="phone" type="text" name="phone" value="{{ Auth::user()->phone ?? old('phone') }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="image">Profile Image <small class="text-success">(Preferred size: 250X51)</small></label>
                                            <input id="imageUpload" type="file" name="image" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                        </div>
                                        @if(Auth::user()->image)
                                            <img src="{{ asset(Auth::user()->image) }}" id="imagePreview" alt="image" class="custom-img">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" id="imagePreview" alt="image" class="custom-img">
                                        @endif
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="form-group from_group_mobile">
                                            <label for="phone">Address </label>
                                            <textarea name="address" id="address" cols="30" class="form-control" rows="2">{{ Auth::user()->address ?? "" }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 pl-0">
                                        <p class="text-right">
                                            <button type="submit" class="btn btn-space btn-primary btn-sm">Update</button>
                                            <button type="reset" class="btn btn-space btn-secondary btn-sm">Cancel</button>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Password Update Section -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class=" float-left">Password Update</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.updatePass') }}" method="post" id="basicform" data-parsley-validate="" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="current_password">Current Password</label>
                                            <input id="current_password" type="password" name="current_password" value="" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="new_password">New Password </label>
                                            <input id="new_password" type="password" name="new_password" value="" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="confirm_password">Confirm Password </label>
                                            <input id="confirm_password" type="password" name="confirm_password" value="" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 pl-0">
                                        <p class="text-right">
                                            <button type="submit" class="btn btn-space btn-primary btn-sm">Update</button>
                                            <button type="reset" class="btn btn-space btn-secondary btn-sm">Cancel</button>
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
    $(document).ready(function() {
        $('#imageUpload').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#imagePreview').attr('src', event.target.result).show();
                }
                reader.readAsDataURL(file);
            } else {
                $('#imagePreview').hide();
            }
        });
    });
</script>
@endpush
