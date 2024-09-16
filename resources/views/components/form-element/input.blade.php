<input type="{{ $type }}"
    id="{{ $id }}"
    class="{{ in_array($type, ['radio', 'checkbox']) ? 'form-check-input' : 'form-control'}} {{ $errors->has($name) ? 'is-invalid' : '' }}"
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    value="{{ old($name, $value) }}"
    {{ $required }}
>
