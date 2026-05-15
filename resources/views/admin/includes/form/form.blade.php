@include('admin.includes.action-notification')

<form action="{{ $formConfig['action'] }}" method="post" enctype="multipart/form-data">
    @csrf
    @if($formConfig['method'] === 'patch')
        @method('PATCH')
    @endif

    <div class="row">
        @php $fullFields = collect($formConfig['fields'])->filter(fn($f) => ($f['column'] ?? 'full') === 'full'); @endphp
        @php $mainFields = collect($formConfig['fields'])->filter(fn($f) => ($f['column'] ?? 'main') === 'main'); @endphp
        @php $sideFields = collect($formConfig['fields'])->filter(fn($f) => ($f['column'] ?? 'side') === 'side'); @endphp

        <div class="col-md-12 form-group">
            <div class="card card-outline">
                <div class="card-body">
                    @include('admin.includes.buttons.form.all-buttons')
                </div>
            </div>
        </div>

        @if($fullFields->isNotEmpty())
            <section class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        @foreach($fullFields as $name => $field)
                            @includeIf("admin.includes.form.fields." . $field['type'], array_merge(['name' => $name], $field))
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        @if($mainFields->isNotEmpty())
            <section class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        @foreach($formConfig['fields'] as $name => $field)
                            @if(($field['column'] ?? 'main') === 'main')
                                @includeIf("admin.includes.form.fields." . $field['type'], array_merge(['name' => $name], $field))
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        @if($sideFields->isNotEmpty())
            <section class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        @foreach($formConfig['fields'] as $name => $field)
                            @if(($field['column'] ?? 'main') === 'side')
                                @includeIf("admin.includes.form.fields." . $field['type'], array_merge(['name' => $name], $field))
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>
</form>
