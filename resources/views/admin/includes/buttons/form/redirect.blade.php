@if(isset($redirect) && $redirect !== [])
    <a href="{{$redirect['link']}}" class="btn btn-primary">
        {{$redirect['label']}}
    </a>
@endif
