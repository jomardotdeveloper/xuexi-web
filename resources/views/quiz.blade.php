@extends('master')
@section('title', "Quiz")
@push("styles")
<link href="{{ asset("vendor/datatables/css/jquery.dataTables.min.css") }}" rel="stylesheet">
@endpush
@section('content')
<div class="row">
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Grade 5 Quizzes</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                            {{-- COLUMNS STARTS HERE --}}
                            <tr>
                                <th>Lesson</th>
                                <th>Question</th>
                                <th>Option 1</th>
                                <th>Option 2</th>
                                <th>Option 3</th>
                                <th>Option 4</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grade5 as $key => $value)
                            <tr>
                                <td class="font-weight-bold text-dark">
                                    {{ $value["lesson"] }}
                                </td>
                                <td class="font-weight-bold text-dark">{{ $value["question"]  }}</td>
                                @foreach ($value["choices"] as $choice_key => $choice_value)
                                    @if ($choice_value['is_correct'])
                                        <td  class="text-success">{{ $choice_value["choice"] }}</td>
                                    @else
                                        <td class="text-dark">{{ $choice_value["choice"] }}</td>
                                    @endif
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <th>Lesson</th>
                            <th>Question</th>
                            <th>Option 1</th>
                            <th>Option 2</th>
                            <th>Option 3</th>
                            <th>Option 4</th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Grade 6 Quizzes</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example321" class="display" style="min-width: 845px">
                        <thead>
                            {{-- COLUMNS STARTS HERE --}}
                            <tr>
                                <th>Lesson</th>
                                <th>Question</th>
                                <th>Option 1</th>
                                <th>Option 2</th>
                                <th>Option 3</th>
                                <th>Option 4</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- DATA STARTS HERE --}}
                            @foreach ($grade6 as $key => $value)
                            <tr>
                                <td class="font-weight-bold text-dark">
                                    {{ $value["lesson"] }}
                                </td>
                                <td class="font-weight-bold text-dark">{{ $value["question"]  }}</td>
                                @foreach ($value["choices"] as $choice_key => $choice_value)
                                    @if ($choice_value['is_correct'])
                                        <td  class="text-success">{{ $choice_value["choice"] }}</td>
                                    @else
                                        <td class="text-dark">{{ $choice_value["choice"] }}</td>
                                    @endif
                                @endforeach
                            </tr>
                            @endforeach
                            {{-- DATA ENDS HERE --}}
                        </tbody>
                        <tfoot>
                            <th>Lesson</th>
                            <th>Question</th>
                            <th>Option 1</th>
                            <th>Option 2</th>
                            <th>Option 3</th>
                            <th>Option 4</th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push("scripts")
<script src="{{ asset("vendor/datatables/js/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset("js/plugins-init/datatables.init.js") }}"></script>
@endpush
