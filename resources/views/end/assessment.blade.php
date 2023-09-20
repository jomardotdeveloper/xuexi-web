@extends('app')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-12">
        <h2>Assessment</h2>
    </div>
    @if (!$is_taken)


    <form action="{{ route('end.assessment.store') }}" method="POST">
        @csrf
        @foreach ($assessment as $key => $value)
        <div class="col-12">
            <div class="card mt-2">
                <div class="card-body">
                  {{ $value["question"] }}

                  @foreach ($value['choices'] as $choice)
                  @php
                      $radio_name = $key;
                      $id = $key . $choice['choice'];
                  @endphp
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="{{ $radio_name }}" id="{{ $id }}" value="{{ $choice['choice'] }}">
                    <label class="form-check-label" for="{{ $id }}">
                      {{ $choice['choice'] }}
                    </label>
                  </div>
                  @endforeach

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
                <h3>You have already taken the assessment</h3>
                <h3>Your score is {{ $score }}</h3>
            </div>
        </div>
    </div>
    @endif



</div>
@endsection
