<x-admin.layout>
    <x-card class="max-w-xl">
        <h1 class="text-lg font-bold mb-3">Edit Reservasi</h1>

        <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" class="space-y-3">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <x-input-group id="person_name" placeholder="John Doe" label="Nama" type="text"
                value="{{ old('person_name', $reservation->person_name) }}" error="{{ $errors->first('person_name') }}">
            </x-input-group>

            {{-- Nomor HP --}}
            <x-input-group id="person_phone_number" placeholder="0858..." label="Nomor HP" type="text"
                value="{{ old('person_phone_number', $reservation->person_phone_number) }}"
                error="{{ $errors->first('person_phone_number') }}"></x-input-group>

            {{-- Catatan --}}
            <x-input-group id="notes" placeholder="Catatan tambahan" label="Catatan Tambahan" type="textarea"
                value="{{ old('notes', $reservation->notes) }}" error="{{ $errors->first('notes') }}"></x-input-group>

            {{-- Tanggal Check-in & Check-out --}}
            <div class="flex gap-4 w-full items-end">
                <x-input-group id="check_in_date" label="Tanggal Check-in" type="date"
                    value="{{ old('check_in_date', $reservation->check_in_date->format('Y-m-d')) }}"
                    error="{{ $errors->first('check_in_date') }}"></x-input-group>

                <x-input-group id="check_out_date" label="Tanggal Check-out" type="date"
                    value="{{ old('check_out_date', $reservation->check_out_date->format('Y-m-d')) }}"
                    error="{{ $errors->first('check_out_date') }}"></x-input-group>
            </div>

            {{-- Jumlah Orang --}}
            <x-input-group id="total_guests" placeholder="1" label="Jumlah Orang" type="number"
                value="{{ old('total_guests', $reservation->total_guests) }}"
                error="{{ $errors->first('total_guests') }}"></x-input-group>

            {{-- Pilih Kamar --}}
            <div>
                <x-label>Kamar</x-label>
                @error('room_id')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select name="room_id" class="w-fit border border-gray-200 rounded-lg p-2">
                    @foreach ($rooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id', $reservation->room_id) == $room->id ? 'selected' :
                        '' }}>
                        {{ $room->room_code }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div>
                <x-label>Status</x-label>
                @error('status')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select name="status" class="w-fit border border-gray-200 rounded-lg p-2">
                    <option value="pending" {{ old('status', $reservation->status) == 'pending' ? 'selected' : ''
                        }}>Pending</option>
                    <option value="checked_in" {{ old('status', $reservation->status) == 'checked_in' ? 'selected' : ''
                        }}>Check-in</option>
                    <option value="completed" {{ old('status', $reservation->status) == 'completed' ? 'selected' :
                        '' }}>Selesai</option>
                    <option value="cancelled" {{ old('status', $reservation->status) == 'cancelled' ? 'selected' : ''
                        }}>Dibatalkan</option>
                </select>
            </div>

            {{-- Metode Pembayaran --}}
            <div>
                <x-label>Metode Pembayaran</x-label>
                @error('payment_method')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select name="payment_method" class="w-fit border border-gray-200 rounded-lg p-2">
                    <option value="cash" {{ old('payment_method', $reservation->payment_method) == 'cash' ? 'selected' :
                        '' }}>Tunai</option>
                    <option value="transfer" {{ old('payment_method', $reservation->payment_method) == 'transfer' ?
                        'selected' : '' }}>Transfer</option>
                    <option value="card" {{ old('payment_method', $reservation->payment_method) == 'card' ? 'selected' :
                        '' }}>Kartu</option>
                </select>
            </div>

            {{-- Tombol Submit --}}
            <x-button type="submit" class="w-full bg-violet-500 text-white">Simpan Perubahan</x-button>
        </form>
    </x-card>
</x-admin.layout>