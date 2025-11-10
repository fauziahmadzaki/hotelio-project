<x-admin.layout>
    <x-card>
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Tipe Kamar</h1>
            <x-button class="bg-violet-600 text-white">
                <a href="{{ route('admin.room-types.create') }}">Tambah Tipe Kamar</a>
            </x-button>
        </div>

        <div class="overflow-x-auto max-w-4xl bg-white shadow-md rounded-lg">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 w-12">#</th>
                        <th class="px-4 py-3">Nama Tipe Kamar</th>
                        <th class="px-4 py-3">Fasilitas</th>
                        <th class="px-4 py-3 text-center w-32">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($roomTypes as $roomType)
                    <tr class="border-b hover:bg-gray-50 transition">
                        {{-- Nomor --}}
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>

                        {{-- Nama tipe kamar --}}
                        <td class="px-4 py-3 font-semibold text-gray-800">
                            {{ $roomType->room_type_name }}
                        </td>

                        {{-- Daftar fasilitas --}}
                        <td class="px-4 py-3">
                            @if ($roomType->facilities->isNotEmpty())
                            <ul class="list-disc list-inside text-gray-700 text-sm space-y-1">
                                @foreach ($roomType->facilities as $facility)
                                <li>{{ $facility->facility_name }}</li>
                                @endforeach
                            </ul>
                            @else
                            <span class="text-gray-400 text-sm italic">
                                Tidak ada fasilitas
                            </span>
                            @endif
                        </td>

                        {{-- Tombol aksi --}}
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.room-types.edit', $roomType) }}"
                                    class="text-blue-600 hover:underline text-sm">Edit</a>

                                {{-- Tombol Hapus --}}
                                <form action="" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus tipe kamar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">
                            Belum ada tipe kamar yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</x-admin.layout>