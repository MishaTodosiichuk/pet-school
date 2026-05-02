@php
    $id = $name . '_' . Str::random(4);
    $mode = $mode ?? 'datetime';

    $types = [
        'date'     => 'date',
        'time'     => 'time',
        'datetime' => 'datetime-local'
    ];
    $inputType = $types[$mode] ?? 'datetime-local';

    $rawValue = old($name, $value ?? null);
    $formattedValue = '';

    if ($rawValue) {
        try {
            $dateInstance = ($rawValue instanceof \Illuminate\Support\Carbon)
                ? $rawValue
                : \Illuminate\Support\Carbon::parse($rawValue);

            $formattedValue = match($mode) {
                'date'     => $dateInstance->format('Y-m-d'),
                'time'     => $dateInstance->format('H:i'),
                'datetime' => $dateInstance->format('Y-m-d\TH:i'),
                default    => $dateInstance->format('Y-m-d\TH:i'),
            };
        } catch (\Exception $e) {
            $formattedValue = '';
        }
    }
@endphp

<div class="form-group">

    @if(isset($label))
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    <input
        type="{{ $inputType }}"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $formattedValue }}"
        class="form-control @error($name) is-invalid @enderror"
        @isset($required) required @endisset
        @isset($readonly) readonly @endisset
    >

    @error($name)
    <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
