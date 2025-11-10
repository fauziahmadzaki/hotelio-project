<x-admin.layout>
    <x-card.index class="max-w-2xl mx-auto space-y-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Edit Kamar</h1>

        <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama kamar --}}
            <x-input-group label="Nama Kamar" id="room_name" name="room_name" type="text" placeholder="Nama kamar"
                value="{{ old('room_name', $room->room_name) }}" error="{{ $errors->first('room_name') }}" />

            {{-- Nomor kamar --}}
            <x-input-group label="Nomor Kamar" id="room_code" name="room_code" type="text" placeholder="A0231"
                value="{{ old('room_code', $room->room_code) }}" error="{{ $errors->first('room_code') }}" />

            {{-- Tipe Kamar --}}
            <div>
                <x-label for="room_type_id">Tipe Kamar</x-label>
                @error('room_type_id')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select id="room_type_id" name="room_type_id"
                    class="border-gray-200 border focus:ring-violet-400 focus:border-violet-400 rounded-lg w-full p-2.5 text-sm mt-1">
                    <option value="">-- Pilih Tipe Kamar --</option>
                    @foreach ($roomTypes as $type)
                    <option value="{{ $type->id }}" {{ old('room_type_id', $room->room_type_id) == $type->id ?
                        'selected' : '' }}>
                        {{ $type->room_type_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Deskripsi --}}
            <div>
                <x-label for="room_description">Deskripsi</x-label>
                @error('room_description')
                <x-error>{{ $message }}</x-error>
                @enderror
                <textarea id="room_description" name="room_description" rows="4"
                    placeholder="Tulis deskripsi kamar anda..."
                    class="w-full mt-2 border border-gray-300 rounded-md p-2 text-sm focus:ring-2 focus:ring-violet-500 focus:outline-none">{{ old('room_description', $room->room_description) }}</textarea>
            </div>

            {{-- Kapasitas --}}
            <x-input-group label="Kapasitas (orang)" id="room_capacity" name="room_capacity" type="number"
                placeholder="1" value="{{ old('room_capacity', $room->room_capacity) }}"
                error="{{ $errors->first('room_capacity') }}" />

            {{-- Harga --}}
            <x-input-group label="Harga (Rp)" id="room_price" name="room_price" type="number" placeholder="100000"
                value="{{ old('room_price', $room->room_price) }}" error="{{ $errors->first('room_price') }}" />

            {{-- Status Kamar --}}
            <div>
                <x-label for="room_status">Status Kamar</x-label>
                @error('room_status')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select name="room_status" id="room_status"
                    class="border-gray-200 border focus:ring-violet-400 focus:border-violet-400 rounded-lg w-full p-2.5 text-sm mt-1">
                    @php
                    $statuses = [
                    'available' => 'Tersedia',
                    'booked' => 'Dipesan',
                    'maintenance' => 'Perbaikan',
                    ];
                    @endphp
                    @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" {{ old('room_status', $room->room_status) === $value ? 'selected' : ''
                        }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Gambar Lama --}}
            @if ($room->image)
            <div>
                <x-label>Gambar Saat Ini</x-label>
                <div class="mt-2 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <img src="{{ asset('storage/' . $room->image) }}" alt="Gambar {{ $room->room_name }}"
                        class="w-48 h-32 object-cover rounded-md shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">
                        Anda dapat mengunggah gambar baru untuk mengganti yang lama.
                    </p>
                </div>
            </div>
            @endif

            {{-- Upload Gambar Baru --}}
            <div>
                <x-label>Gambar</x-label>
                <x-file-uploader name="image" error="{{ $errors->first('image') }}" />
            </div>

            {{-- Tombol --}}
            <x-button type="submit" class="w-full text-white bg-violet-600 hover:bg-violet-700">
                Simpan Perubahan
            </x-button>
        </form>
    </x-card.index>
</x-admin.layout>