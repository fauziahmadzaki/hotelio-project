@props([
'title',
'price' => null,
'img' => null,
'id' => '',
'status' => 'available',
'capacity' => null,
'code' => null,
])

<div
    class="rounded-xl overflow-hidden bg-white shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col">
    {{-- Gambar kamar --}}
    <div class="relative">
        @if ($img)
        <img src="{{ asset('storage/' . $img) }}" alt="{{ $title }}" class="h-52 w-full object-cover bg-gray-100">
        @else
        <div class="h-52 w-full bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
            Tidak ada gambar
        </div>
        @endif

        {{-- Badge status kamar --}}
        <span class="absolute top-3 left-3 text-xs px-3 py-1 rounded-full font-semibold
            {{ $status === 'available' ? 'bg-green-100 text-green-700' : '' }}
            {{ $status === 'booked' ? 'bg-yellow-100 text-yellow-700' : '' }}
            {{ $status === 'maintenance' ? 'bg-red-100 text-red-700' : '' }}">
            {{ ucfirst($status) }}
        </span>
    </div>

    {{-- Isi card --}}
    <div class="flex flex-col justify-between flex-1 p-4 space-y-3">
        <div>
            <h1 class="text-lg font-bold text-gray-800">{{ $title }}</h1>

            @if ($code)
            <p class="text-sm text-gray-500">Kode kamar: {{ $code }}</p>
            @endif

            @if ($capacity)
            <p class="text-sm text-gray-500">Kapasitas: {{ $capacity }} orang</p>
            @endif

            @if ($price)
            <p class="text-violet-600 font-semibold mt-1">
                Rp {{ number_format($price, 0, ',', '.') }}
                <span class="text-gray-500 text-sm font-normal">/ malam</span>
            </p>
            @endif
        </div>

        {{-- Tombol aksi --}}
        <div class="flex w-full gap-2 mt-auto">
            {{-- Tombol Kelola --}}
            <a href="{{ route('admin.rooms.detail', $id) }}"
                class="flex-1 text-center rounded-md bg-violet-500 text-white font-semibold py-2 hover:bg-violet-600 transition-colors">
                Kelola
            </a>

            {{-- Tombol Hapus --}}
            <form action="{{ route('admin.rooms.destroy', $id) }}" method="POST" class="w-fit">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Yakin ingin menghapus kamar ini?')"
                    class="w-10 h-full flex justify-center items-center rounded-md bg-red-500 text-white hover:bg-red-600 transition-colors">
                    {{-- Trash Icon (Heroicons style) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                        <path
                            d="M3 6h18M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2m2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6z" />
                        <line x1="10" y1="11" x2="10" y2="17" />
                        <line x1="14" y1="11" x2="14" y2="17" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>