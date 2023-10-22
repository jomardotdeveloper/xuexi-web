@extends('app')
@section('title', 'Dashboard')
@section('content')

@if ($current_lesson == 0)
<div class="col-3 mb-3">
    <a href="{{ route('end.assessment') }}" class="btn btn-primary">
        Take Assessment
    </a>
</div>
@endif
@foreach ($grade_lessons as $lesson)

@if (intval($current_lesson) >= intval($lesson['number']))
<div class="col-12">
    <div class="widget-stat card bg-success">
        <div class="card-body  p-4">
            <div class="media">
                <span class="mr-3">
                    <i class="flaticon-381-diploma"></i>
                </span>
                <div class="media-body text-white text-right">
                    <p class="mb-1">{{ $lesson['name'] }}</p>
                    <h3 class="text-white"></h3>
                    <a href="{{ route('end.lesson') }}?lesson_number={{ $lesson['number'] }}&&lesson_title={{ $lesson['name'] }}" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>
    </div>
</div>
@elseif (intval($current_lesson) < intval($lesson['number']))
<div class="col-12">
    <div class="widget-stat card bg-secondary">
        <div class="card-body  p-4">
            <div class="media">
                <span class="mr-3">
                    <i class="flaticon-381-diploma"></i>
                </span>
                <div class="media-body text-white text-right">
                    <p class="mb-1">{{ $lesson['name'] }}</p>
                    <h3 class="text-white"></h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endforeach
@endsection
