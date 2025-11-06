<x-guest.layout>
    <div class="space-y-6">
        {{-- Judul dan filter --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h1 class="text-2xl font-bold text-gray-800">Reservasi Saya</h1>

            {{-- Filter status --}}
            <form method="GET" action="{{ route('guest.reservations.index') }}" class="flex items-center gap-2">
                <label for="status" class="text-sm text-gray-600">Status:</label>
                <select name="status" id="status"
                    class="text-sm border-gray-300 rounded-md p-1.5 focus:ring-violet-500 focus:border-violet-500">
                    <option value="">Semua</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit"
                    class="px-3 py-1 text-sm bg-violet-500 text-white rounded-md hover:bg-violet-600 transition-all">
                    Terapkan
                </button>
            </form>
        </div>

        {{-- Jika belum ada reservasi --}}
        @if ($reservations->isEmpty())
        <x-card class="text-center py-10 text-gray-500">
            <p>Belum ada reservasi yang dibuat.</p>
            <a href="{{ route('home') }}" class="text-violet-600 underline font-medium">Pesan kamar sekarang</a>
        </x-card>
        @else
        {{-- Daftar reservasi --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($reservations as $reservation)
            <x-card
                class="p-4 flex flex-col justify-between hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                <div>
                    <h2 class="text-lg font-semibold text-violet-700 truncate">
                        {{ $reservation->room->room_name ?? 'Kamar Tidak Diketahui' }}
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Check-in:
                        {{ \Carbon\Carbon::parse($reservation->check_in_date)->translatedFormat('d M Y') }} <br>
                        Check-out:
                        {{ \Carbon\Carbon::parse($reservation->check_out_date)->translatedFormat('d M Y') }}
                    </p>

                    <p class="mt-2 text-sm">
                        Status:
                        <span class="font-semibold
                                    @if ($reservation->status === 'pending') text-yellow-600
                                    @elseif ($reservation->status === 'confirmed') text-green-600
                                    @elseif ($reservation->status === 'cancelled') text-red-600
                                    @endif">
                            {{ ucfirst($reservation->status) }}
                        </span>
                    </p>
                </div>

                <div class="mt-4 flex justify-between items-center border-t pt-2">
                    <p class="text-sm font-medium text-gray-700">
                        Total:
                        <span class="text-violet-600 font-semibold">
                            Rp{{ number_format($reservation->total_price, 0, ',', '.') }}
                        </span>
                    </p>
                    <a href="{{ route('guest.reservations.receipt', $reservation->id) }}"
                        class="text-sm text-violet-600 hover:underline font-medium">
                        Detail
                    </a>
                </div>
            </x-card>
            @endforeach
        </div>
        @endif
    </div>
</x-guest.layout>