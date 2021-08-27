<form method="POST" action="{{ $route }}">
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @csrf
    @if (isset($item))
        @method('PUT')
    @endif
    <div>
        {!! $fields !!}
    </div>
    <button type="submit">Submit</button>
</form>
