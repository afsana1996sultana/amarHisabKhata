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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class=" float-left">Staff List</h5>
                                <h4 class="float-right">
                                    @if(Auth::user()->user_role == 1 || in_array('22', json_decode(Auth::user()->staff->role->permissions)))
                                        <a href="{{ route('staff.create') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i class="fas fa-plus"></i> Create</a>
                                    @endif
                                </h4>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Address</th>
                                        @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('23', json_decode(Auth::user()->staff->role->permissions))
                                            || in_array('24', json_decode(Auth::user()->staff->role->permissions))))
                                            <th class="text-right">Action</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($staffs as $staff)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <img src="{{asset($staff->user->image)}}" alt="" style="height: 50px; width: 50px">
                                            </td>
                                            <td>{{$staff->user->name ?? ''}}</td>
                                            <td>{{$staff->user->phone ?? ''}}</td>
                                            <td>{{$staff->user->email ?? ''}}</td>
                                            <td>{{$staff->role->name ?? ''}}</td>
                                            <td>{{ $staff->user->address ?? '' }}</td>
                                            <td class="text-right">
                                                <a href="{{route('staff.show', $staff->id)}}" class="btn btn-dark btn-xs">Details</a>
                                                @if(Auth::user()->user_role == 1 || in_array('23', json_decode(Auth::user()->staff->role->permissions)))
                                                    <a href="{{route('staff.edit', $staff->id)}}" class="btn btn-primary btn-xs">edit</a>
                                                @endif

                                                @if(Auth::user()->user_role == 1 || in_array('24', json_decode(Auth::user()->staff->role->permissions)))
                                                    <a href="{{route('staff.delete', $staff->id)}}" class="btn btn-danger btn-xs" id="delete">delete</a>
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

