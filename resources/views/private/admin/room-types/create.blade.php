<x-admin.layout>
    <x-card class="max-w-lg">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Tipe Kamar</h1>
        <form action="{{ route('admin.room-types.store') }}" class="space-y-5" method="POST">
            @csrf

            <x-input-group label="Nama Tipe Kamar" id="room_type_name" placeholder="Tipe kamar" type="text"
                value="{{ old('room_type_name') }}" error="{{ $errors->first('room_type_name') }}"></x-input-group>
            <div>
                <x-label>Fasilitas</x-label>
                @error('facilities')
                <x-error>{{ $message }}</x-error>
                @enderror

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mt-2">
                    @foreach ($facilities as $item)
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="facilities[]" value="{{ $item->id }}" {{ in_array($item->id,
                        old('facilities', [])) ? 'checked' : '' }}
                        class="accent-violet-600 rounded-md"
                        >
                        <span>{{ $item->facility_name }}</span>
                    </label>
                    @endforeach
                </div>
                <x-button type="submit" class="w-full block bg-violet-500 text-white">Simpan</x-button>
        </form>
        </div>
    </x-card>

</x-admin.layout>
<x-admin.layout>
    <x-card class="max-w-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Tambah Tipe Kamar</h1>

        <form action="{{ route('admin.room-types.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Input Nama Tipe Kamar --}}
            <x-input-group label="Nama Tipe Kamar" id="room_type_name" name="room_type_name" placeholder="Tipe kamar"
                type="text" value="{{ old('room_type_name') }}" error="{{ $errors->first('room_type_name') }}" />

            {{-- Fasilitas --}}
            <div>
                <x-label>Fasilitas</x-label>
                @error('facilities')
                <x-error>{{ $message }}</x-error>
                @enderror

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mt-2">
                    @forelse ($facilities as $item)
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="facilities[]" value="{{ $item->id }}" {{ in_array($item->id,
                        old('facilities', [])) ? 'checked' : '' }}
                        class="accent-violet-600 rounded-md"
                        >
                        <span>{{ $item->facility_name }}</span>
                    </label>
                    @empty
                    <p class="text-sm text-gray-500 col-span-full">
                        Belum ada fasilitas yang tersedia.
                    </p>
                    @endforelse
                </div>
            </div>

            {{-- Tombol Simpan --}}
            <x-button type="submit" class="w-full bg-violet-600 text-white hover:bg-violet-700">
                Simpan
            </x-button>
        </form>
    </x-card>
</x-admin.layout>