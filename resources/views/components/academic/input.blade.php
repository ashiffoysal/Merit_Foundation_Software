@props(['name', 'label' => null, 'type' => 'text', 'value' => null, 'required' => false, 'col' => 'col-md-6', 'help' => null])
@php $val = $type === 'password' ? '' : old($name, $value instanceof \DateTimeInterface ? $value->format('Y-m-d') : $value); @endphp
<div class="{{ $col }}">
    @if($label)<label class="f-label" for="f-{{ $name }}">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>@endif
    <input type="{{ $type }}" name="{{ $name }}" id="f-{{ $name }}" value="{{ $val }}" @required($required)
        {{ $attributes->merge(['class' => 'f-input' . ($errors->has($name) ? ' is-invalid' : '')]) }}>
    @if($help)<div class="ac-help">{{ $help }}</div>@endif
    <div class="invalid-feedback {{ $errors->has($name) ? 'd-block' : '' }}" data-error-for="{{ $name }}">{{ $errors->first($name) }}</div>
</div>
