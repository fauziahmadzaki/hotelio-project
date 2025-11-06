<x-admin.layout>
    <div class="space-y-6 max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>

        {{-- Statistik Utama --}}
        <div class="grid  gap-5 sm:grid-cols-2 lg:grid-cols-2 place-items-center">
            <x-card class="w-sm p-4 border-l-4 border-violet-500">
                <p class="text-gray-600 text-sm">Total User</p>
                <h2 class="text-3xl font-bold text-violet-600">{{ $totalUsers }}</h2>
            </x-card>

            <x-card class="w-sm p-4 border-l-4 border-blue-500">
                <p class="text-gray-600 text-sm">Total Kamar</p>
                <h2 class="text-3xl font-bold text-blue-600">{{ $totalRooms }}</h2>
            </x-card>

            <x-card class="w-sm p-4 border-l-4 border-green-500">
                <p class="text-gray-600 text-sm">Total Reservasi</p>
                <h2 class="text-3xl font-bold text-green-600">{{ $totalReservations }}</h2>
            </x-card>

            <x-card class="w-sm p-4 border-l-4 border-amber-500">
                <p class="text-gray-600 text-sm">Total Pendapatan</p>
                <h2 class="text-3xl font-bold text-amber-600">
                    Rp{{ number_format($totalRevenue, 0, ',', '.') }}
                </h2>
            </x-card>
        </div>

        {{-- Status Reservasi --}}
        <div class="grid gap-4 sm:grid-cols-2 place-items-center">
            <x-card class="p-4 text-center">
                <p class="text-sm text-gray-600">Pending</p>
                <h2 class="text-2xl font-bold text-yellow-600">{{ $pending }}</h2>
            </x-card>
            <x-card class="p-4 text-center">
                <p class="text-sm text-gray-600">Sedang Checkin</p>
                <h2 class="text-2xl font-bold text-green-600">{{ $confirmed }}</h2>
            </x-card>
            <x-card class="p-4 text-center">
                <p class="text-sm text-gray-600">Selesai</p>
                <h2 class="text-2xl font-bold text-green-600">{{ $completed }}</h2>
            </x-card>
            <x-card class="p-4 text-center">
                <p class="text-sm text-gray-600">Dibatalkan</p>
                <h2 class="text-2xl font-bold text-red-600">{{ $cancelled }}</h2>
            </x-card>
        </div>

        {{-- Reservasi Terbaru --}}
        <x-card class="p-5">
            <h2 class="text-lg font-semibold mb-3">Reservasi Terbaru</h2>
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase border-b">
                    <tr>
                        <th class="py-2">User</th>
                        <th class="py-2">Kamar</th>
                        <th class="py-2">Status</th>
                        <th class="py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentReservations as $res)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2">{{ $res->user->name ?? 'N/A' }}</td>
                        <td class="py-2">{{ $res->room->room_name ?? 'N/A' }}</td>
                        <td
                            class="py-2 capitalize {{ $res->status === 'pending' ? 'text-yellow-600' : ($res->status === 'confirmed' ? 'text-green-600' : 'text-red-600') }}">
                            {{ $res->status }}
                        </td>
                        <td class="py-2 text-right font-semibold">
                            Rp{{ number_format($res->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-3 text-gray-500">Belum ada reservasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </x-card>
    </div>
</x-admin.layout>