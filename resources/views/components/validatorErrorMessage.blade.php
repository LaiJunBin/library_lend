@if ($errors and count($errors))
    <ul>
        @foreach ($errors->all() as $err)
            <li style="color:red;">{{ $err }}</li>
        @endforeach
    </ul>
@endif