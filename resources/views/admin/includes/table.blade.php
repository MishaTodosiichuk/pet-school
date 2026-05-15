@props(['items', 'config'])

@php
    $routes = $config['routes'];
    $columns = $config['columns'];
    $search = $config['search'];

    $serviceWidth = '80px';
    $actionsWidth = '100px';
@endphp

@include('admin.includes.action-notification')
<div class="card">
    <div class="card-header">
        @if(isset($routes['create']))
            @include('admin.includes.buttons.actions.create')
        @endif

        <div class="card-tools">
            <form action="{{ $search['action'] }}" method="GET">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text"
                           name="query"
                           class="form-control float-right"
                           placeholder="Пошук..."
                           value="{{ request('query') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-head-fixed text-nowrap" style="table-layout: fixed; width: 100%;">
            <thead>
            <tr>
                @foreach($columns as $key => $column)
                    @php
                        $width = 'auto';
                        if ($key === 'id' || $key === 'publish') {
                            $width = $serviceWidth;
                        }
                    @endphp
                    <th class="{{ $column['class'] ?? '' }}" style="width: {{ $width }};">
                        {{ $column['label'] }}
                    </th>
                @endforeach
                @if(isset($routes['edit']))
                    <th class="text-center" style="width: {{ $actionsWidth }};">Змінити</th>
                @endif
                @if(isset($routes['show']))
                    <th class="text-center" style="width: {{ $actionsWidth }};">Переглянути</th>
                @endif
                @if(isset($routes['destroy']))
                    <th class="text-center" style="width: {{ $actionsWidth }};">Видалити</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($items as $action)
                <tr>
                    @foreach($columns as $key => $column)
                        <td class="{{ $column['class'] ?? '' }}"
                            style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            @if($key === 'publish')
                                @include('admin.includes.buttons.actions.publish')
                            @elseif(isset($column['type']) && $column['type'] === 'id')
                                {{ isset($action['parent_id']) ? '_' . $action['id'] : $action['id'] }}
                            @else
                                {{ $action[$key] }}
                            @endif
                        </td>
                    @endforeach

                    @if(isset($routes['edit']))
                        <td class="text-center">
                            @include('admin.includes.buttons.actions.edit')
                        </td>
                    @endif
                    @if(isset($routes['show']))
                        <td class="text-center">
                            @include('admin.includes.buttons.actions.show')
                        </td>
                    @endif
                    @if(isset($routes['destroy']))
                        <td class="text-center">
                            @include('admin.includes.buttons.actions.destroy')
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>

        @include('admin.includes.pagination')
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            if ($(".card-success").length) {
                setTimeout(function () {
                    $(".card-success").fadeOut("slow");
                }, 5000);
            }

            $(document).on('change', '.publish-switch', function () {
                const $checkbox = $(this);
                const id = $checkbox.data('id');
                const isPublished = $checkbox.prop('checked') ? 1 : 0;
                const url = `{{ $routes['index'] }}/${id}/publish`;

                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        publish: isPublished
                    },
                    error: function () {
                        $checkbox.prop('checked', !isPublished);
                        alert('Помилка при оновленні');
                    }
                });
            });
        });
    </script>
@endpush
