@extends('app')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-12">
        <h2>{{ $lessons[0]["lesson"] }}</h2>
    </div>
    <div class="col-12">
        <a href="{{ route('end.quiz') }}?lesson_number={{ $lesson_number }}" class="btn btn-primary mb-2">Answer</a>
    </div>
    @foreach ($lessons as $lesson)
    <div class="col-12">
        <div class="widget-stat card bg-success">
            <div class="card-body  p-4">
                <div class="media">
                    <span class="mr-3">
                        <i class="flaticon-381-diploma"></i>
                    </span>
                    <div class="media-body text-white text-right">
                        <p class="mb-1">Chinese Character: {{ $lesson['content']['Chinese'] }}</p>
                        <p class="mb-1">English: {{ $lesson['content']['English'] }}</p>
                        <p class="mb-1">Chinese: {{ $lesson['content']['Pinyin'] }}</p>
                        <h3 class="text-white"></h3>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @endforeach
    {{-- @php

        dd($added);
    @endphp --}}
</div>
@endsection
