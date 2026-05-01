<ol class="breadcrumb float-sm-right">
    @foreach($breadcrumbs as $item)
        @if($item['active'])
            <li class="breadcrumb-item active">{{$item['title']}}</li>
        @else
            <li class="breadcrumb-item"><a href="{{$item['link']}}">{{$item['title']}}</a></li>
        @endif
    @endforeach
</ol>
