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
                                <h4>Project Info</h4>
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
                                <h5 class=" float-left">Project Request List</h5>
                                <h4 class="float-right">
                                    @if (Auth::user()->user_role == 1 || in_array('1', json_decode(Auth::user()->staff->role->permissions)))
                                        <a href="{{ route('project.create') }}"
                                            class="btn btn-outline-dark btn-xs float-end" style="padding: 4px 12px"><i
                                                class="fas fa-plus"></i> Create</a>
                                    @endif
                                </h4>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Customer Name</th>
                                            <th>Customer Phone</th>
                                            <th>Customer Email</th>
                                            <th>Address</th>
                                            <th>Project Name</th>
                                            <th>Project Value</th>
                                            <th>Advance</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <th>Project Duration</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $project)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $project->customer_name ?? '' }}</td>
                                                <td>{{ $project->customer_phone ?? '' }}</td>
                                                <td>{{ $project->customer_email ?? '' }}</td>
                                                <td>{!! $project->address ?? '' !!}</td>
                                                <td>{{ $project->project_name ?? '' }}</td>
                                                <td>{{ $project->project_value ?? '' }}</td>
                                                <td>{{ $project->advance ?? '' }}</td>
                                                <td>{{ $project->paid ?? '' }}</td>
                                                <td>{{ $project->due ?? '' }}</td>
                                                <td>{{ $project->project_duration ?? '' }}</td>
                                                <td>{{ $project->date ?? '' }}</td>
                                                <td>
                                                    @if ($project->status == 0)
                                                        <span class="btn btn-{{ $project->status == 0 ? 'danger' : 'dark' }} btn-xs">Ongoing</span>
                                                    @else
                                                        <span class="btn btn-{{ $project->status == 1 ? 'success' : 'dark' }} btn-xs">Completed</span>
                                                    @endif
                                                </td>
                                                <td>{{ $project->user->name ?? '' }}</td>
                                                <td>
                                                    @if ($project->is_approve == 0)
                                                        <a class="btn btn-{{ $project->is_approve == 0 ? 'danger' : 'dark' }} btn-xs" href="{{ route('project.approved', $project->id) }}">Approved</a>
                                                    @else
                                                        <span class="">Approve</span>
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
