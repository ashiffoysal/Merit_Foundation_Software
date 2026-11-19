@props(['value', 'yes' => 'Yes', 'no' => 'No', 'yesClass' => 'bg-success', 'noClass' => 'bg-secondary'])
<span class="badge {{ $value ? $yesClass : $noClass }}">{{ $value ? $yes : $no }}</span>
