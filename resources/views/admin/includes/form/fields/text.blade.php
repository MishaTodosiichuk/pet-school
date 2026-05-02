<div class="form-group">
    <label>{{ $field['label'] }}</label>
    <textarea name="{{ $name }}"
              class="form-control summernote @error($name) is-invalid @enderror"
              rows="{{ $field['rows'] ?? 5 }}"
              placeholder="{{ $field['placeholder'] ?? '' }}">{{ old($name, $field['value'] ?? '') }}</textarea>
    @error($name)
    <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
