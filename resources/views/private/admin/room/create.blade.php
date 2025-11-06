<x-admin.layout>
    <x-card.index class="max-w-2xl mx-auto p-6 space-y-6">
        <h1 class="text-2xl font-semibold text-gray-800  pb-2">Tambah Kamar</h1>

        <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Nama Kamar --}}
            <x-input-group label="Nama Kamar" id="room_name" name="room_name" type="text" placeholder="Nama kamar"
                value="{{ old('room_name') }}" error="{{ $errors->first('room_name') }}" />

            {{-- Nomor Kamar --}}
            <x-input-group label="Nomor Kamar" id="room_code" name="room_code" type="text" placeholder="A0231"
                value="{{ old('room_code') }}" error="{{ $errors->first('room_code') }}" />

            {{-- Deskripsi --}}
            <x-input-group label="Deskripsi" id="room_description" name="room_description" type="textarea"
                placeholder="Tulis deskripsi kamar anda..." value="{{ old('room_description') }}"
                error="{{ $errors->first('room_description') }}" />

            {{-- Kapasitas --}}
            <x-input-group label="Kapasitas" id="room_capacity" name="room_capacity" type="number" placeholder="1"
                value="{{ old('room_capacity') }}" error="{{ $errors->first('room_capacity') }}" />

            {{-- Harga --}}
            <x-input-group label="Harga" id="room_price" name="room_price" type="number" placeholder="100000"
                value="{{ old('room_price') }}" error="{{ $errors->first('room_price') }}" />

            {{-- Fasilitas --}}
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
            </div>

            {{-- Gambar --}}
            <div>
                <x-label>Gambar</x-label>
                <x-file-uploader name="image" error="{{ $errors->first('image') }}" />
            </div>

            {{-- Tombol Submit --}}
            <x-button type="submit" class="w-full bg-violet-600 hover:bg-violet-700 text-white font-medium rounded-lg">
                Simpan
            </x-button>
        </form>
    </x-card.index>
</x-admin.layout>