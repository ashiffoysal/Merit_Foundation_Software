@props(['id', 'label', 'icon' => null, 'active' => false])
<li class="nav-item" role="presentation">
    <button class="nav-link {{ $active ? 'active' : '' }}" type="button" data-bs-toggle="tab" data-bs-target="#{{ $id }}" role="tab">
        @if($icon)<i class="fas {{ $icon }} me-1"></i>@endif{{ $label }}<span class="ac-tab-err"></span>
    </button>
</li>
