@php
    $blockData = is_array($block ?? null) ? $block : null;

    $dynamicFields = $formConfig['dynamicFields'] ?? [];

    if (!is_array($dynamicFields)) {
        $dynamicFields = [];
    }

    foreach ($dynamicFields as $fieldName => $field) {
        $dynamicFields[$fieldName]['value'] = old(
            "{$oldPrefix}.{$fieldName}",
            $blockData[$fieldName] ?? ($block?->{$fieldName} ?? ($field['value'] ?? null))
        );
    }

    $dynamicFullFields = collect($dynamicFields)
        ->filter(fn($f) => ($f['column'] ?? 'full') === 'full');

    $dynamicMainFields = collect($dynamicFields)
        ->filter(fn($f) => ($f['column'] ?? 'main') === 'main');

    $dynamicSideFields = collect($dynamicFields)
        ->filter(fn($f) => ($f['column'] ?? 'side') === 'side');
@endphp

<div class="page-block-item col-12 border rounded p-3 mb-3" data-index="{{ $index }}">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">
            Блок <span class="block-number">{{ is_numeric($index) ? $index + 1 : '__NUMBER__' }}</span>
        </h5>

        <button type="button" class="btn btn-sm btn-danger remove-page-block">
            <i class="fas fa-trash"></i>
        </button>
    </div>

    <div class="row">
        @include('admin.includes.form.sections.full', [
            'fullFields' => $dynamicFullFields,
            'prefix' => $prefix,
        ])

        @include('admin.includes.form.sections.main', [
            'mainFields' => $dynamicMainFields,
            'prefix' => $prefix,
        ])

        @include('admin.includes.form.sections.side', [
            'sideFields' => $dynamicSideFields,
            'prefix' => $prefix,
        ])
    </div>

    <input
        type="hidden"
        name="{{ $prefix }}[sort_order]"
        value="{{ is_numeric($index) ? $index : '__INDEX__' }}"
        class="block-sort-order"
    >
</div>
