@props(['id', 'type', 'value' => '', 'placeholder', 'label', 'error' => null])

<div class="">
    <x-label for="{{ $id }}">{{ $label }}</x-label>
    @if ($error)
    <x-error>{{ $error }}</x-error>
    @endif
    @if ($type == "textarea")
    <textarea class="w-full border h-40 border-gray-200 p-2 rounded-md" name={{ $id }} value="{{ $value }}"
        placeholder="{{ $placeholder }}"></textarea>
    @else

    <x-input type="{{ $type }}" name="{{ $id }}" value="{{ $value }}" placeholder="{{ $placeholder }}"></x-input>
    @endif



</div>