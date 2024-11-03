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
                                <h4>Withdraw List</h4>
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
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                       <th>Sl.</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Purpose</th>
                                        @if(Auth::user()->user_role == 1 || in_array('15', json_decode(Auth::user()->staff->role->permissions)) || in_array('16', json_decode(Auth::user()->staff->role->permissions)))
                                            <th class="text-right">Action</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($withdraws as $key=> $item)
                                        <tr>
                                          <td>{{$key+1}}</td>
                                            <td>{{$item->date}}</td>
                                            <td>{{$item->amount ?? ''}}</td>
                                            <td>{{$item->purpose ?? ''}}</td>
                                             <td class="text-right">
                                                @if(Auth::user()->user_role == 1 || in_array('15', json_decode(Auth::user()->staff->role->permissions)))
                                                    @if ($item->status == 0)
                                                        <a class="btn btn-{{ $item->status == 0 ? 'danger' : 'dark' }} btn-xs" href="{{ route('withdraw.active', $item->id) }}">Approved</a>
                                                    @else
                                                        <span class="">Approve</span>
                                                    @endif
                                                @endif

                                                @if(Auth::user()->user_role == 1 || in_array('15', json_decode(Auth::user()->staff->role->permissions)))
                                                    <a href="{{route('withdraw.edit', $item->id)}}" class="btn btn-primary btn-xs">Edit</a>
                                                @endif

                                                @if(Auth::user()->user_role == 1 || in_array('16', json_decode(Auth::user()->staff->role->permissions)))
                                                    <a href="{{route('withdraw.delete', $item->id)}}" class="btn btn-danger btn-xs" id="delete">Delete</a>
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
