@php
    $id = $name . '_' . Str::random(4);
    $currentValue = old($name, $field['value'] ?? '');
@endphp

<div class="form-group">
    @if(isset($field['label']))
        <label for="{{ $id }}">{{ $field['label'] }}</label>
    @endif
    <select
        name="{{ $name }}"
        id="{{ $id }}"
        class="form-control select2-init @error($name) is-invalid @enderror"
        style="width: 100%;"
    >
        <option value="">{{ $field['placeholder'] ?? 'Не обрано' }}</option>
        @foreach($field['options'] as $option)
            <option value="{{ $option->id }}"
                {{ (string)$currentValue === (string)$option->id ? 'selected' : '' }}>
                {{ $option->display_name ?? $option->title }}
            </option>
        @endforeach
    </select>

    @error($name)
    <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

@once
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.select2-init').select2({
                    theme: 'bootstrap4',
                    language: "uk",
                    width: '100%',
                    placeholder: "{{ $field['placeholder'] ?? 'Почніть вводити...' }}",
                    allowClear: true
                });
            });
        </script>
    @endpush
@endonce
