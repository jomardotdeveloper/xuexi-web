@extends('master')
@section('title', "Edit Admin" )

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Admin Form</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    @include('error.danger')
                    <form action="{{ route('admins.update', $id) }}" method="POST" class="row" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- <div class="col-6">
                            <div class="form-group">
                                <label for="name">Username</label>
                                <input type="text" class="form-control input-default " name="username" placeholder="Username" required="true">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Password</label>
                                <input type="password" class="form-control input-default " name="password" placeholder="Password" required="true">
                            </div>
                        </div> --}}
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">First Name</label>
                                <input type="text" class="form-control input-default " name="first_name" placeholder="First Name" required="true" value="{{ $admin["first_name"] }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Middle Name</label>
                                <input type="text" class="form-control input-default " name="middle_name" placeholder="Middle Name" value="{{ $admin["middle_name"] }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Last Name</label>
                                <input type="text" class="form-control input-default " name="last_name" placeholder="Last Name" required="true" value="{{ $admin["last_name"] }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="Male" {{ $admin["gender"] == "Male" ? "selected" : "" }}>Male</option>
                                    <option value="Female" {{ $admin["gender"] == "Female" ? "selected" : "" }}>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Grade Level Adviser</label>
                                <select name="grade_level" class="form-control" required>
                                    <option value="Grade 5" {{ $admin["grade_level"] == "Grade 5" ? "selected" : "" }}>Grade 5</option>
                                    <option value="Grade 6" {{ $admin["grade_level"] == "Grade 6" ? "selected" : "" }}>Grade 6</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6"></div>
                        <div class="form-group col-6">
                            <input type="submit" class="btn btn-primary" value="Save"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
