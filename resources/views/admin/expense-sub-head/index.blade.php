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
                                <h4>Account SubHead Info</h4>
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
                                <h5 class=" float-left">Account SubHead List</h5>
                                <h4 class="float-right">
                                    @if(Auth::user()->user_role == 1 || in_array('34', json_decode(Auth::user()->staff->role->permissions)))
                                        <a href="{{ route('expense-sub-head.create') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i class="fas fa-plus"></i> Create</a>
                                    @endif
                                </h4>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Sl.</th>
                                        <th>Expense Head</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th class="text-center">Status</th>
                                        @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('35', json_decode(Auth::user()->staff->role->permissions))
                                            || in_array('36', json_decode(Auth::user()->staff->role->permissions))))
                                            <th class="text-right">Action</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($subheads as $key=> $subhead)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$subhead->expenseHead->title ?? ''}}</td>
                                            <td>{{$subhead->title ?? ''}}</td>
                                            <td>{{$subhead->slug ?? ''}}</td>
                                            <td class="text-center">
                                                @if ($subhead->status == 1)
                                                    <a href="{{ route('expense-sub-head.in_active',['id'=>$subhead->id]) }}">
                                                        <span class="badge rounded-pill alert-success">Active</span>
                                                    </a>
                                                @else
                                                    <a href="{{ route('expense-sub-head.active',['id'=>$subhead->id]) }}">
                                                        <span class="badge rounded-pill alert-danger">Inactive</span></a>
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @if(Auth::user()->user_role == 1 || in_array('35', json_decode(Auth::user()->staff->role->permissions)))
                                                    <a href="{{route('expense-sub-head.edit', $subhead->id)}}" class="btn btn-primary btn-xs">Edit</a>
                                                @endif
                                                @if(Auth::user()->user_role == 1 || in_array('36', json_decode(Auth::user()->staff->role->permissions)))
                                                    <a href="{{route('expense-sub-head.delete', $subhead->id)}}" class="btn btn-danger btn-xs" id="delete">Delete</a>
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
