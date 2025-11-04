@props(['name', 'label' => 'Upload your file(s)', 'multiple' => false, 'error' => null])

<div
    class="flex flex-col items-center rounded border border-gray-300 p-4 text-gray-900 shadow-sm sm:p-6 cursor-pointer relative">
    <label for="{{ $name }}" class="flex flex-col items-center cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m0-3-3-3m0 0-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
        </svg>

        <span class="mt-4 font-medium">{{ $label }}</span>
        <span
            class="mt-2 inline-block rounded border border-gray-200 bg-gray-50 px-3 py-1.5 text-center text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-100">
            Browse files
        </span>
    </label>

    <input type="file" id="{{ $name }}" name="{{ $name }}{{ $multiple ? '[]' : '' }}" class="sr-only" {{ $multiple
        ? 'multiple' : '' }}>

    {{-- Tempat tampilkan nama file --}}

</div>
<div id="{{ $name }}-filename" class="mt-3 text-sm text-gray-600"></div>
@if($error)
<p class="text-red-500 text-sm mt-2">{{ $error }}</p>
@endif

{{-- Script tampilkan nama file --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('{{ $name }}');
    const output = document.getElementById('{{ $name }}-filename');

    input.addEventListener('change', function () {
        if (input.files.length === 0) {
            output.textContent = ''; // reset
            return;
        }

        if (input.files.length === 1) {
            output.textContent = input.files[0].name;
        } else {
            const names = Array.from(input.files).map(f => f.name).join(', ');
            output.textContent = `${input.files.length} files selected: ${names}`;
        }
    });
});
</script>