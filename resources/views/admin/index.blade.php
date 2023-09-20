@extends('master')
@section('title', "Admin")
@push("styles")
<link href="{{ asset("vendor/datatables/css/jquery.dataTables.min.css") }}" rel="stylesheet">
@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{ route('admins.create') }}" class="btn btn-primary" style="float:left">Create</a>
    </div>
    <div class="col-12 mt-2">
        @include('error.success')
    </div>
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Admin</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                            {{-- COLUMNS STARTS HERE --}}
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Middle Name</th>
                                <th>Gender</th>
                                <th>Grade Level Adviser</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- DATA STARTS HERE --}}
                            @foreach($admins as $id => $admin)
                                <tr>
                                    <td>{{ $admin["first_name"] }}</td>
                                    <td>{{ $admin["last_name"] }}</td>
                                    <td>{{ $admin["middle_name"] }}</td>

                                    <td>{{ $admin["gender"] }}</td>
                                    <td>{{ $admin["grade_level"] }}</td>
                                    <td>
                                        <a class="btn btn-success" href="{{ route("admins.edit",  $id) }}">
                                            Edit
                                        </a>
                                        <a class="btn btn-info" href="{{ route("admins.show", $id) }}">
                                            View
                                        </a>
                                    </td>
                                </tr>

                            @endforeach
                            {{-- DATA ENDS HERE --}}
                        </tbody>
                        <tfoot>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Middle Name</th>
                            <th>Gender</th>
                            <th>Grade Level</th>
                            <th>Action</th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push("scripts")
<script src="{{ asset("vendor/datatables/js/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset("js/plugins-init/datatables.init.js") }}"></script>
@endpush
