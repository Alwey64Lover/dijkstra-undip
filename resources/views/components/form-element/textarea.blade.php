<textarea class="form-control"
    id="{{ $id }}"
    rows="{{ $rows }}"
    name="{{ $name }}"
    placeholder="{{ $placeholder }}"
    {{ $required }}
>
    {{ old($name, $value) }}
</textarea>
