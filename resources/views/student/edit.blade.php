@extends('master')
@section('title', "Edit Student" )

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Student Form</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    @include('error.danger')
                    <form action="{{ route('students.update', $id) }}" method="POST" class="row" enctype="multipart/form-data">
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
                                <input type="text" class="form-control input-default " name="first_name" placeholder="First Name" required="true" value="{{ $student["first_name"] }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Middle Name</label>
                                <input type="text" class="form-control input-default " name="middle_name" placeholder="Middle Name" value="{{ $student["middle_name"] }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Last Name</label>
                                <input type="text" class="form-control input-default " name="last_name" placeholder="Last Name" required="true" value="{{ $student["last_name"] }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="Male" {{ $student["gender"] == "Male" ? "selected" : "" }}>Male</option>
                                    <option value="Female" {{ $student["gender"] == "Female" ? "selected" : "" }}>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Grade Level</label>
                                <select name="grade_level" class="form-control" required>
                                    <option value="Grade 5" {{ $student["grade_level"] == "Grade 5" ? "selected" : "" }}>Grade 5</option>
                                    <option value="Grade 6" {{ $student["grade_level"] == "Grade 6" ? "selected" : "" }}>Grade 6</option>
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
