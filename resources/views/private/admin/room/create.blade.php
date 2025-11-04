<x-admin.layout>
    <x-card.index class="w-xl mx-auto">
        <h1>Tambah Kamar</h1>
        <form action="{{ route('admin.rooms.store') }}" method="POST" class="space-y-3" enctype="multipart/form-data">
            @csrf
            <x-input-group label="Nama Kamar" id="room_name" placeholder="Nama kamar" type="text"
                error="{{ $errors->first('room_name') }}" value="{{ old('room_name') }}"></x-input-group>
            <x-input-group label="Nomor Kamar" id="room_code" placeholder="A0231" value="{{ old('room_code') }}"
                type="text" error="{{ $errors->first('room_code') }} ">
            </x-input-group>
            <x-input-group label="Deskripsi" id="room_description" type="textarea"
                placeholder="Tulis deskripsi kamar anda..." error="{{ $errors->first('room_description') }}"
                value="{{ old('room_description') }}">
            </x-input-group>

            <x-input-group label="Kapasitas" id="room_capacity" placeholder="1" value="{{ old('room_capacity') }}"
                error="{{ $errors->first('room_capacity') }}" type="number"></x-input-group>
            <x-input-group label="Harga" id="room_price" placeholder="100000" value="{{ old('room_price') }}"
                error="{{ $errors->first('room_price') }}" type="number"></x-input-group>
            <x-label>Gambar</x-label>
            <x-file-uploader name="image" error="{{ $errors->first('image') }}"></x-file-uploader>
            <x-button type="submit" class="w-full text-white bg-violet-500">Simpan</x-button>
        </form>
    </x-card.index>
</x-admin.layout>