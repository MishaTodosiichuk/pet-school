@php
    $uploadsName = str_ends_with($name, '[]')
        ? substr($name, 0, -2) . '_uploads'
        : $name . '_uploads';
@endphp

<div class="form-group">
    <label>{{ $field['label'] ?? 'Зображення' }}</label>

    <div class="custom-file mb-3">
        <input type="file"
               name="{{ $uploadsName }}[]"
               class="custom-file-input preview-trigger"
               multiple
               accept="image/*"
               data-preview-container="#preview-{{ str_replace(['[', ']', '__INDEX__'], ['-', '', 'index'], $name) }}">
        <label class="custom-file-label">Оберіть нові файли</label>
    </div>

    <div id="preview-{{ str_replace(['[', ']', '__INDEX__'], ['-', '', 'index'], $name) }}" class="row">
        @if(isset($field['images']))
            @foreach($field['images'] as $image)
                <div class="col-md-2 col-sm-4 mb-2 existing-image" data-id="{{ $image['id'] }}">
                    <div class="position-relative">
                        <img src="{{ $image['url'] }}"
                             alt="{{ $image['alt'] ?? '' }}"
                             class="img-thumbnail"
                             style="width: 100%; height: 120px; object-fit: cover;">

                        <input type="hidden"
                               name="{{ str_ends_with($name, '[]') ? $name : $name . '[]' }}"
                               value="{{ $image['id'] }}">

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
