@props(['items', 'config'])

@php
    $routes = $config['routes'];
    $columns = $config['columns'];
    $search = $config['search'];
@endphp

@include('admin.includes.action-notification')
<div class="card">
    <div class="card-header">
        @include('admin.includes.buttons.actions.create')
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
        <table class="table table-head-fixed text-nowrap">
            <thead>
            <tr>
                @foreach($columns as $column)
                    <th class="{{ $column['class'] ?? '' }}">{{ $column['label'] }}</th>
                @endforeach
                <th class="text-center">Змінити</th>
                <th class="text-center">Видалити</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $action)
                <tr>
                    @foreach($columns as $key => $column)
                        <td class="{{ $column['class'] ?? '' }}">
                            @if($key === 'publish')
                                @include('admin.includes.buttons.actions.publish')
                            @elseif(isset($column['type']) && $column['type'] === 'id')
                                {{ isset($action['parent_id']) ? '_' . $action['id'] : $action['id'] }}
                            @else
                                {{ $action[$key] }}
                            @endif
                        </td>
                    @endforeach

                    <td class="text-center">
                        @include('admin.includes.buttons.actions.edit')
                    </td>
                    <td class="text-center">
                        @include('admin.includes.buttons.actions.destroy')
                    </td>
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
                const url = `/admin/menus/${id}/publish`;

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
