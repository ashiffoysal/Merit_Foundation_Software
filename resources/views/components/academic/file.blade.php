@props(['name', 'label', 'col' => 'col-md-6', 'accept' => '.pdf,.jpg,.jpeg,.png,.webp,.doc,.docx', 'help' => 'PDF, JPG, PNG, WEBP or Word — max 5 MB'])
<div class="{{ $col }}">
    <label class="f-label" for="f-{{ $name }}">{{ $label }}</label>
    <input type="file" name="{{ $name }}" id="f-{{ $name }}" accept="{{ $accept }}"
        {{ $attributes->merge(['class' => 'f-input' . ($errors->has($name) ? ' is-invalid' : '')]) }}>
    <div class="ac-help">{{ $help }}</div>
    <div class="invalid-feedback {{ $errors->has($name) ? 'd-block' : '' }}" data-error-for="{{ $name }}">{{ $errors->first($name) }}</div>
    {{ $slot }}
</div>
