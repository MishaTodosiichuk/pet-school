@php
    $id = $name . '_' . Str::random(4);
    $currentValue = old($name, $field['value'] ?? '');
    $isMultiple = !empty($field['multiple']) || str_ends_with($name, '[]');
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
        {{ $isMultiple ? 'multiple' : '' }}
    >
        @if(!$isMultiple)
            <option value="">{{ $field['placeholder'] ?? 'Не обрано' }}</option>
        @endif

        @foreach($field['options'] as $option)
            @php
                $isSelected = false;
                if ($isMultiple) {
                    $isSelected = is_array($currentValue) && in_array($option->id, $currentValue);
                } else {
                    $isSelected = (string)$currentValue === (string)$option->id;
                }
            @endphp

            <option value="{{ $option->id }}" {{ $isSelected ? 'selected' : '' }}>
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
                    placeholder: "Почніть вводити...",
                    allowClear: true
                });
            });
        </script>
    @endpush
@endonce
