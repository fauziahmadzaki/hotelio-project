<div class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Nama Fasilitas</th>
                <th class="px-4 py-3">Aksi</th>


            </tr>
        </thead>
        <tbody>
            @forelse ($facilities as $facility)
            <tr class="border-b hover:bg-gray-50 transition">
                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                <td class="px-4 py-3">
                    <p class="font-semibold">{{ $facility->name }}</p>

                </td>
                <td class="px-4 py-3">
                    <a href="{{ route('admin.facilities.show', $facility->id) }}"
                        class="inline-block rounded-md border border-indigo-600 bg-indigo-600 px-3 py-1 text-white text-xs font-medium hover:bg-transparent hover:text-indigo-600 transition">
                        Edit
                    </a>
                    <form action="" method="POST" onsubmit="return confirm('Hapus fasilitas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-3 py-1 bg-red-500 text-white rounded-md text-xs hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-6 text-gray-500">Belum ada fasilitas yang ditambahkan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>