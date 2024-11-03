@extends('admin.layouts.master')
@section('main-content')
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
                                <h4>Customer Info</h4>
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class=" float-left">Customer List</h5>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Customer Name</th>
                                        <th>Customer Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Priority</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('14', json_decode(Auth::user()->staff->role->permissions))
                                            || in_array('15', json_decode(Auth::user()->staff->role->permissions)) || in_array('16', json_decode(Auth::user()->staff->role->permissions))))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($leads as $lead)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$lead->lead_name ?? ''}}</td>
                                            <td>{{$lead->lead_phone ?? ''}}</td>
                                            <td>{{$lead->email ?? ''}}</td>
                                            <td>{{$lead->address ?? ''}}</td>
                                            <td>{{$lead->priority ?? ''}}</td>
                                            <td>{!! $lead->description ?? '' !!}</td>
                                            <td>
                                                @if ($lead->status == 1)
                                                    <a href="{{ route('lead.change-status.inactive', $lead->id) }}">
                                                        <span class="badge rounded-pill alert-success">Active</span>
                                                    </a>
                                                @else
                                                    <a href="{{ route('lead.change-status.active', $lead->id) }}">
                                                        <span class="badge rounded-pill alert-danger">Inactive</span></a>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{$lead->created_by ?? ''}}</td>
                                            <td>
                                                @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('14', json_decode(Auth::user()->staff->role->permissions))))
                                                    <a href="{{ route('customer.edit', $lead->id) }}" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>
                                                @endif

                                                @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('15', json_decode(Auth::user()->staff->role->permissions))))
                                                    <a href="{{ route('customer.show', $lead->id) }}" class="btn btn-dark btn-xs"><i class="fas fa-eye"></i></a>
                                                @endif

                                                @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('16', json_decode(Auth::user()->staff->role->permissions))))
                                                    <a href="{{ route('lead.delete', $lead->id) }}" class="btn btn-danger btn-xs" id="delete"><i class="fas fa-trash"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
            $('#example').DataTable();
        });
    </script>
@endpush
