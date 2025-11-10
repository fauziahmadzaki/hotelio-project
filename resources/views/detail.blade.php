<x-admin.layout>
    <x-card class="max-w-3xl mx-auto space-y-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            Detail Kamar: {{ $room->room_name }}
        </h1>

        {{-- Gambar kamar --}}
        @if ($room->image)
        <img src="{{ asset('storage/' . $room->image) }}" alt="Gambar {{ $room->room_name }}"
            class="w-full max-h-80 object-cover rounded-xl shadow-md border">
        @else
        <div class="bg-gray-200 text-gray-500 text-center py-10 rounded-lg">
            Tidak ada gambar untuk kamar ini.
        </div>
        @endif

        {{-- Informasi Utama --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700">
            <p><strong>Kode Kamar:</strong> {{ $room->room_code }}</p>
            <p><strong>Tipe Kamar:</strong> {{ $room->roomType->room_type_name ?? '-' }}</p>
            <p><strong>Kapasitas:</strong> {{ $room->room_capacity }} orang</p>
            <p><strong>Harga:</strong> Rp {{ number_format($room->room_price, 0, ',', '.') }}</p>
            <p>
                <strong>Status:</strong>
                <span class="
                    px-2 py-1 rounded-full text-xs font-semibold
                    @if ($room->room_status === 'available') bg-green-100 text-green-700
                    @elseif ($room->room_status === 'booked') bg-yellow-100 text-yellow-700
                    @else bg-red-100 text-red-700
                    @endif
                ">
                    {{ ucfirst($room->room_status) }}
                </span>
            </p>
        </div>

        {{-- Deskripsi --}}
        <div class="mt-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi</h2>
            <p class="text-gray-600 leading-relaxed">
                {{ $room->room_description ?? 'Tidak ada deskripsi kamar.' }}
            </p>
        </div>

        {{-- Fasilitas --}}
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Fasilitas Tersedia</h2>

            @php
            $facilities = $room->roomType?->facilities ?? collect();
            @endphp

            @if ($facilities->isNotEmpty())
            <ul class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-gray-700">
                @foreach ($facilities as $facility)
                <li class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 bg-violet-500 rounded-full"></span>
                    {{ $facility->facility_name }}
                </li>
                @endforeach
            </ul>
            @else
            <p class="text-gray-500 italic">Belum ada fasilitas untuk tipe kamar ini.</p>
            @endif
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-2 mt-6">
            <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                Kembali
            </a>
        </div>
    </x-card>
</x-admin.layout>