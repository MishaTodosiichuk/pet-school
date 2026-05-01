@if(isset($formConfig['actions']['close']))
    @php
        $button = $formConfig['actions']['close'];
    @endphp

    <a href="{{$button['link']}}" class="btn btn-secondary">
        {{$button['label']}}
    </a>
@endif
