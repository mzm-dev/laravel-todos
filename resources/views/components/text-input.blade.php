@props(['label' => null])

@php
    $formName =
        $attributes->whereStartsWith('wire:model')->first() ??
        ($attributes->filter(fn($value, $key) => $key === 'name')->first() ?? '');
@endphp

@if ($label)
    <x-input-label @class(['text-red-700' => $errors->has($formName)]) for="{{ $formName }}" value="{{ $label }}" />
@endif

<input id="{{ $formName }}"
    {{ $attributes->merge(['type' => 'text'])->class([
        // Base Tailwind style
        'block w-full text-sm rounded-md shadow-sm p-2.5 bg-white border',
        // Success / Normal border
        'border-gray-300 focus:border-blue-600 focus:ring focus:ring-blue-100' => !$errors->has($formName),
        // Error border
        'border-red-500 focus:border-red-500 focus:ring focus:ring-red-100' => $errors->has($formName),
    ]) }}
    value="{{ old($formName, $attributes->filter(fn($value, $key) => $key === 'value')->first()) }}">

@error($formName)
    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
@enderror
