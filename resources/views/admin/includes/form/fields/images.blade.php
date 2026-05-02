<div class="form-group">
    <label>{{ $field['label'] }}</label>

    <div class="custom-file mb-3">
        <input type="file"
               name="{{ $name }}_uploads[]"
               class="custom-file-input preview-trigger"
               multiple
               accept="image/*"
               data-preview-container="#preview-{{ $name }}">
        <label class="custom-file-label">Оберіть нові файли</label>
    </div>

    <div id="preview-{{ $name }}" class="row">
        @if(isset($field['images']))
            @foreach($field['images'] as $image)
                <div class="col-md-2 col-sm-4 mb-2 existing-image" data-id="{{ $image['id'] }}">
                    <div class="position-relative">
                        <img src="{{ $image['url'] }}"
                             alt="{{ $image['alt'] }}"
                             class="img-thumbnail"
                             style="width: 100%; height: 120px; object-fit: cover;">

                        <input type="hidden" name="{{ $name }}[]" value="{{ $image['id'] }}">

                        <button type="button"
                                class="btn btn-danger btn-sm position-absolute"
                                style="top: 5px; right: 5px;"
                                onclick="this.parentElement.parentElement.remove()">
                            &times;
                        </button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
