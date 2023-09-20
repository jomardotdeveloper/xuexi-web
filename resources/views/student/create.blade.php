@extends('master')
@section('title', "Create Student" )

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
                    <form action="{{ route('students.store') }}" method="POST" class="row" enctype="multipart/form-data">
                        @csrf
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="email" class="form-control input-default " name="email" placeholder="Email" required="true">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Password</label>
                                <input type="password" class="form-control input-default " name="password" placeholder="Password" required="true">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">First Name</label>
                                <input type="text" class="form-control input-default " name="first_name" placeholder="First Name" required="true">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Middle Name</label>
                                <input type="text" class="form-control input-default " name="middle_name" placeholder="Middle Name" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Last Name</label>
                                <input type="text" class="form-control input-default " name="last_name" placeholder="Last Name" required="true">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Grade Level</label>
                                <select name="grade_level" class="form-control" required>
                                    <option value="Grade 5">Grade 5</option>
                                    <option value="Grade 6">Grade 6</option>
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
