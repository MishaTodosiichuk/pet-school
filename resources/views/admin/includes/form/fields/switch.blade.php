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
