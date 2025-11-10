<x-admin.layout>
    <x-card class="max-w-xl mx-auto">
        <h1 class="text-lg font-bold mb-3">Edit Reservasi</h1>

        {{-- PERBAIKAN: Tentukan route secara dinamis --}}
        @php
        $updateRoute = Auth::user()->role === 'receptionist'
        ? 'receptionist.reservations.update'
        : 'admin.reservations.update';
        $indexRoute = Auth::user()->role === 'receptionist'
        ? 'receptionist.reservations.index'
        : 'admin.reservations.index';
        @endphp

        <form action="{{ route($updateRoute, $reservation->id) }}" method="POST" class="space-y-3">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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

            {{-- Status --}}
            <div>
                <x-label for="status">Status Reservasi</x-label>
                @error('status')
                <x-error>{{ $message }}</x-error>
                @enderror
                {{-- PERBAIKAN: Style select agar konsisten --}}
                <select name="status" id="status"
                    class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-violet-500 focus:outline-none">
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
                <x-label for="payment_method">Metode Pembayaran</x-label>
                @error('payment_method')
                <x-error>{{ $message }}</x-error>
                @enderror
                {{-- PERBAIKAN: Style select agar konsisten --}}
                <select name="payment_method" id="payment_method"
                    class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-violet-500 focus:outline-none">
                    <option value="cash" {{ old('payment_method', $reservation->payment_method) == 'cash' ? 'selected' :
                        '' }}>Tunai</option>
                    <option value="transfer" {{ old('payment_method', $reservation->payment_method) == 'transfer' ?
                        'selected' : '' }}>Transfer</option>
                    <option value="card" {{ old('payment_method', $reservation->payment_method) == 'card' ? 'selected' :
                        '' }}>Kartu</option>
                </select>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end gap-3 pt-3">
                {{-- PERBAIKAN: Tombol kembali --}}
                <a href="{{ route($indexRoute) }}"
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