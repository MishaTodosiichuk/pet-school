@include('admin.includes.action-notification')

<form action="{{ $formConfig['action'] }}" method="post" enctype="multipart/form-data">
    @csrf

    @if($formConfig['method'] === 'patch')
        @method('PATCH')
    @endif

    <div class="row">
        @php
            $fullFields = collect($formConfig['fields'] ?? [])
                ->filter(fn($f) => ($f['column'] ?? 'full') === 'full');

            $mainFields = collect($formConfig['fields'] ?? [])
                ->filter(fn($f) => ($f['column'] ?? 'main') === 'main');

            $sideFields = collect($formConfig['fields'] ?? [])
                ->filter(fn($f) => ($f['column'] ?? 'side') === 'side');
        @endphp

        <div class="col-md-12 form-group">
            <div class="card card-outline">
                <div class="card-body">
                    @include('admin.includes.buttons.form.all-buttons')
                </div>
            </div>
        </div>

        @include('admin.includes.form.sections.full', [
            'fullFields' => $fullFields,
        ])

        @include('admin.includes.form.sections.main', [
            'mainFields' => $mainFields,
        ])

        @include('admin.includes.form.sections.side', [
            'sideFields' => $sideFields,
        ])

        @if(!empty($formConfig['dynamicFields']))
            <section class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center w-100 border-0 custom-card-header">
                        <h3 class="card-title">Динамічні блоки</h3>

                        <button
                            type="button"
                            class="btn btn-sm btn-success d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;"
                            id="add-page-block"
                        >
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    <div class="card-body">
                        @php
                            $dynamicName = $formConfig['dynamicName'] ?? 'blocks';
                            $dynamicRelation = $formConfig['dynamicRelation'] ?? null;

                            $oldDynamicItems = old($dynamicName);

                            if (!empty($oldDynamicItems)) {
                                $dynamicItems = collect($oldDynamicItems);
                            } elseif ($dynamicRelation && isset($model)) {
                                if (method_exists($model, $dynamicRelation)) {
                                    $dynamicItems = $model->{$dynamicRelation}()->orderBy('sort_order')->get();
                                } else {
                                    $dynamicItems = collect();
                                }
                            } else {
                                $dynamicItems = collect();
                            }

                            if ($dynamicItems->isEmpty()) {
                                $dynamicItems = collect([null]);
                            }
                        @endphp


                        <div id="page-blocks-wrapper" class="row">
                            @foreach($dynamicItems as $index => $block)
                                @include('admin.includes.form.page-block-item', [
                                    'index' => $index,
                                    'prefix' => "{$dynamicName}[$index]",
                                    'oldPrefix' => "{$dynamicName}.$index",
                                    'block' => $block,
                                ])
                            @endforeach
                        </div>

                        <template id="page-block-template">
                            @include('admin.includes.form.page-block-item', [
                                'index' => '__INDEX__',
                                'prefix' => $dynamicName . '[__INDEX__]',
                                'oldPrefix' => $dynamicName . '.__INDEX__',
                                'block' => null,
                            ])
                        </template>
                    </div>
                </div>
            </section>
        @endif

        <div class="col-md-12 form-group">
            <div class="card card-outline">
                <div class="card-body">
                    @include('admin.includes.buttons.form.all-buttons')
                </div>
            </div>
        </div>
    </div>
</form>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const wrapper = document.getElementById('page-blocks-wrapper');
                const addButton = document.getElementById('add-page-block');
                const template = document.getElementById('page-block-template');

                if (typeof bsCustomFileInput !== 'undefined') {
                    bsCustomFileInput.init();
                }

                if (!wrapper || !addButton || !template) {
                    return;
                }

                let blockIndex = wrapper.querySelectorAll('.page-block-item').length;

                addButton.addEventListener('click', function () {
                    let html = template.innerHTML;

                    html = html.replaceAll('__INDEX__', blockIndex);
                    html = html.replaceAll('__NUMBER__', blockIndex + 1);

                    wrapper.insertAdjacentHTML('beforeend', html);

                    blockIndex++;

                    updateBlockNumbers();

                    if (typeof bsCustomFileInput !== 'undefined') {
                        bsCustomFileInput.destroy();
                        bsCustomFileInput.init();
                    }
                });

                wrapper.addEventListener('click', function (event) {
                    const removeButton = event.target.closest('.remove-page-block');

                    if (!removeButton) {
                        return;
                    }

                    const items = wrapper.querySelectorAll('.page-block-item');

                    if (items.length <= 1) {
                        return;
                    }

                    removeButton.closest('.page-block-item').remove();

                    updateBlockNumbers();
                });

                function updateBlockNumbers() {
                    wrapper.querySelectorAll('.page-block-item').forEach((item, index) => {
                        const number = item.querySelector('.block-number');
                        const sortOrder = item.querySelector('.block-sort-order');

                        if (number) {
                            number.textContent = index + 1;
                        }

                        if (sortOrder) {
                            sortOrder.value = index;
                        }
                    });
                }
            });
        </script>
    @endpush
@endonce
