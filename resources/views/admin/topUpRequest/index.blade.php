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
                                <h4>Top UP List</h4>
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
                                        <th>Project Name</th>
                                        <th>Purpose</th>
                                        <th>Amount</th>
                                        <th>Created By</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($topUps as $key=> $item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{ucwords($item->project_name ?? '')}}</td>
                                            <td>{{ucfirst($item->purpose ?? '')}}</td>
                                             <td>{{$item->amount ?? ''}}</td>
                                             <td>{{ ucwords($item->creator->name ?? '') }}</td>
                                            <td class="text-center">
                                                 @if ($item->status == 1)
                                                    <span class="badge rounded-pill alert-success">Active</span>
                                                @else
                                                    <span class="badge rounded-pill alert-danger">Inactive</span></a>
                                                @endif
                                            </td>
                                             <td class="text-right">
                                                @if ($item->status == 0)
                                                    <a class="btn btn-{{ $item->status == 0 ? 'danger' : 'dark' }} btn-xs" href="{{ route('top-up.active', $item->id) }}">Approved</a>
                                                @else
                                                    <span class="">Approve</span>
                                                @endif
                                                <a href="{{route('top-up.edit', $item->id)}}" class="btn btn-primary btn-xs">Edit</a>
                                                <a href="{{route('top-up.delete', $item->id)}}" class="btn btn-danger btn-xs" id="delete"><i class="fas fa-trash"></i></a>
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
