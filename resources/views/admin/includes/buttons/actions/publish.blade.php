<div class="custom-control custom-switch">
    <input type="checkbox"
           class="custom-control-input publish-switch"
           id="publish-{{ $action['id'] }}"
           data-id="{{ $action['id'] }}"
           data-url="{{ str_replace(':id', $action['id'], $routes['publish'] ?? '') }}"
        {{ $action['publish'] ? 'checked' : '' }}>
    <label class="custom-control-label" for="publish-{{ $action['id'] }}"></label>
</div>
