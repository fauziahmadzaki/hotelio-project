@props(['id', 'type', 'value' => '', 'placeholder' => null, 'label', 'error' => null])

<div>
    <x-label for="{{ $id }}">{{ $label }}</x-label>

    @if ($error)
    <x-error>{{ $error }}</x-error>
    @endif

    @if ($type === 'textarea')
    <textarea name="{{ $id }}" id="{{ $id }}" placeholder="{{ $placeholder ?? '' }}"
        class="w-full border h-40 border-gray-200 p-2 rounded-md">{{ $value }}</textarea>
    @else
    <x-input type="{{ $type }}" id="{{ $id }}" name="{{ $id }}" value="{{ old($id, $value) }}"
        placeholder="{{ $placeholder }}">
    </x-input>
    @endif
</div>