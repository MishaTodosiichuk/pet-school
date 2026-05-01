@if($field['type'] === 'text')
    <div class="form-group">
        <label>{{ $field['label'] }}</label>
        <input type="text"
               name="{{ $name }}"
               class="form-control @error($name) is-invalid @enderror"
               placeholder="{{ $field['placeholder'] ?? '' }}"
               value="{{ old($name, $field['value'] ?? '') }}">
        @error($name)
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
@endif

@if($field['type'] === 'select')
    <div class="form-group">
        <label>{{ $field['label'] }}</label>
        <select name="{{ $name }}" class="form-control @error($name) is-invalid @enderror">
            <option value="">{{ $field['placeholder'] ?? 'Не обрано' }}</option>
            @foreach($field['options'] as $option)
                <option value="{{ $option->id }}"
                    {{ old($name, $field['value'] ?? '') == $option->id ? 'selected' : '' }}>
                    {{ $option->parent_id ? '— ' : '' }}{{ $option->title }}
                </option>
            @endforeach
        </select>
        @error($name)
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
@endif

@if($field['type'] === 'switch')
    <div class="form-group">
        <div class="custom-control custom-switch">
            <input type="hidden" name="{{ $name }}" value="0">
            <input type="checkbox"
                   name="{{ $name }}"
                   value="1"
                   class="custom-control-input"
                   id="{{ $name }}"
                {{ old($name, $field['value'] ?? false) ? 'checked' : '' }}>
            <label class="custom-control-label" for="{{ $name }}">
                {{ $field['label'] }}
            </label>
        </div>
    </div>
@endif
