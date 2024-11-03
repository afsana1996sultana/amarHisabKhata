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

    .checkbox_custom {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
    }

    .form-check-label {
        font-weight: bold;
        cursor: pointer;
        padding: 5px 10px;
    }

    .list-group-item {
        border: 1px solid #dee2e6;
    }

    .form-check-input {
        width: 25px;
        height: 20px;
        margin-right: 10px;
        cursor: pointer;
    }
    .all_permission {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .permission-form-check-input {
        width: 20px;
        height: 20px;
        margin-right: 12px;
        cursor: pointer;
        accent-color: #007bff;
    }

    .dashboard-permission-form-check-input {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #007bff;
    }

    .permission_level {
        font-weight: bold;
        font-size: 1.1rem;
        cursor: pointer;
        margin-bottom: auto;
    }

    .form-check {
        height: 30px !important;
    }
    .list-group-item.bg-light {
        font-size: 18px;
        font-weight: bold;
    }
</style>

<div class="dashboard-ecommerce">
    <div class="container-fluid dashboard-content">
        <!-- pageheader -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title"></h2>
                    <p class="pageheader-text"></p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <h4>Role Information</h4>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- end pageheader -->
        <div class="ecommerce-widget">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 col-lg-10 offset-lg-1">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="float-left">Role Permission Create</h5>
                            <h4 class="float-right">
                                @if(Auth::user()->user_role == 1 || in_array('10', json_decode(Auth::user()->staff->role->permissions)))
                                    <a href="{{ route('roles.index') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px">
                                        <i class="fas fa-plus"></i>Back
                                    </a>
                                @endif
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('roles.store') }}" method="post" id="basicform" data-parsley-validate="" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group from_group_mobile">
                                            <label for="name">Name <small class="text-danger">*</small></label>
                                            <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Name" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <h5 class="">Permissions</h5>
                                </div>
                                <hr>
                                <div class="all_permission">
                                    <input type="checkbox" id="selectAll" class="permission-form-check-input">
                                    <label for="selectAll" class="permission_level">Select All Permissions</label>
                                </div><br>

                                <div class="bd-example">
                                    <ul class="list-group">
                                        <li class="list-group-item bg-light" aria-current="true"> <input type="checkbox" id="dashboardSelect" class="dashboard-permission-form-check-input"> Dashboard</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <!-- Total Lead -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox1" name="permissions[]" value="1">
                                                            <label class="form-check-label" for="checkbox1">Total Lead</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Total Customer -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox2" name="permissions[]" value="2">
                                                            <label class="form-check-label" for="checkbox2">Total Customer</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Current Project -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox3" name="permissions[]" value="3">
                                                            <label class="form-check-label" for="checkbox3">Current Project</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Total Project -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox4" name="permissions[]" value="4">
                                                            <label class="form-check-label" for="checkbox4">Total Project</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Total Expense Value -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox5" name="permissions[]" value="5">
                                                            <label class="form-check-label" for="checkbox5">Total Expense Value</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Total Staff -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox6" name="permissions[]" value="6">
                                                            <label class="form-check-label" for="checkbox6">Total Staff</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Total Project Value -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox7" name="permissions[]" value="7">
                                                            <label class="form-check-label" for="checkbox7">Total Project Value</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Current Project Value -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox8" name="permissions[]" value="8">
                                                            <label class="form-check-label" for="checkbox8">Current Project Value</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>


                                <div class="bd-example">
                                    <ul class="list-group">
                                        <li class="list-group-item bg-light" aria-current="true"> <input type="checkbox" id="leadSelect" class="dashboard-permission-form-check-input"> Lead</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <!-- Lead List -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox9" name="permissions[]" value="9">
                                                            <label class="form-check-label" for="checkbox9">Lead List</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Lead Create -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox10" name="permissions[]" value="10">
                                                            <label class="form-check-label" for="checkbox10">Lead Create</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Lead Edit -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox11" name="permissions[]" value="11">
                                                            <label class="form-check-label" for="checkbox11">Lead Edit</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Lead Delete -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox12" name="permissions[]" value="12">
                                                            <label class="form-check-label" for="checkbox12">Lead Delete</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>


                                <div class="bd-example">
                                    <ul class="list-group">
                                        <li class="list-group-item bg-light" aria-current="true"> <input type="checkbox" id="customerSelect" class="dashboard-permission-form-check-input"> Customer</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <!-- Customer List -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox13" name="permissions[]" value="13">
                                                            <label class="form-check-label" for="checkbox13">Customer List</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Customer Edit -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox14" name="permissions[]" value="14">
                                                            <label class="form-check-label" for="checkbox14">Customer Edit</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Customer View -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox15" name="permissions[]" value="15">
                                                            <label class="form-check-label" for="checkbox15">Customer View</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Customer Delete -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox16" name="permissions[]" value="16">
                                                            <label class="form-check-label" for="checkbox16">Customer Delete</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>


                                <div class="bd-example">
                                    <ul class="list-group">
                                        <li class="list-group-item bg-light" aria-current="true"> <input type="checkbox" id="projectSelect" class="dashboard-permission-form-check-input"> Project</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <!-- Show All Project -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox17" name="permissions[]" value="17">
                                                            <label class="form-check-label" for="checkbox17">Show All Project</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Add New Project -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox18" name="permissions[]" value="18">
                                                            <label class="form-check-label" for="checkbox18">Add New Project</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Project Edit -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox19" name="permissions[]" value="19">
                                                            <label class="form-check-label" for="checkbox19">Project Edit</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Project Delete -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox20" name="permissions[]" value="20">
                                                            <label class="form-check-label" for="checkbox20">Project Delete</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>

                                <div class="bd-example">
                                    <ul class="list-group">
                                        <li class="list-group-item bg-light" aria-current="true"> <input type="checkbox" id="staffSelect" class="dashboard-permission-form-check-input"> Staff</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <!-- Show All Staff -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox21" name="permissions[]" value="21">
                                                            <label class="form-check-label" for="checkbox21">Show All Staff</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Add New Staff -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox22" name="permissions[]" value="22">
                                                            <label class="form-check-label" for="checkbox22">Add New Staff</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Staff Edit -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox23" name="permissions[]" value="23">
                                                            <label class="form-check-label" for="checkbox23">Staff Edit</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Staff Delete -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox24" name="permissions[]" value="24">
                                                            <label class="form-check-label" for="checkbox24">Staff Delete</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>

                                <div class="bd-example">
                                    <ul class="list-group">
                                        <li class="list-group-item bg-light" aria-current="true"> <input type="checkbox" id="staffPermissionSelect" class="dashboard-permission-form-check-input"> Staff Role & Permission</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <!-- Show All Staff Role & Permission -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox25" name="permissions[]" value="25">
                                                            <label class="form-check-label" for="checkbox25">Show All Staff Role & Permission</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Add New Staff Role & Permission -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox26" name="permissions[]" value="26">
                                                            <label class="form-check-label" for="checkbox26">Add New Staff Role & Permission</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Staff Role & Permission Edit -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox27" name="permissions[]" value="27">
                                                            <label class="form-check-label" for="checkbox27">Staff Role & Permission Edit</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Staff Role & Permission Delete -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox28" name="permissions[]" value="28">
                                                            <label class="form-check-label" for="checkbox28">Staff Role & Permission Delete</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>

                                <div class="bd-example">
                                    <ul class="list-group">
                                        <li class="list-group-item bg-light" aria-current="true"> <input type="checkbox" id="accountSelect" class="dashboard-permission-form-check-input"> Accounts(Expense)</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <!-- Show All Expense Head-->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox29" name="permissions[]" value="29">
                                                            <label class="form-check-label" for="checkbox29">Show All Expense Head</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Add New Expense Head-->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox30" name="permissions[]" value="30">
                                                            <label class="form-check-label" for="checkbox30">Add New Expense Head</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Expense Head Update -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox31" name="permissions[]" value="31">
                                                            <label class="form-check-label" for="checkbox31">Expense Head Update</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Expense Sub-Head Delete-->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox32" name="permissions[]" value="32">
                                                            <label class="form-check-label" for="checkbox32">Expense Head Delete</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Show All Expense Sub-Head-->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox33" name="permissions[]" value="33">
                                                            <label class="form-check-label" for="checkbox33">Show All Expense Sub-Head</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Add New Expense Sub-Head-->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox34" name="permissions[]" value="34">
                                                            <label class="form-check-label" for="checkbox34">Add New Expense Sub-Head</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Expense Sub-Head Update -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox35" name="permissions[]" value="35">
                                                            <label class="form-check-label" for="checkbox35">Expense Sub-Head Update</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Expense Sub-Head Delete-->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox36" name="permissions[]" value="36">
                                                            <label class="form-check-label" for="checkbox36">Expense Sub-Head Delete</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Show All Expense -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox37" name="permissions[]" value="37">
                                                            <label class="form-check-label" for="checkbox37">Show All Expense</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Add New Expense -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox38" name="permissions[]" value="38">
                                                            <label class="form-check-label" for="checkbox38">Add New Expense</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Expense Update -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox39" name="permissions[]" value="39">
                                                            <label class="form-check-label" for="checkbox39">Expense Update</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Expense Delete-->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox40" name="permissions[]" value="40">
                                                            <label class="form-check-label" for="checkbox40">Expense Delete</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>

                                <div class="bd-example">
                                    <ul class="list-group">
                                        <li class="list-group-item bg-light" aria-current="true"> <input type="checkbox" id="accountTopUpSelect" class="dashboard-permission-form-check-input"> Accounts(TopUp)</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <!--Show All TopUp -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox41" name="permissions[]" value="41">
                                                            <label class="form-check-label" for="checkbox41">Show All TopUp List</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- TopUp Create -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox42" name="permissions[]" value="42">
                                                            <label class="form-check-label" for="checkbox42">TopUp Create</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- TopUp Update -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox43" name="permissions[]" value="43">
                                                            <label class="form-check-label" for="checkbox43">TopUp Update</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- TopUp Delete -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox44" name="permissions[]" value="44">
                                                            <label class="form-check-label" for="checkbox44">TopUp Delete</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>


                                <div class="bd-example">
                                    <ul class="list-group">
                                        <li class="list-group-item bg-light" aria-current="true"> <input type="checkbox" id="paymentSelect" class="dashboard-permission-form-check-input"> Payments</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <!--Show All Payment -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox45" name="permissions[]" value="45">
                                                            <label class="form-check-label" for="checkbox45">Show All Payment</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Payment Create -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox46" name="permissions[]" value="46">
                                                            <label class="form-check-label" for="checkbox46">Payment Create</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Payment Delete -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox47" name="permissions[]" value="47">
                                                            <label class="form-check-label" for="checkbox47">Payment Delete</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>

                                <div class="bd-example">
                                    <ul class="list-group">
                                        <li class="list-group-item bg-light" aria-current="true"> <input type="checkbox" id="depositSelect" class="dashboard-permission-form-check-input"> Deposit</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <!--Show All Deposit -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox48" name="permissions[]" value="48">
                                                            <label class="form-check-label" for="checkbox48">Show All Deposit</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Deposit Create -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox49" name="permissions[]" value="49">
                                                            <label class="form-check-label" for="checkbox49">Deposit Create</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                 <!-- Deposit Edit -->
                                                 <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox50" name="permissions[]" value="50">
                                                            <label class="form-check-label" for="checkbox50">Deposit Edit</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Deposit Delete -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox51" name="permissions[]" value="51">
                                                            <label class="form-check-label" for="checkbox51">Deposit Delete</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>

                                <div class="bd-example">
                                    <ul class="list-group">
                                        <li class="list-group-item bg-light" aria-current="true"> <input type="checkbox" id="withdrawSelect" class="dashboard-permission-form-check-input"> Withdraw</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <!--Show All Withdraw -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox52" name="permissions[]" value="52">
                                                            <label class="form-check-label" for="checkbox52">Show All Withdraw</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Withdraw Create -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox53" name="permissions[]" value="53">
                                                            <label class="form-check-label" for="checkbox53">Withdraw Create</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                 <!-- Withdraw Edit -->
                                                 <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox54" name="permissions[]" value="54">
                                                            <label class="form-check-label" for="checkbox54">Withdraw Edit</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Withdraw Delete -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox55" name="permissions[]" value="55">
                                                            <label class="form-check-label" for="checkbox55">Withdraw Delete</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>

                                <div class="bd-example">
                                    <ul class="list-group">
                                        <li class="list-group-item bg-light" aria-current="true"> <input type="checkbox" id="reportsSelect" class="dashboard-permission-form-check-input"> Reports</li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <!-- All Income Report -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox56" name="permissions[]" value="56">
                                                            <label class="form-check-label" for="checkbox56">All Income Report</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- All Expense Report -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox57" name="permissions[]" value="57">
                                                            <label class="form-check-label" for="checkbox57">All Expense Report</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Project Wish Profit/Loss -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox58" name="permissions[]" value="58">
                                                            <label class="form-check-label" for="checkbox58">Project Wish Profit/Loss</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- All Profit/Loss -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox59" name="permissions[]" value="59">
                                                            <label class="form-check-label" for="checkbox59">All Profit/Loss</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- All Payment Report -->
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                    <div class="p-2 border mt-1 mb-4 checkbox_custom">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkbox60" name="permissions[]" value="60">
                                                            <label class="form-check-label" for="checkbox60">All Payment Report</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div><br>
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
    $(document).ready(function(){
        $('#selectAll').click(function() {
            $('.form-check-input').prop('checked', this.checked);
        });

        $('.form-check-input').click(function() {
            if ($('.form-check-input:checked').length == $('.form-check-input').length) {
                $('#selectAll').prop('checked', true);
            } else {
                $('#selectAll').prop('checked', false);
            }
        });
    });
