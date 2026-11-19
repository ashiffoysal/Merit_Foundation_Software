@props(['name', 'label' => null, 'options' => [], 'value' => null, 'required' => false, 'col' => 'col-md-6',
        'multiple' => false, 'placeholder' => '— Select —', 'search' => true, 'help' => null])
@php
    $selected = collect(old($name, $value))->map(fn ($v) => (string) $v)->all();
    $field = $multiple ? $name . '[]' : $name;
@endphp
<div class="{{ $col }}">
    @if($label)<label class="f-label" for="f-{{ $name }}">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>@endif
    <select name="{{ $field }}" id="f-{{ $name }}" @if($multiple) multiple @endif @if($search) data-ts @endif
        {{ $attributes->merge(['class' => 'f-input' . ($errors->has($name) ? ' is-invalid' : '')]) }}
        @if($multiple) placeholder="{{ $placeholder }}" @endif>
        @unless($multiple)<option value="">{{ $placeholder }}</option>@endunless
        @foreach($options as $key => $text)
            <option value="{{ $key }}" @selected(in_array((string) $key, $selected, true))>{{ $text }}</option>
        @endforeach
        {{ $slot }}
    </select>
    @if($help)<div class="ac-help">{{ $help }}</div>@endif
    <div class="invalid-feedback {{ $errors->has($name) ? 'd-block' : '' }}" data-error-for="{{ $name }}">{{ $errors->first($name) }}</div>
</div>
