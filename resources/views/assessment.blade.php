@extends('master')
@section('title', "Assessment")
@push("styles")
<link href="{{ asset("vendor/datatables/css/jquery.dataTables.min.css") }}" rel="stylesheet">
@endpush
@section('content')
<div class="row">
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Grade 5 Assessments</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="display" style="min-width: 845px">
                        <thead>
                            {{-- COLUMNS STARTS HERE --}}
                            <tr>
                                <th>Question</th>
                                <th>Type</th>
                                <th>Answer</th>
                                <th>Option 1</th>
                                <th>Option 2</th>
                                <th>Option 3</th>
                                <th>Option 4</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grade5 as $data)
                                <tr>
                                    <td>{{ $data['question'] }}</td>
                                    <td>{{ $data['type'] }}</td>
                                    <td>{{ $data['answer'] }}</td>
                                    <td>{{ $data['choice1'] }}</td>
                                    <td>{{ $data['choice2'] }}</td>
                                    <td>{{ $data['choice3'] }}</td>
                                    <td>{{ $data['choice4'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <th>Question</th>
                            <th>Type</th>
                            <th>Answer</th>
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
                <h4 class="card-title">Grade 6 Assessments</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example321" class="display" style="min-width: 845px">
                        <thead>
                            {{-- COLUMNS STARTS HERE --}}
                            <tr>
                                <th>Question</th>
                                <th>Type</th>
                                <th>Answer</th>
                                <th>Option 1</th>
                                <th>Option 2</th>
                                <th>Option 3</th>
                                <th>Option 4</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grade6 as $data)
                                <tr style="color:gray;">
                                    <td>{{ $data['question'] }}</td>
                                    <td>{{ $data['type'] }}</td>
                                    <td>{{ $data['answer'] }}</td>
                                    <td>{{ $data['choice1'] }}</td>
                                    <td>{{ $data['choice2'] }}</td>
                                    <td>{{ $data['choice3'] }}</td>
                                    <td>{{ $data['choice4'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <th>Question</th>
                            <th>Type</th>
                            <th>Answer</th>
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
