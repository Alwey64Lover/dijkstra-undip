<input type="password"
    id="{{ $id }}"
    class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}"
    name="{{ $name }}"
    placeholder="Password"
    {{ $required }}
>

<i class="toggle-password fa fa-fw fa-eye-slash" data-id="{{ $id }}"></i>
