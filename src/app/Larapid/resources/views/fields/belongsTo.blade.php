<div>
    <select name={{ $field->column }}>
        @foreach ($field->options() as $value => $label)
            <option value="{{ $value }}"{{ old($field->column, $field->value) == $value ? ' selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</div>
