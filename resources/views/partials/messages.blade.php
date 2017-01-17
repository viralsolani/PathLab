@if (Session::has('success'))
    <div class="note note-info">
        <p>{{ Session::get('success') }}</p>
    </div>
@endif

@if (Session::has('error'))
    <div class="note note-danger">
        <p>{{ Session::get('error') }}</p>
    </div>
@endif

@if ($errors->count() > 0)
    <div class="note note-danger">
        <ul class="list-unstyled">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


