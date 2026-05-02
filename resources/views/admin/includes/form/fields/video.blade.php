<div class="form-group">
    <label>{{ $field['label'] }}</label>
    <input type="text"
           name="{{ $name }}"
           class="form-control @error($name) is-invalid @enderror"
           placeholder="Посилання на YouTube або шлях до файлу"
           value="{{ old($name, $field['value'] ?? '') }}">
    <small class="text-muted">Вставте посилання на відео</small>
    @error($name)
    <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
