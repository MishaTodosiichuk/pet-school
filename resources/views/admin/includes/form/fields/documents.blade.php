@php
    $fileValue = $field['value'] ?? null;
    $oldFileName = str_replace('[file]', '[old_file]', $name);

    $uniqueId = str_replace(['[', ']'], ['_', ''], $name);
@endphp

<div class="form-group">
    <label>{{ $field['label'] }}</label>

    @if($fileValue)
        <div class="mb-2">
            <a href="{{ Storage::url($fileValue) }}" target="_blank" class="btn btn-xs btn-outline-info">
                Поточний файл
            </a>

            <input type="hidden" name="{{ $oldFileName }}" value="{{ $fileValue }}">
        </div>
    @endif

    <div class="custom-file">
        <input
            type="file"
            name="{{ $name }}"
            id="{{ $uniqueId }}"
            class="custom-file-input"
            accept=".pdf,.doc,.docx,.xls,.xlsx"
        >

        <label class="custom-file-label" for="{{ $uniqueId }}">
            {{ $fileValue ? 'Замінити документ' : 'Оберіть документ' }}
        </label>
    </div>

    <small class="text-muted">Дозволені формати: PDF, Word, Excel</small>

    @error($errorName ?? $name)
    <span class="text-danger small">{{ $message }}</span>
    @enderror
</div>
