<x-guest.layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8">

        {{-- Judul --}}
        <h1 class="text-2xl font-bold text-gray-800 text-center sm:text-left">
            Selamat Datang, {{ auth()->user()->name }} 👋
        </h1>

        {{-- Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-card
                class="border-l-4 border-violet-500 p-4 flex flex-col justify-center items-start sm:items-center text-center sm:text-left shadow-sm hover:shadow-md transition-all duration-200">
                <h2 class="font-semibold text-gray-700">Kamar Dibooking</h2>
                <p class="text-3xl font-bold mt-1 text-violet-600">{{ $pendingCount ?? 0 }}</p>
            </x-card>

            <x-card
                class="border-l-4 border-yellow-500 p-4 flex flex-col justify-center items-start sm:items-center text-center sm:text-left shadow-sm hover:shadow-md transition-all duration-200">
                <h2 class="font-semibold text-gray-700">Belum Check-in</h2>
                <p class="text-3xl font-bold mt-1 text-yellow-600">{{ $confirmedCount ?? 0 }}</p>
            </x-card>

            <x-card
                class="border-l-4 border-red-500 p-4 flex flex-col justify-center items-start sm:items-center text-center sm:text-left shadow-sm hover:shadow-md transition-all duration-200">
                <h2 class="font-semibold text-gray-700">Dibatalkan</h2>
                <p class="text-3xl font-bold mt-1 text-red-600">{{ $cancelledCount ?? 0 }}</p>
            </x-card>
        </div>

        {{-- Reservasi Terakhir --}}
        @if ($latest)
        <x-card
            class="max-w-2xl mx-auto p-5 flex flex-col sm:flex-row gap-4 items-center shadow-sm hover:shadow-md transition-all duration-200">
            @if ($latest['room_image'])
            <img src="{{ $latest['room_image'] }}" alt="Gambar kamar"
                class="w-full sm:w-32 h-48 sm:h-32 object-cover rounded-lg shadow-md">
            @endif

            <div class="flex-1 text-center sm:text-left">
                <h2 class="text-xl font-semibold text-violet-700">{{ $latest['room_name'] }}</h2>
                <p class="text-gray-600 text-sm mt-1 leading-relaxed">
                    Check-in: {{ $latest['check_in'] }}<br>
                    Check-out: {{ $latest['check_out'] }}
                </p>
                <p class="mt-2 text-sm">
                    Status:
                    <span class="font-semibold capitalize
                            @if (strtolower($latest['status']) === 'pending') text-yellow-600
                            @elseif (strtolower($latest['status']) === 'confirmed') text-green-600
                            @elseif (strtolower($latest['status']) === 'cancelled') text-red-600
                            @else text-gray-600 @endif">
                        {{ $latest['status'] }}
                    </span>
                </p>
            </div>
        </x-card>
        @else
        {{-- Jika belum ada reservasi --}}
        <div class="text-gray-500 mt-8 text-center">
            <p>
                Belum ada reservasi aktif. Yuk,
                <a href="{{ route('home') }}" class="text-violet-600 underline hover:text-violet-700">
                    pesan kamar
                </a> sekarang!
            </p>
        </div>
        @endif
    </div>
</x-guest.layout>