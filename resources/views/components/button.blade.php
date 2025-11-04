<button {{ $attributes->class([
    'block p-2 font-semibold rounded-md transition-colors',
    'bg-violet-500 hover:bg-violet-600 text-white' => ! $attributes->has('class'),
    ]) }}>
    {{ $slot }}
</button>