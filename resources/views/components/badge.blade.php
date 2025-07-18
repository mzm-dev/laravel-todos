@props(['color' => 'blue'])

@php
    $colorBadge = $color ?? 'blue';
@endphp

<span
    {{ $attributes->merge([
        'class' => "inline-flex items-center rounded-md bg-{$colorBadge}-50 px-2 py-1 text-xs font-medium text-{$colorBadge}-600 ring-1 ring-{$colorBadge}-500/10 ring-inset",
    ]) }}>
    <span class="px-2 py-1 bg-{{$colorBadge }}-500/10 whitespace-nowrap">{{ $slot }}</span>
</span>

