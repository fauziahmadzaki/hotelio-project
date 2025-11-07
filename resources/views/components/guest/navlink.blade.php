@props(['active' => false])
@php
$activeClass = $active ? 'bg-gray-100' : '';
@endphp

<a {{ $attributes->class([
    "block rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-100 text-gray-600 hover:text-gray-700 ",
    $activeClass])}}>{{ $slot
    }}</a>