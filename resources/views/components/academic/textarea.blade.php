@props(['name', 'label' => null, 'value' => null, 'rows' => 3, 'col' => 'col-12', 'required' => false])
<div class="{{ $col }}">
    @if($label)<label class="f-label" for="f-{{ $name }}">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>@endif
    <textarea name="{{ $name }}" id="f-{{ $name }}" rows="{{ $rows }}"
        {{ $attributes->merge(['class' => 'f-input' . ($errors->has($name) ? ' is-invalid' : '')]) }}>{{ old($name, $value) }}</textarea>
    <div class="invalid-feedback {{ $errors->has($name) ? 'd-block' : '' }}" data-error-for="{{ $name }}">{{ $errors->first($name) }}</div>
</div>
