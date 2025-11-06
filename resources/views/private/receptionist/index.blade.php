<x-receptionist.layout>
    <div class="space-y-6">
        {{-- Judul --}}
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Resepsionis 👋</h1>

        {{-- Statistik Utama --}}
        <div class="grid grid-cols-1  lg:grid-cols-3 gap-4">
            <x-card class="p-4 border-l-4 border-violet-500">
                <h2 class="text-gray-600 text-sm font-medium">Total Tamu</h2>
                <p class="text-3xl font-bold text-violet-600">{{ $totalGuests }}</p>
            </x-card>

            <x-card class="p-4 border-l-4 border-indigo-500">
                <h2 class="text-gray-600 text-sm font-medium">Total Kamar</h2>
                <p class="text-3xl font-bold text-indigo-600">{{ $totalRooms }}</p>
            </x-card>

            <x-card class="p-4 border-l-4 border-yellow-500">
                <h2 class="text-gray-600 text-sm font-medium">Check-in Hari Ini</h2>
                <p class="text-3xl font-bold text-yellow-600">{{ $todayCheckIns }}</p>
            </x-card>

            <x-card class="p-4 border-l-4 border-emerald-500">
                <h2 class="text-gray-600 text-sm font-medium">Check-out Hari Ini</h2>
                <p class="text-3xl font-bold text-emerald-600">{{ $todayCheckOuts }}</p>
            </x-card>

            <x-card class="p-4 border-l-4 border-fuchsia-500">
                <h2 class="text-gray-600 text-sm font-medium">Total Pendapatan</h2>
                <p class="text-2xl font-bold text-fuchsia-600">
                    Rp{{ number_format($totalRevenue, 0, ',', '.') }}
                </p>
            </x-card>
        </div>

        {{-- Reservasi Aktif --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Reservasi Aktif</h2>
            @if ($activeReservations > 0)
            <x-card class="p-4">
                <p class="text-gray-700">
                    Terdapat <span class="font-bold text-violet-600">{{ $activeReservations }}</span> reservasi aktif
                    yang sedang berlangsung.
                </p>
                <a href="{{ route('receptionist.reservations.index') }}"
                    class="inline-block mt-3 text-sm text-violet-600 hover:underline">Lihat Semua Reservasi</a>
            </x-card>
            @else
            <x-card class="p-5 text-center text-gray-500">
                <p>Tidak ada reservasi aktif saat ini.</p>
            </x-card>
            @endif
        </div>
    </div>
</x-receptionist.layout>