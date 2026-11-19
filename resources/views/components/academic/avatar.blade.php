@props(['model', 'size' => ''])
@if($model->photo_url)
    <img src="{{ $model->photo_url }}" alt="" class="ac-avatar {{ $size }}" loading="lazy">
@else
    <span class="ac-avatar {{ $size }}">{{ $model->initials }}</span>
@endif
