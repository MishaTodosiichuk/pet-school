@if($fullFields->isNotEmpty())
    <section class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                @foreach($fullFields as $name => $field)
                    @includeIf(
                        "admin.includes.form.fields." . $field['type'],
                        array_merge(
                            [
                                'name' => isset($prefix)
                                    ? $prefix . '[' . $name . ']'
                                    : $name,
                            ],
                            $field
                        )
                    )
                @endforeach
            </div>
        </div>
    </section>
@endif
