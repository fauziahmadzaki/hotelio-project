<x-admin.layout>
    <x-card.index class="max-w-2xl mx-auto p-6 space-y-6">
        <h1 class="text-2xl font-semibold text-gray-800 pb-2">Tambah Kamar</h1>

        <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Nama Kamar --}}
            <x-input-group label="Nama Kamar" id="room_name" name="room_name" type="text" placeholder="Nama kamar"
                value="{{ old('room_name') }}" error="{{ $errors->first('room_name') }}" />

            {{-- Nomor Kamar --}}
            <x-input-group label="Nomor Kamar" id="room_code" name="room_code" type="text" placeholder="A0231"
                value="{{ old('room_code') }}" error="{{ $errors->first('room_code') }}" />

            {{-- Tipe Kamar --}}
            <div>
                <x-label for="room_type_id">Tipe Kamar</x-label>
                @error('room_type_id')
                <x-error>{{ $message }}</x-error>
                @enderror

                <select id="room_type_id" name="room_type_id"
                    class="w-full mt-2 border border-gray-300 rounded-md p-2 text-sm focus:ring-2 focus:ring-violet-500 focus:outline-none">
                    <option value="">-- Pilih Tipe Kamar --</option>
                    @foreach ($roomTypes as $type)
                    <option value="{{ $type->id }}" {{ old('room_type_id')==$type->id ? 'selected' : '' }}>
                        {{ $type->room_type_name }}
                    </option>
                    @endforeach
                </select>
            </div>

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