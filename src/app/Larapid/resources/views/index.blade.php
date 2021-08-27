<a href="{{ $entity->route(null, 'create') }}">New</a>
<table>
    <thead>
        <tr>
            @foreach ($entity->headers() as $column => $label)
                <th>{{ $label }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $item)
            <tr>
                @foreach ($entity->headers() as $column => $label)
                    <td>
                        {{ $item->{$column}  }}
                    </td>
                @endforeach
            </tr>
            <td>
                <a href="{{ $entity->route($item->id, 'edit') }}">Edit</a>
                <form method="POST" action="{{ $entity->route($item->id, 'destroy') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        @empty
            <tr>
                <td colspan="{{ count($entity->headers()) }}">
                    No results.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $items->links() }}
