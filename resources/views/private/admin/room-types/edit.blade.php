<x-admin.layout>
    <x-card class="max-w-xl mx-auto">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Edit Tipe Kamar</h1>

        <form action="{{ route('admin.room-types.update', $roomType->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama Tipe Kamar --}}
            <x-input-group id="room_type_name" name="room_type_name" label="Nama Tipe Kamar" type="text"
                placeholder="cth: Deluxe, Standard, Suite"
                value="{{ old('room_type_name', $roomType->room_type_name) }}"
                error="{{ $errors->first('room_type_name') }}" />

            {{-- Fasilitas --}}
            <div>
                <x-label for="facilities">Fasilitas</x-label>
                <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($facilities as $facility)
                    <label for="facility_{{ $facility->id }}" class="flex items-center space-x-2">
                        <input type="checkbox" name="facilities[]" id="facility_{{ $facility->id }}"
                            value="{{ $facility->id }}"
                            class="rounded border-gray-300 text-violet-600 shadow-sm focus:ring-violet-500" {{--
                            Cek 'old' (jika validasi gagal) ATAU cek '$assignedFacilities' (data dari database) --}}
                            @if(is_array(old('facilities'))) {{ in_array($facility->id, old('facilities')) ? 'checked' :
                        '' }}
                        @else
                        {{ in_array($facility->id, $assignedFacilities) ? 'checked' : '' }}
                        @endif
                        >
                        <span>{{ $facility->facility_name }}</span>
                    </label>
                    @endforeach
                </div>
                @error('facilities')
                <x-error>{{ $message }}</x-error>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end gap-3 pt-3">
                <a href="{{ route('admin.room-types.index') }}"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium text-gray-700">
                    Batal
                </a>
                <x-button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white">
                    Simpan Perubahan
                </x-button>
            </div>
        </form>
    </x-card>
</x-admin.layout>