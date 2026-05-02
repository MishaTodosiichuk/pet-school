@include('admin.includes.action-notification')

<form action="{{ $formConfig['action'] }}" method="post" enctype="multipart/form-data">
    @csrf
    @if($formConfig['method'] === 'patch')
        @method('PATCH')
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-body">
                    @foreach($formConfig['fields'] as $name => $field)
                        @if(($field['column'] ?? 'main') === 'main')
                            @includeIf("admin.includes.form.fields." . $field['type'], array_merge([
                                'name' => $name,
                            ], $field))
                        @endif
                    @endforeach
                    @include('admin.includes.buttons.form.all-buttons')
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-body">
                    @foreach($formConfig['fields'] as $name => $field)
                        @if(($field['column'] ?? 'main') === 'side')
                            @includeIf("admin.includes.form.fields." . $field['type'], array_merge([
                                'name' => $name,
                            ], $field))
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</form>
