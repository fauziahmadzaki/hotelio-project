<x-admin.layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Kamar</h1>
        <x-button>
            <a href="{{ route('admin.rooms.create') }}" class="text-white">+ Tambah Kamar</a>
        </x-button>
    </div>

    {{-- 🔍 Filter Section --}}
    <x-card class="mb-6">
        <form action="{{ route('admin.rooms.index') }}" method="GET"
            class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            {{-- Status --}}
            <div>
                <x-label>Status</x-label>
                <select name="status" class="border border-gray-300 rounded-lg w-full p-2">
                    <option value="">Semua</option>
                    <option value="available" {{ request('status')=='available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="booked" {{ request('status')=='booked' ? 'selected' : '' }}>Dipesan</option>
                    <option value="maintenance" {{ request('status')=='maintenance' ? 'selected' : '' }}>Perawatan
                    </option>
                </select>
            </div>

            {{-- Fasilitas --}}
            <div>
                <x-label>Fasilitas</x-label>
                <select name="facility" class="border border-gray-300 rounded-lg w-full p-2">
                    <option value="">Semua</option>
                    @foreach ($facilities as $facility)
                    <option value="{{ $facility->id }}" {{ request('facility')==$facility->id ? 'selected' : '' }}>
                        {{ $facility->facility_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Harga Minimum --}}
            <div>
                <x-label>Harga Min</x-label>
                <x-input name="min_price" type="number" placeholder="100000" value="{{ request('min_price') }}" />
            </div>

            {{-- Harga Maksimum --}}
            <div>
                <x-label>Harga Max</x-label>
                <x-input name="max_price" type="number" placeholder="500000" value="{{ request('max_price') }}" />
            </div>

            {{-- Tombol --}}
            <div class="flex gap-2">
                <x-button type="submit" class="bg-violet-500 text-white w-full">Filter</x-button>
                <a href="{{ route('admin.rooms.index') }}"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm text-center w-full">
                    Reset
                </a>
            </div>
        </form>

        {{-- 💾 Data kamar --}}
        @if ($rooms->isEmpty())
        <x-card class="text-center py-10 text-gray-500">
            <p>Belum ada kamar yang tersedia.</p>
        </x-card>
        @else
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($rooms as $room)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition duration-200">
                {{-- Gambar kamar --}}
                <img src="{{ asset('storage/' . $room->image) }}" alt="Foto kamar {{ $room->room_name }}"
                    class="rounded-t-xl w-full h-48 object-cover bg-gray-500">

                {{-- Konten kamar --}}
                <div class="p-5 space-y-2">
                    <h2 class="text-lg font-semibold text-violet-600">
                        {{ $room->room_name }}
                    </h2>

                    <p class="text-gray-600 text-sm line-clamp-2">
                        {{ $room->room_description ?? 'Tidak ada deskripsi kamar.' }}
                    </p>

                    <div class="flex justify-between items-center text-sm text-gray-700 mt-2">
                        <p>Kapasitas: <span class="font-semibold">{{ $room->room_capacity }} org</span></p>
                        <p>Harga:
                            <span class="text-violet-600 font-semibold">
                                Rp {{ number_format($room->room_price, 0, ',', '.') }}
                            </span>
                        </p>
                    </div>

                    {{-- Status --}}
                    <div class="mt-3">
                        <span class="text-xs font-semibold px-3 py-1 rounded-full
                        @if ($room->room_status === 'available') bg-green-100 text-green-700
                        @elseif ($room->room_status === 'booked') bg-yellow-100 text-yellow-700
                        @elseif ($room->room_status === 'maintenance') bg-red-100 text-red-700
                        @endif">
                            {{ ucfirst($room->room_status) }}
                        </span>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="border-t border-gray-100 px-5 py-3 flex justify-between items-center">
                    <a href="{{ route('admin.rooms.detail', $room->id) }}"
                        class="text-sm text-violet-600 hover:underline font-medium">Edit</a>

                    <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus kamar ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:underline font-medium">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-5">
            {{ $rooms->links() }}
        </div>
        @endif
    </x-card>
</x-admin.layout>