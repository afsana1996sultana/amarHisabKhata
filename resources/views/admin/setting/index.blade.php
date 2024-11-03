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
                                <h4>Setting Info</h4>
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
                                <h5 class=" float-left">Setting Update</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('setting.store') }}" method="post" id="basicform"
                                    data-parsley-validate="" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="site_name">Site Name <small
                                                        class="text-danger">*</small></label>
                                                <input id="site_name" type="text" name="site_name"
                                                    value="{{ $setting->site_name ?? old('site_name') }}"
                                                    data-parsley-trigger="change" required="" autocomplete="off"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="site_title">Site Title <small
                                                        class="text-danger">*</small></label>
                                                <input id="site_title" type="text" name="site_title"
                                                    value="{{ $setting->site_title ?? old('site_title') }}"
                                                    data-parsley-trigger="change" required="" autocomplete="off"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group ">
                                                <label for="header_logo">Header logo <small class="text-success">(Preferred
                                                        size: 250X51)</small></label>
                                                <input id="imageUpload" type="file" name="header_logo"
                                                    data-parsley-trigger="change" autocomplete="off" class="form-control">
                                            </div>
                                            @if ($setting->header_logo)
                                                <img src="{{ asset($setting->header_logo) }}" id="imagePreview"
                                                    alt="Header Logo" class="custom-img">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" id="imagePreview"
                                                    alt="Header Logo" class="custom-img">
                                            @endif
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group ">
                                                <label for="footer_logo">Footer logo <small class="text-success">(Preferred
                                                        size: 250X51)</small></label>
                                                <input id="imageUpload1" type="file" name="footer_logo"
                                                    data-parsley-trigger="change" autocomplete="off" class="form-control">
                                            </div>
                                            @if ($setting->footer_logo)
                                                <img src="{{ asset($setting->footer_logo) }}" id="imagePreview1"
                                                    alt="Footer Logo" class="custom-img">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" id="imagePreview1"
                                                    alt="Footer Logo" class="custom-img">
                                            @endif
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group ">
                                                <label for="fav_icon">Fav Icon <small class="text-success">(Preferred size:
                                                        16X16)</small></label>
                                                <input id="imageUpload2" type="file" name="fav_icon"
                                                    data-parsley-trigger="change" autocomplete="off" class="form-control">
                                            </div>
                                            @if ($setting->fav_icon)
                                                <img src="{{ asset($setting->fav_icon) }}" id="imagePreview2"
                                                    alt="Footer Logo" class="custom-img">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" id="imagePreview2"
                                                    alt="Footer Logo" class="custom-img">
                                            @endif
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="contact_number">Contact Number </label>
                                                <input id="contact_number" type="text" name="contact_number"
                                                    value="{{ $setting->contact_number ?? old('contact_number') }}"
                                                    data-parsley-trigger="change" autocomplete="off"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="email">Email </label>
                                                <input id="email" type="email" name="email"
                                                    value="{{ $setting->email ?? old('email') }}"
                                                    data-parsley-trigger="change" autocomplete="off"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="fax">Fax </label>
                                                <input id="fax" type="text" name="fax"
                                                    value="{{ $setting->fax ?? old('fax') }}"
                                                    data-parsley-trigger="change" autocomplete="off"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="form-group from_group_mobile">
                                                <label for="prefix">Prefix </label>
                                                <input id="prefix" type="text" name="prefix"
                                                    value="{{ $setting->prefix ?? old('prefix') }}"
                                                    data-parsley-trigger="change" autocomplete="off"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group from_group_mobile">
                                                <label for="address">Address </label>
                                                <textarea class="form-control" name="address" id="address" cols="10" rows="3">{{ $setting->address }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 pl-0">
                                            <p class="text-right">
                                                <button type="submit"
                                                    class="btn btn-space btn-primary btn-sm">Update</button>
                                                <button type="reset"
                                                    class="btn btn-space btn-secondary btn-sm">Cancel</button>
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
            $('#imageUpload1').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        $('#imagePreview1').attr('src', event.target.result).show();
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#imagePreview1').hide();
                }
            });
            $('#imageUpload2').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        $('#imagePreview2').attr('src', event.target.result).show();
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#imagePreview2').hide();
                }
            });
        });
    </script>
@endpush
