@extends('app')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-12">
        <h2>Quiz Lesson {{ $lesson_number }}</h2>
    </div>
    @if(!$is_taken)
    <form action="{{ route('end.quiz.store') }}" method="POST">
        <input type="hidden" value="{{ $lesson_number }}" name="lesson_number"/>
        @csrf
        @php
                        $ctx = 1;
                    @endphp
        @foreach ($quizzes as $quiz)

        @php
            $value = $quiz;
            // dd($value);
        @endphp

        <div class="col-12">
            <div class="card mt-2">
                <div class="card-body">
                  {{ $value["question"] }}

                  @foreach ($value['choices'] as $choice)
                  @php
                    //   $radio_name = $ctx;
                      $id = $ctx . $choice['choice'];
                  @endphp
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="{{ $ctx }}" id="{{ $id }}" value="{{ $choice['choice'] }}">
                    <label class="form-check-label" for="{{ $id }}">
                      {{ $choice['choice'] }}
                    </label>
                  </div>

                  @endforeach
                  @php
                      $ctx++;
                  @endphp
                </div>
            </div>
        </div>
        @endforeach
        <div class="col-12">

            <input type="submit" class="btn btn-primary" />
        </div>
    </form>
    @else
    <div class="col-12">
        <div class="card mt-2">
            <div class="card-body">
                <h3>You have already taken the quiz</h3>
                <h3>Your score is {{ $score }}</h3>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
