@include('admin.includes.action-notification')

<form action="{{ $formConfig['action'] }}" method="post">
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
                            @include('admin.includes.buttons.form.render-field', ['name' => $name, 'field' => $field])
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
                            @include('admin.includes.buttons.form.render-field', ['name' => $name, 'field' => $field])
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</form>
