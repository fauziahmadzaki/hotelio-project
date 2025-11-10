<x-receptionist.layout>
    {{-- Header --}}
    <div class="flex justify-between items-center mb-5">
        <h1 class="text-xl font-bold text-gray-800">Daftar Reservasi Tamu</h1>
        <x-button>
            <a href="{{ route('receptionist.reservations.create') }}" class="text-white">
                + Tambah Reservasi
            </a>
        </x-button>
    </div>

    {{-- Table Wrapper --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow">
        <table class="min-w-full text-sm text-gray-700 divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Kamar</th>
                    <th class="px-4 py-3 text-left font-semibold">Nama Pemesan</th>
                    <th class="px-4 py-3 text-left font-semibold">Kontak</th>
                    <th class="px-4 py-3 text-left font-semibold">Total Harga</th>
                    <th class="px-4 py-3 text-left font-semibold">Check-in</th>
                    <th class="px-4 py-3 text-left font-semibold">Check-out</th>
                    <th class="px-4 py-3 text-left font-semibold">Status</th>
                    <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($reservations as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-2 font-medium">{{ $item->room->room_code ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $item->person_name }}</td>
                    <td class="px-4 py-2">{{ $item->person_phone_number }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->check_in_date)->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->check_out_date)->translatedFormat('d M Y') }}
                    </td>

                    {{-- Kolom Status --}}
                    <td class="px-4 py-2">
                        <form action="{{ route('receptionist.reservations.update', $item->id) }}" method="POST"
                            class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status"
                                class="border-gray-300 rounded-md text-sm px-2 py-1 focus:ring-violet-500 focus:border-violet-500">
                                <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="checked_in" {{ $item->status === 'checked_in' ? 'selected' : ''
                                    }}>Checked In</option>
                                <option value="cancelled" {{ $item->status === 'cancelled' ? 'selected' : ''
                                    }}>Cancelled</option>
                                <option value="completed" {{ $item->status === 'completed' ? 'selected' : ''
                                    }}>Completed</option>
                            </select>
                            <button type="submit"
                                class="rounded-md bg-violet-600 text-white px-3 py-1 text-xs font-medium hover:bg-violet-700 transition">
                                Simpan
                            </button>
                        </form>
                    </td>

                    {{-- Kolom Aksi --}}
                    <td class="px-4 py-2 text-center">
                        <a href="" class="inline-block rounded-md border border-blue-600 bg-blue-600 px-3 py-1 text-white text-xs
                        font-medium hover:bg-transparent hover:text-blue-600 transition">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-6 text-gray-500">
                        Belum ada reservasi yang tercatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-receptionist.layout>