<x-admin.layout>
    {{-- Tombol tambah reservasi --}}
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold text-gray-800">Daftar Reservasi</h1>
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
                    <th class="px-4 py-3 text-left font-semibold">Aksi</th>

                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($reservations as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-2 font-medium">{{ $item->room->room_code ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $item->person_name }}</td>
                    <td class="px-4 py-2">{{ $item->person_phone_number }}</td>
                    <td class="px-4 py-2">
                        Rp {{ number_format($item->total_price, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($item->check_in_date)->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($item->check_out_date)->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-2 py-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                            {{ ucfirst($item->status) }}
                        </span>

                    </td>
                    <td class="px-4 py-2 text-center">
                        <a href="{{ route('admin.reservations.detail', $item->id ?? 0) }}" class="inline-block rounded-md border border-blue-600 bg-blue-600 px-3 py-1 text-white text-xs
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
</x-admin.layout>