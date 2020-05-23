@if (count($errors->all()) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $errors )
                <li>{{ $errors }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('success'))

    <div class="alert alert-success">
        <h2> {{ session('success') }} </h2>
    </div>

@endif

