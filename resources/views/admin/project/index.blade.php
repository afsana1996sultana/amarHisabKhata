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
                                <h5 class=" float-left">Project List</h5>
                                <h4 class="float-right">
                                    @if (Auth::user()->user_role == 1 || in_array('18', json_decode(Auth::user()->staff->role->permissions)))
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
                                            @if(Auth::user()->user_role == 1 || (is_array(json_decode(Auth::user()->staff->role->permissions)) && in_array('11', json_decode(Auth::user()->staff->role->permissions))
                                                || in_array('12', json_decode(Auth::user()->staff->role->permissions))))
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $project)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ucwords($project->customer_name ?? '') }}</td>
                                                <td>{{ $project->customer_phone ?? '' }}</td>
                                                <td>{{ $project->customer_email ?? '' }}</td>
                                                <td>{!! $project->address ?? '' !!}</td>
                                                <td>{{ $project->project_name ?? '' }}</td>
                                                <td>{{ $project->project_value ?? '' }}</td>
                                                <td>{{ $project->advance ?? '0.00' }}</td>
                                                <td>{{ $project->paid ?? '0.00' }}</td>
                                                <td>{{ $project->due ?? '0.00' }}</td>
                                                <td>{{ $project->project_duration ?? '' }}</td>
                                                <td>{{ $project->date ?? '' }}</td>
                                                <td>
                                                    <a href="{{ route('project.change-status', $project->id) }}"
                                                        class="btn btn-{{ $project->status == 1 ? 'success' : 'danger' }} btn-xs @if ($project->status == 1) disabled @endif">{{ $project->status == 1 ? 'Completed' : 'Ongoing' }}</a>
                                                </td>
                                                <td>{{ $project->created_by ?? '' }}</td>
                                                <td class="d-flex flex-wrap" style="gap: 5px">
                                                    <a href="{{ route('invoice.download', $project->id) }}" class="btn btn-primary btn-xs float-end"><i class="fas fa-file-pdf"></i></a>
                                                    <a href="{{ route('project.show', $project->id) }}" class="btn btn-dark btn-xs"><i class="fas fa-eye"></i></a>

                                                    @if (Auth::user()->user_role == 1 || in_array('19', json_decode(Auth::user()->staff->role->permissions)))
                                                        <a href="{{ route('project.edit', $project->id) }}" class="btn btn-primary btn-xs @if($project->status == 1) disabled @endif"><i class="fas fa-edit"></i></a>
                                                    @endif

                                                    @if (Auth::user()->user_role == 1 || in_array('20', json_decode(Auth::user()->staff->role->permissions)))
                                                        <a href="{{ route('project.delete', $project->id) }}" class="btn btn-danger btn-xs" id="delete"><i class="fas fa-trash"></i></a>
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
