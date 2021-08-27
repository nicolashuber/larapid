<div>
    <textarea name="{{ $field->column }}"{{ $field->placeholder ? 'placeholder=' . $field->placeholder : '' }}>
        {{ old($field->column, $field->value) }}
    </textarea>
</div>
