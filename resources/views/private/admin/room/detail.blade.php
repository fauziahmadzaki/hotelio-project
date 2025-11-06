<x-admin.layout>
    <x-card.index class="max-w-2xl mx-auto space-y-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Edit Kamar</h1>

        <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama kamar --}}
            <x-input-group label="Nama Kamar" id="room_name" placeholder="Nama kamar" type="text"
                error="{{ $errors->first('room_name') }}" value="{{ old('room_name', $room->room_name) }}" />

            {{-- Nomor kamar --}}
            <x-input-group label="Nomor Kamar" id="room_code" placeholder="A0231" type="text"
                error="{{ $errors->first('room_code') }}" value="{{ old('room_code', $room->room_code) }}" />

            {{-- Deskripsi --}}
            <x-input-group label="Deskripsi" id="room_description" type="textarea"
                placeholder="Tulis deskripsi kamar anda..." error="{{ $errors->first('room_description') }}"
                value="{{ old('room_description', $room->room_description) }}" />

            {{-- Kapasitas --}}
            <x-input-group label="Kapasitas (orang)" id="room_capacity" type="number" placeholder="1"
                error="{{ $errors->first('room_capacity') }}"
                value="{{ old('room_capacity', $room->room_capacity) }}" />

            {{-- Harga --}}
            <x-input-group label="Harga (Rp)" id="room_price" type="number" placeholder="100000"
                error="{{ $errors->first('room_price') }}" value="{{ old('room_price', $room->room_price) }}" />

            {{-- Status Kamar --}}
            <div>
                <x-label for="status">Status Kamar</x-label>
                @error('status')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select name="room_status" id="status"
                    class="border-gray-200  border focus:ring-violet-400 focus:border-violet-400 rounded-lg w-full p-2.5 text-sm mt-1">
                    @php
                    $statuses = [
                    'available' => 'Tersedia',
                    'booked' => 'Dipesan',
                    'maintenance' => 'Perbaikan',
                    ];
                    @endphp
                    @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" {{ $room->room_status === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Fasilitas --}}
            <div>
                <x-label>Fasilitas</x-label>
                @error('facilities')
                <x-error>{{ $message }}</x-error>
                @enderror
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mt-2">
                    @foreach ($facilities as $item)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="facilities[]" value="{{ $item->id }}" class="accent-violet-600" {{
                            in_array($item->id, old('facilities', $room->facilities->pluck('id')->toArray())) ?
                        'checked' : '' }}>
                        <span>{{ $item->facility_name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Gambar Lama --}}
            @if ($room->image)
            <div>
                <x-label>Gambar Saat Ini</x-label>
                <div class="mt-2 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <img src="{{ asset('storage/' . $room->image) }}" alt="Gambar {{ $room->room_name }}"
                        class="w-48 h-32 object-cover rounded-md shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">Anda dapat mengunggah gambar baru untuk mengganti yang lama.</p>
                </div>
            </div>
            @endif

            {{-- Upload Gambar Baru --}}
            <div>
                <x-label>Gambar Baru</x-label>
                <x-file-uploader name="image" error="{{ $errors->first('image') }}" />
            </div>

            {{-- Tombol --}}
            <x-button type="submit" class="w-full text-white bg-violet-500 hover:bg-violet-600">
                Simpan Perubahan
            </x-button>
        </form>
    </x-card.index>
</x-admin.layout>