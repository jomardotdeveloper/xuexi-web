@extends('app')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-12">
        <h2>Assessment</h2>
    </div>
    @if (count($user_taken_assessments) > 0)
    <div class="col-12">
        <div class="card mt-2">
            <div class="card-body">
                <h3>You have already taken the assessment</h3>
                <h3>Your score is {{ $score }}</h3>
            </div>
        </div>
    </div>
    @else
    <form action="{{ route('end.assessment.store') }}" method="POST" class="row p-3">
        @csrf
        @php
            $id = 1;
        @endphp
        @if (count($multiple_choice) > 0)
            <div class="col-12">
                <h3>Multiple Choice</h3>
            </div>
            @foreach ($multiple_choice as $assessment)
            <div class="col-12">
                <div class="card mt-2">
                    <div class="card-body">
                        {{ $assessment['question'] }}
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="{{ $id }}" id="{{ $id }}A" value="{{ $assessment['choice1'] }}" required>
                            <label class="form-check-label" for="{{ $id }}A">
                                {{ $assessment['choice1'] }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="{{ $id }}" id="{{ $id }}B" value="{{ $assessment['choice2'] }}" required>
                            <label class="form-check-label" for="{{ $id }}B">
                                {{ $assessment['choice2'] }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="{{ $id }}" id="{{ $id }}C" value="{{ $assessment['choice3'] }}" required>
                            <label class="form-check-label" for="{{ $id }}C">
                                {{ $assessment['choice3'] }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="{{ $id }}" id="{{ $id }}D" value="{{ $assessment['choice4'] }}" required>
                            <label class="form-check-label" for="{{ $id }}D">
                                {{ $assessment['choice4'] }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $id++;
            @endphp
            @endforeach
        @endif

        @if (count($true_or_false) > 0)
            <div class="col-12 mt-2">
                <h3>True or False</h3>
            </div>
            @foreach ($true_or_false as $assessment)
            <div class="col-12">
                <div class="card mt-2">
                    <div class="card-body">
                        {{ $assessment['question'] }}
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="{{ $id }}" id="{{ $id }}T" value="True" required>
                            <label class="form-check-label" for="{{ $id }}T">
                                True
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="{{ $id }}" id="{{ $id }}T" value="False" required>
                            <label class="form-check-label" for="{{ $id }}T" >
                                False
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $id++;
            @endphp
            @endforeach
        @endif


        @if (count($identification) > 0)
            <div class="col-12 mt-2">
                <h3>Identification</h3>
            </div>
            @foreach ($identification as $assessment)
            <div class="col-12">
                <div class="card mt-2">
                    <div class="card-body">
                        {{ $assessment['question'] }}
                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <input type="text" class="form-control" name="{{ $id }}" id="answer" aria-describedby="answerHelp" placeholder="Enter answer" required>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $id++;
            @endphp
            @endforeach
        @endif

        <div class="col-12">

            <input type="submit" class="btn btn-primary" />
        </div>
    </form>
    @endif




</div>
@endsection
