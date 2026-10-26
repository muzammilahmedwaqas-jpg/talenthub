@props(['status'])

@php
    $color = match ($status) {
        'paid' => 'success',
        'partial' => 'warning',
        default => 'secondary',
    };
@endphp

<span class="badge text-bg-{{ $color }}">{{ ucfirst($status) }}</span>