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
                                <h4>Lead Info</h4>
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
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1">
                        <div class="card">
                            <div class="card-header">
                                <h5 class=" float-left">Lead Info Edit</h5>
                                <h4 class="float-right">
                                    <a href="{{ route('lead.index') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i class="fas fa-plus"></i> List</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('lead.update', $lead->id) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="name" class="control-label mb-1">Lead Name <span class="text-danger">*</span></label>
                                                <input id="name" name="lead_name" type="text" class="form-control @error('lead_name') is-invalid @enderror" value="{{$lead->lead_name ?? ''}}" placeholder="lead name">
                                                @error('lead_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="phone" class="control-label mb-1">Lead Phone <span class="text-danger">*</span></label>
                                                <input id="phone" name="lead_phone" type="number" class="form-control @error('lead_phone') is-invalid @enderror" value="{{$lead->lead_phone ?? ''}}" placeholder="lead phone" >
                                                @error('lead_phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="email" class="control-label mb-1">Lead Email</label>
                                                <input id="email" name="email" type="text" class="form-control" value="{{$lead->email ?? ''}}" placeholder="lead email">
                                                @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group has-success">
                                                <label for="address" class="control-label mb-1">Lead Address <span class="text-danger">*</span></label>
                                                <textarea name="address" id="address" rows="1" class="form-control @error('address') is-invalid @enderror" placeholder="lead address">{!! $lead->address ?? '' !!}</textarea>
                                                @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="company_name" class="control-label mb-1">Priority <span class="text-danger">*</span></label>
                                                <select name="priority" id="priority" class="form-control select_input @error('priority') is-invalid @enderror">
                                                    <option disabled>--Select Type--</option>
                                                    <option value="High" {{$lead->priority == 'High' ? 'selected':''}}>High</option>
                                                    <option value="Medium" {{$lead->priority == 'Medium' ? 'selected':''}}>Medium</option>
                                                    <option value="Low" {{$lead->priority == 'Low' ? 'selected':''}}>Low</option>
                                                </select>
                                                @error('priority')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group has-success">
                                        <label for="description" class="control-label mb-1">Description</label>
                                        <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="write lead description....">{!! $lead->description ?? '' !!}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10">
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="submit" class="btn btn-space btn-primary btn-sm">Update</button>
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











