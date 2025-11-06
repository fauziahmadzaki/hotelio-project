@props(['active' => false])

<li class="{{ $active ? " text-violet-500" : "text-gray-600" }} w-full flex items-center p-2 pl-15 text-center gap-2
    font-semibold">
    {{ $slot }}
</li>