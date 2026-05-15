<div class="row">
    <div class="col-md-12 form-group">
        <div class="card card-outline">
            <div class="card-body">
                @include('admin.includes.buttons.form.close')
            </div>
        </div>
    </div>
    <section class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                @foreach($formConfig['fields'] as $field)
                    <div class="form-group">
                        <label>{{ $field['label'] }}</label>
                        <span class="form-control" style="height: fit-content;">
                            {{$field['value']}}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
