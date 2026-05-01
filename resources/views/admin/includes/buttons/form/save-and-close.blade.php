@if(isset($formConfig['actions']['save-and-close']))
    @php
        $button = $formConfig['actions']['save-and-close'];
    @endphp

    <button type="submit" name="redirect_after" value="{{$button['value']}}" class="btn btn-primary">
        {{$button['label']}}
    </button>
@endif
