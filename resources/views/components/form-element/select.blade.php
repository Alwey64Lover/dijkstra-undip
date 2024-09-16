<select class="form-select" id="{{ $id }}" name="{{ $name }}" {{ $required }}>
    <option disabled {{ !old($name) ? 'selected' : '' }}>{{ $placeholder }}</option>

    @foreach ($options as $keyOption => $option)
        <option value="{{ $keyOption }}" {{ old($name, $value) == $keyOption ? 'selected' : '' }}>{{ $option }}</option>
    @endforeach
</select>
