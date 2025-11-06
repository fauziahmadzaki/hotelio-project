<x-layout>
    <x-navbar></x-navbar>
    <x-card.index class="max-w-3xl mx-auto space-y-6 p-6 mt-30">
        {{-- Gambar utama --}}
        <div class="flex flex-col sm:flex-row gap-5">
            <div class="w-full sm:w-1/2">
                <img src="{{ asset('storage/' . $room->image) }}" alt="Foto kamar {{ $room->room_name }}"
                    class="rounded-xl shadow-md w-full h-64 object-cover">
            </div>

            {{-- Info utama --}}
            <div class="flex-1 space-y-3">
                <h1 class="text-2xl font-bold text-violet-600">{{ $room->room_name }}</h1>
                <p class="text-gray-600 text-sm leading-relaxed">
                    {{ $room->room_description ?? 'Belum ada deskripsi untuk kamar ini.' }}
                </p>

                <div class="space-y-1 text-sm text-gray-700">
                    <p><span class="font-medium">Kapasitas:</span> {{ $room->room_capacity }} orang</p>
                    <p><span class="font-medium">Harga per malam:</span>
                        <span class="text-violet-600 font-semibold">
                            Rp {{ number_format($room->room_price, 0, ',', '.') }}
                        </span>
                    </p>
                    <p>
                        <span class="font-medium">Status:</span>
                        <span class="font-semibold 
                            @if ($room->room_status === 'available') text-green-600 
                            @elseif ($room->room_status === 'booked') text-yellow-600 
                            @else text-red-600 
                            @endif">
                            {{ ucfirst($room->room_status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <hr class="border-gray-200">

        {{-- Fasilitas --}}
        <div class="space-y-3">
            <h2 class="text-xl font-semibold text-violet-600">Fasilitas</h2>
            @if ($room->facilities->isEmpty())
            <p class="text-gray-500 text-sm">Tidak ada fasilitas yang terdaftar.</p>
            @else
            <ul class="grid grid-cols-2 sm:grid-cols-3 gap-y-2 text-gray-700 text-sm">
                @foreach ($room->facilities as $facility)
                <li>• {{ $facility->facility_name }}</li>
                @endforeach
            </ul>
            @endif
        </div>

        <hr class="border-gray-200">

        {{-- Tombol aksi --}}
        <div class="pt-3">
            @if ($room->room_status === 'available')
            <x-button class="w-full bg-violet-600 hover:bg-violet-700 text-white text-center">
                <a href="{{ route('guest.reservations.create1', $room->id) }}">Pesan Sekarang</a>
            </x-button>
            @else
            <x-button class="w-full bg-gray-400 text-white cursor-not-allowed" disabled>
                Tidak Tersedia
            </x-button>
            @endif
        </div>
    </x-card.index>
</x-layout>