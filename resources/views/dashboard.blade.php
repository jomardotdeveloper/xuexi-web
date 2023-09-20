@extends('master')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-4">
        <div class="widget-stat card bg-danger">
            <div class="card-body  p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="flaticon-381-user-1"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Students</p>
                        <h3 class="text-white">{{ $student_counts }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="widget-stat card bg-success">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="flaticon-381-user-7"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Users</p>
                        <h3 class="text-white">{{ $teacher_counts }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="widget-stat card bg-info">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="flaticon-381-heart"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Assessment Submissions</p>
                        <h3 class="text-white">0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="widget-stat card bg-primary">
            <div class="card-body p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="flaticon-381-user-7"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Quiz Submissions</p>
                        <h3 class="text-white">0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
