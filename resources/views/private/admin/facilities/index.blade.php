<x-admin.layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Fasilitas</h1>
        <x-button class="bg-violet-600 text-white">
            <a href="{{ route('admin.facilities.create') }}">Tambah Fasilitas</a>
        </x-button>
    </div>



    @if ($facilities->isEmpty())
    <x-card class="text-center text-gray-500 py-10">
        <p>Belum ada fasilitas yang ditambahkan.</p>
    </x-card>
    @else
    <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-200">
        <table class="min-w-full text-sm">
            <thead class="bg-violet-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Fasilitas</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($facilities as $index => $facility)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 font-medium">{{ $facility->facility_name }}</td>
                    <td class="px-4 py-3 text-center flex justify-center gap-2">
                        <a href="{{ route('admin.facilities.show', $facility->id) }}"
                            class="inline-block rounded-md border border-indigo-600 bg-indigo-600 px-3 py-1 text-white text-xs font-medium hover:bg-transparent hover:text-indigo-600 transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST"
                            onsubmit="return confirm('Hapus fasilitas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1 bg-red-500 text-white rounded-md text-xs hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</x-admin.layout>