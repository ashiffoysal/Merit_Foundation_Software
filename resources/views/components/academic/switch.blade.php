@props(['name', 'label', 'checked' => false, 'col' => 'col-md-4', 'help' => null])
<div class="{{ $col }}">
    <div class="ac-switch form-switch">
        <input type="hidden" name="{{ $name }}" value="0">
        <input class="form-check-input" type="checkbox" role="switch" name="{{ $name }}" value="1" id="f-{{ $name }}"
            @checked(old($name, $checked)) {{ $attributes }}>
        <label for="f-{{ $name }}">{{ $label }}</label>
    </div>
    @if($help)<div class="ac-help">{{ $help }}</div>@endif
    <div class="invalid-feedback" data-error-for="{{ $name }}"></div>
</div>
