@props(['title', 'price' => null, 'img' => null, 'id' => '', 'status' => null])

<div
    class="rounded-xl overflow-hidden bg-white shadow-md hover:shadow-lg transition-all duration-200 flex flex-col h-full w-full sm:w-64">

    {{-- Gambar kamar --}}
    <div class="relative">
        <img src="{{ asset('storage/' . $img) }}" alt="{{ $title }}" class="h-48 w-full object-cover bg-gray-100">
        {{-- Status badge --}}
        @if ($status)
        <span class="absolute top-2 right-2 px-3 py-1 text-xs font-semibold rounded-full
                @if ($status === 'available') bg-green-100 text-green-600
                @elseif ($status === 'booked') bg-yellow-100 text-yellow-600
                @else bg-red-100 text-red-600
                @endif">
            {{ ucfirst($status) }}
        </span>
        @endif
    </div>

    {{-- Isi Card --}}
    <div class="flex flex-col justify-between flex-1 p-4 space-y-2">
        <div>
            <h1 class="text-lg font-bold text-gray-800">{{ $title }}</h1>
            @if($price)
            <p class="text-violet-600 font-semibold text-sm">
                Rp {{ number_format($price, 0, ',', '.') }} <span class="text-gray-500 font-normal">/ malam</span>
            </p>
            @endif
        </div>

        {{-- Tombol aksi --}}
        <div class="flex flex-col sm:flex-row gap-2 mt-3">
            <a href="{{ route('room.detail', $id) }}"
                class="w-full text-center rounded-md border border-violet-500 text-violet-600 font-semibold py-2 hover:bg-violet-50 transition">
                Lihat Detail
            </a>

            @if ($status == 'available')
            <a href="{{ route('guest.reservations.create1', $id) }}"
                class="w-full text-center rounded-md bg-violet-600 text-white font-semibold py-2 hover:bg-violet-700 transition">
                Booking
            </a>
            @else
            <button disabled
                class="w-full text-center rounded-md bg-gray-300 text-white font-semibold py-2 cursor-not-allowed">
                Tidak Tersedia
            </button>
            @endif
        </div>
    </div>
</div>