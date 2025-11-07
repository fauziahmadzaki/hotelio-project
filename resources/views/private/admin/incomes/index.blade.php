<x-admin.layout>
    {{-- Tombol tambah reservasi --}}
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold text-gray-800">Daftar Reservasi</h1>
        <x-button>
            <a href="{{ route('admin.incomes.create') }}" class="text-white">
                + Tambah Laporan
            </a>
        </x-button>
    </div>

    {{-- Table Wrapper --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow">
        <table class="min-w-full text-sm text-gray-700 divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Jenis</th>
                    <th class="px-4 py-3 text-left font-semibold">Nominal</th>
                    <th class="px-4 py-3 text-left font-semibold">Deskripsi</th>
                    <th class="px-4 py-3 text-left font-semibold">Kategori</th>
                    <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                    <th class="px-4 py-3 text-left font-semibold">Metode Pembayaran</th>
                    <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($incomes as $income)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-2 font-medium">{{ $income->type }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($income->amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $income->description }}</td>
                    <td class="px-4 py-2">
                        @if ($income->type == 'income')
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Pemasukan
                        </span>
                        @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                            Pengeluaran
                        </span>
                        @endif
                    </td>
                    </td>
                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($income->date)->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-4 py-2">
                        {{ ucfirst($income->payment_method) }}
                    </td>

                    <td class="px-4 py-2 whitespace-nowrap flex items-center justify-center gap-2">
                        {{-- Edit Button --}}
                        <a href="{{ route('admin.incomes.edit', $income) }}"
                            class="inline-block rounded-md border border-indigo-600 bg-indigo-600 px-3 py-1 text-white text-xs font-medium hover:bg-transparent hover:text-indigo-600 transition">
                            Edit
                        </a>
                        {{-- Delete Button --}}
                        <form action="{{ route('admin.incomes.destroy', $income) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus reservasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-block rounded-md border border-red-600 bg-red-600 px-3 py-1 text-white text-xs font-medium hover:bg-transparent hover:text-red-600 transition">
                                Hapus
                            </button>
                        </form>
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