@if(Session::has('error'))
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach(Session::get('error') as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif