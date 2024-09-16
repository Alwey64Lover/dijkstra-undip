<div class="col-12 mb-2">
    <div class="form-group">
        @if (isset($element['label']))
            <x-form-element.label
                :for="$element['id'] ?? ''"
                :label="$element['label'] ?? ''"
                :required="$element['required'] ?? ''"
            />
        @endif

        @switch($element['type'])
            @case('textarea')
                <x-form-element.textarea
                    :id="$element['id'] ?? ''"
                    :name="$element['name'] ?? ''"
                    :placeholder="$element['placeholder'] ?? '...'"
                    :required="$element['required'] ?? ''"
                    :rows="$element['rows'] ?? 3"
                    :value="$element['value'] ?? ''"
                />
                @break
            @case('select')
                <x-form-element.select
                    :id="$element['id'] ?? ''"
                    :name="$element['name'] ?? ''"
                    :placeholder="$element['placeholder'] ?? '...'"
                    :required="$element['required'] ?? ''"
                    :value="$element['value'] ?? ''"
                    :options="$element['options'] ?? []"
                />
                @break
            @case('file')
                <x-form-element.input-filepond
                    :id="$element['id'] ?? ''"
                    :name="$element['name'] ?? ''"
                    :required="$element['required'] ?? ''"
                />
                @break
            @case('radio')
            @case('checkbox')
                @foreach ($element['content'] as $content)
                    <div class="form-check">
                        <x-form-element.input
                            :type="$element['type'] ?? 'checkbox'"
                            :id="$element['id'] ?? ''"
                            :name="$element['name'] ?? ''"
                            :placeholder="$element['placeholder'] ?? '...'"
                            :required="$element['required'] ?? ''"
                            :value="$content['value'] ?? ''"
                        />

                        <x-form-element.label
                            :for="$content['id'] ?? ''"
                            :label="$content['label'] ?? ''"
                            :required="$element['required'] ?? ''"
                        />
                    </div>
                @endforeach
                @break
            @case('password')
                <x-form-element.password
                    :id="$element['id'] ?? ''"
                    :name="$element['name'] ?? ''"
                    :placeholder="$element['placeholder'] ?? '...'"
                    :required="$element['required'] ?? ''"
                />

                @break
            @default
                <x-form-element.input
                    :type="$element['type'] ?? 'text'"
                    :id="$element['id'] ?? ''"
                    :name="$element['name'] ?? ''"
                    :placeholder="$element['placeholder'] ?? '...'"
                    :required="$element['required'] ?? ''"
                    :value="$element['value'] ?? ''"
                />
        @endswitch
    </div>
</div>
