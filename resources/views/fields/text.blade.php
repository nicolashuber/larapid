<div>
    <input type="text" name="{{ $field->column }}"{{ $field->placeholder ? 'placeholder=' . $field->placeholder : '' }} value="{{ old($field->column, $field->value) }}" />
</div>
