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
