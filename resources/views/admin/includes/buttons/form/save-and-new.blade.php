@if(isset($formConfig['actions']['save-and-new']))
    @php
        $button = $formConfig['actions']['save-and-new'];
    @endphp

    <button type="submit" name="redirect_after" value="{{$button['value']}}" class="btn btn-primary">
        {{$button['label']}}
    </button>
@endif
