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
                                <h4>Deposits List</h4>
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
                                <h5 class=" float-left">Deposits List</h5>
                                <h4 class="float-right">
                                    @if(Auth::user()->user_role == 1 || in_array('49', json_decode(Auth::user()->staff->role->permissions)))
                                        <a href="{{ route('deposit.create') }}" class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i class="fas fa-plus"></i> Create</a>
                                    @endif
                                </h4>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Sl.</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Purpose</th>
                                        <th class="text-center">Status</th>
                                        @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('50', json_decode(Auth::user()->staff->role->permissions))
                                        || in_array('51', json_decode(Auth::user()->staff->role->permissions))))
                                            <th class="text-center">Action</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($deposits as $key=> $item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->date}}</td>
                                            <td>{{$item->amount ?? ''}}</td>
                                            <td>{{$item->purpose ?? ''}}</td>
                                            <td class="text-center">
                                                 @if ($item->status == 1)
                                                        <span class="badge rounded-pill alert-success">Approved</span>
                                                @else
                                                    <span class="badge rounded-pill alert-danger">Pending</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('50', json_decode(Auth::user()->staff->role->permissions))))
                                                    <a href="{{ route('deposit.edit', $item->id) }}" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>
                                                @endif

                                                @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('51', json_decode(Auth::user()->staff->role->permissions))))
                                                    <a href="{{route('deposit.delete', $item->id)}}" class="btn btn-danger btn-xs" id="delete"><i class="fas fa-trash"></i></a>
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
