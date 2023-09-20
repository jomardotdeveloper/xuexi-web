@extends('app')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-12">
        <h2>Lessons</h2>
        @if ($current_lesson == 0)
        <p class="lead">Take the assessment before you can proceed with the lessons</p>
        @endif
    </div>

    @if ($current_lesson == 0)
    <div class="col-3 mb-3">
        <a href="{{ route('end.assessment') }}" class="btn btn-primary">
            Take Assessment
        </a>
    </div>
    @endif
    @php
        $current = 1;
    @endphp
    @foreach ($all_lessons as $key => $value)
    @if (str_contains($value['lesson'], strval($current)))
    @if ($current < intval(session('user')['current_lesson']))
    <div class="col-12">
        <div class="widget-stat card bg-success">
            <div class="card-body  p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="flaticon-381-diploma"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">{{ $value['lesson'] }}</p>
                        <h3 class="text-white"></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif ($current == intval(session('user')['current_lesson']))
    <div class="col-12">
        <div class="widget-stat card bg-warning">
            <div class="card-body  p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="flaticon-381-equal-1"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">{{ $value['lesson'] }}</p>
                        <h3 class="text-white"></h3>
                        <a href="{{ route('end.lesson') }}?lesson_number={{ $current }}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-12">
        <div class="widget-stat card bg-danger">
            <div class="card-body  p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="flaticon-381-lock"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">{{ $value['lesson'] }}</p>
                        <h3 class="text-white"></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @php
        $current++;
        // dd(session('user')['current_lesson']);
        // dd($current, intval(session('user')['current_lesson']));
    @endphp



    @endif

    @endforeach
    {{-- @php

        dd($added);
    @endphp --}}
</div>
@endsection