</script>

<script>
    document.getElementById("dashboardSelect").addEventListener("change", function() {
        const isChecked = this.checked;
        const checkboxes = [
            document.getElementById("checkbox1"),
            document.getElementById("checkbox2"),
            document.getElementById("checkbox3"),
            document.getElementById("checkbox4"),
            document.getElementById("checkbox5"),
            document.getElementById("checkbox6"),
            document.getElementById("checkbox7"),
            document.getElementById("checkbox8")
        ];

        checkboxes.forEach(checkbox => {
            if (checkbox) checkbox.checked = isChecked;
        });
    });

    document.getElementById("leadSelect").addEventListener("change", function() {
        const isChecked = this.checked;
        const checkboxes = [
            document.getElementById("checkbox9"),
            document.getElementById("checkbox10"),
            document.getElementById("checkbox11"),
            document.getElementById("checkbox12")
        ];

        checkboxes.forEach(checkbox => {
            if (checkbox) checkbox.checked = isChecked;
        });
    });

    document.getElementById("customerSelect").addEventListener("change", function() {
        const isChecked = this.checked;
        const checkboxes = [
            document.getElementById("checkbox13"),
            document.getElementById("checkbox14"),
            document.getElementById("checkbox15"),
            document.getElementById("checkbox16")
        ];

        checkboxes.forEach(checkbox => {
            if (checkbox) checkbox.checked = isChecked;
        });
    });

    document.getElementById("projectSelect").addEventListener("change", function() {
        const isChecked = this.checked;
        const checkboxes = [
            document.getElementById("checkbox17"),
            document.getElementById("checkbox18"),
            document.getElementById("checkbox19"),
            document.getElementById("checkbox20")
        ];

        checkboxes.forEach(checkbox => {
            if (checkbox) checkbox.checked = isChecked;
        });
    });

    document.getElementById("staffSelect").addEventListener("change", function() {
        const isChecked = this.checked;
        const checkboxes = [
            document.getElementById("checkbox21"),
            document.getElementById("checkbox22"),
            document.getElementById("checkbox23"),
            document.getElementById("checkbox24")
        ];

        checkboxes.forEach(checkbox => {
            if (checkbox) checkbox.checked = isChecked;
        });
    });

    document.getElementById("staffPermissionSelect").addEventListener("change", function() {
        const isChecked = this.checked;
        const checkboxes = [
            document.getElementById("checkbox25"),
            document.getElementById("checkbox26"),
            document.getElementById("checkbox27"),
            document.getElementById("checkbox28")
        ];

        checkboxes.forEach(checkbox => {
            if (checkbox) checkbox.checked = isChecked;
        });
    });

    document.getElementById("accountSelect").addEventListener("change", function() {
        const isChecked = this.checked;
        const checkboxes = [
            document.getElementById("checkbox29"),
            document.getElementById("checkbox30"),
            document.getElementById("checkbox31"),
            document.getElementById("checkbox32"),
            document.getElementById("checkbox33"),
            document.getElementById("checkbox34"),
            document.getElementById("checkbox35"),
            document.getElementById("checkbox36"),
            document.getElementById("checkbox37"),
            document.getElementById("checkbox38"),
            document.getElementById("checkbox39"),
            document.getElementById("checkbox40")
        ];

        checkboxes.forEach(checkbox => {
            if (checkbox) checkbox.checked = isChecked;
        });
    });

    document.getElementById("accountTopUpSelect").addEventListener("change", function() {
        const isChecked = this.checked;
        const checkboxes = [
            document.getElementById("checkbox41"),
            document.getElementById("checkbox42"),
            document.getElementById("checkbox43"),
            document.getElementById("checkbox44")
        ];

        checkboxes.forEach(checkbox => {
            if (checkbox) checkbox.checked = isChecked;
        });
    });

    document.getElementById("paymentSelect").addEventListener("change", function() {
        const isChecked = this.checked;
        const checkboxes = [
            document.getElementById("checkbox45"),
            document.getElementById("checkbox46"),
            document.getElementById("checkbox47")
        ];

        checkboxes.forEach(checkbox => {
            if (checkbox) checkbox.checked = isChecked;
        });
    });

    document.getElementById("depositSelect").addEventListener("change", function() {
        const isChecked = this.checked;
        const checkboxes = [
            document.getElementById("checkbox48"),
            document.getElementById("checkbox49"),
            document.getElementById("checkbox50"),
            document.getElementById("checkbox51")
        ];

        checkboxes.forEach(checkbox => {
            if (checkbox) checkbox.checked = isChecked;
        });
    });

    document.getElementById("withdrawSelect").addEventListener("change", function() {
        const isChecked = this.checked;
        const checkboxes = [
            document.getElementById("checkbox52"),
            document.getElementById("checkbox53"),
            document.getElementById("checkbox54"),
            document.getElementById("checkbox55")
        ];

        checkboxes.forEach(checkbox => {
            if (checkbox) checkbox.checked = isChecked;
        });
    });

    document.getElementById("reportsSelect").addEventListener("change", function() {
        const isChecked = this.checked;
        const checkboxes = [
            document.getElementById("checkbox56"),
            document.getElementById("checkbox57"),
            document.getElementById("checkbox58"),
            document.getElementById("checkbox59"),
            document.getElementById("checkbox60")
        ];

        checkboxes.forEach(checkbox => {
            if (checkbox) checkbox.checked = isChecked;
        });
    });
</script>
@endpush
