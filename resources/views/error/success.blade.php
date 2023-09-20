@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        <ul>
            @foreach(Session::get('success') as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif