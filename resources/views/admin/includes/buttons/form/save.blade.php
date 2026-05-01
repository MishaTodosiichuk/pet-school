@if(isset($formConfig['actions']['save']))
    @php
        $button = $formConfig['actions']['save'];
    @endphp

    <button type="submit" name="redirect_after" value="{{$button['value']}}" class="btn btn-primary">
        {{$button['label']}}
    </button>
@endif
