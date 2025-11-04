@props(['title', 'price' => null, 'img' => null, 'id' => ''])

<div class="rounded-lg overflow-hidden w-xs h-full bg-white shadow-md">
    {{-- Gambar --}}
    <img src="{{ asset('storage/'.$img) }}" alt="{{ $title }}" class="h-52 w-full object-cover bg-gray-200">

    {{-- Isi Card --}}
    <div class="flex flex-col justify-between p-3">
        <div>
            <h1 class="text-lg font-bold">{{ $title }}</h1>
            @if($price)
            <p class="text-gray-600">{{ number_format($price, 0, ',', '.') }}</p>
            @endif
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex w-full gap-2 mt-3">
            {{-- Tombol Manage pakai <a> langsung --}}
            <a href="{{ $id }}"
                class="w-full text-center rounded-md bg-violet-500 text-white font-semibold py-2 hover:bg-violet-600 transition-colors">
                Manage
            </a>

            {{-- Tombol Delete pakai form POST --}}
            <form action="{{ url('/admin/rooms/destroy/' . $id) }}" method="DELETE" class="w-full">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full flex justify-center items-center rounded-md bg-red-500 text-white py-2 hover:bg-red-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-trash2-icon lucide-trash-2">
                        <path d="M10 11v6" />
                        <path d="M14 11v6" />
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                        <path d="M3 6h18" />
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>