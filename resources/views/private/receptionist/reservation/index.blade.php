<x-admin.layout>
    <x-slot:title>Manajemen Reservasi</x-slot:title>

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold text-gray-800">Daftar Reservasi</h1>
        <x-button>
            <a href="{{ route('receptionist.reservation.create') }}" class="text-white">
                + Buat Reservasi
            </a>
        </x-button>
    </div>
    <h1 class="text-2xl font-semibold text-gray-800 mb-5">Daftar Reservasi</h1>

    {{-- Flash Message --}}
    @if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">{{ session('success') }}</div>
    @elseif (session('error'))
    <div class="bg-red-100 text-red-800 p-3 rounded-lg mb-4">{{ session('error') }}</div>
    @endif

    {{-- Tabel Reservasi --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Tamu</th>
                    <th class="px-4 py-3">Kamar</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservations as $reservation)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">
                        <p class="font-semibold">{{ $reservation->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $reservation->user->email }}</p>
                    </td>
                    <td class="px-4 py-3">{{ $reservation->room->room_name ?? 'Tidak Diketahui' }}</td>
                    <td class="px-4 py-3 text-sm">
                        <span>{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('d M') }}</span> -
                        <span>{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('d M Y') }}</span>
                    </td>
                    <td class="px-4 py-3 font-semibold text-violet-600">
                        Rp{{ number_format($reservation->total_price, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @switch($reservation->status)
                                    @case('pending') bg-yellow-100 text-yellow-700 @break
                                    @case('confirmed') bg-blue-100 text-blue-700 @break
                                    @case('checkin') bg-purple-100 text-purple-700 @break
                                    @case('completed') bg-green-100 text-green-700 @break
                                    @case('cancelled') bg-red-100 text-red-700 @break
                                @endswitch">
                            {{ ucfirst($reservation->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <form action="{{ route('receptionist.reservations.update', $reservation->id) }}" method="POST"
                            class="inline-block">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                class="text-xs border-gray-300 rounded-md focus:ring-violet-400 focus:border-violet-400">
                                <option value="pending" @selected($reservation->status == 'pending')>Pending</option>
                                <option value="confirmed" @selected($reservation->status == 'confirmed')>Confirmed
                                </option>
                                <option value="checkin" @selected($reservation->status == 'checkin')>Check-in</option>
                                <option value="completed" @selected($reservation->status == 'completed')>Selesai
                                </option>
                                <option value="cancelled" @selected($reservation->status == 'cancelled')>Dibatalkan
                                </option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">Belum ada reservasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $reservations->links() }}
    </div>
</x-admin.layout>