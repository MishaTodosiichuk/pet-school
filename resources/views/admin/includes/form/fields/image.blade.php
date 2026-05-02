<div class="form-group">
    <label>{{ $field['label'] }}</label>
    <div class="custom-file">
        <input type="file"
               name="{{ $name }}"
               class="custom-file-input preview-trigger @error($name) is-invalid @enderror"
               accept="image/*"
               data-preview-container="#preview-{{ $name }}">
        <label class="custom-file-label">Browse</label>
    </div>
    <div id="preview-image" class="mt-2 row">
        @if(isset($field['value']))
            <div class="col-12">
                <img src="{{ asset($field['value']) }}"
                     class="img-thumbnail w-100"
                     alt=""
                     style="height: 150px; object-fit: cover;">
            </div>
        @endif
    </div>
</div>
