<div class="form-group">
    <label>{{ $field['label'] }}</label>
    <div class="custom-file">
        <input type="file"
               name="{{ $name }}[]"
               class="custom-file-input"
               multiple
               accept=".pdf,.doc,.docx,.xls,.xlsx">
        <label class="custom-file-label">Оберіть документи</label>
    </div>
    <small class="text-muted">Дозволені формати: PDF, Word, Excel</small>
    @error($name . '.*')
    <span class="text-danger small">{{ $message }}</span>
    @enderror
</div>
