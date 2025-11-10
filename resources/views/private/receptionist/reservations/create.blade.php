<x-admin.layout>
    <x-card class="max-w-xl mx-auto space-y-5">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Buat Reservasi</h1>

        {{-- PERBAIKAN: Tentukan route secara dinamis --}}
        @php
        $storeRoute = Auth::user()->role === 'receptionist'
        ? 'receptionist.reservations.store'
        : 'admin.reservations.store';
        @endphp

        <form action="{{ route($storeRoute) }}" method="POST">
            @csrf

            {{-- Nama Tamu --}}
            {{-- PERBAIKAN: Tambahkan data dari $reservation --}}
            <x-input-group id="person_name" name="person_name" label="Nama Tamu" type="text" placeholder="John Doe"
                value="{{ old('person_name', $reservation->person_name ?? null) }}"
                error="{{ $errors->first('person_name') }}" />

            {{-- Nomor HP --}}
            <x-input-group id="person_phone_number" name="person_phone_number" label="Nomor HP" type="text"
                placeholder="0858..."
                value="{{ old('person_phone_number', $reservation->person_phone_number ?? null) }}"
                error="{{ $errors->first('person_phone_number') }}" />

            {{-- Catatan --}}
            <x-input-group id="notes" name="notes" label="Catatan Tambahan" type="textarea"
                placeholder="Catatan tambahan (opsional)" value="{{ old('notes', $reservation->notes ?? null) }}"
                error="{{ $errors->first('notes') }}" />

            {{-- Tanggal Check-in & Check-out --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-input-group id="check_in_date" name="check_in_date" label="Tanggal Check-in" type="date"
                    value="{{ old('check_in_date', $reservation->check_in_date ?? null) }}"
                    error="{{ $errors->first('check_in_date') }}" />
                <x-input-group id="check_out_date" name="check_out_date" label="Tanggal Check-out" type="date"
                    value="{{ old('check_out_date', $reservation->check_out_date ?? null) }}"
                    error="{{ $errors->first('check_out_date') }}" />
            </div>

            {{-- Jumlah Orang --}}
            <x-input-group id="total_guests" name="total_guests" label="Jumlah Orang" type="number" placeholder="1"
                value="{{ old('total_guests', $reservation->total_guests ?? null) }}"
                error="{{ $errors->first('total_guests') }}" />

            {{-- Pilih Kamar --}}
            <div>
                <x-label for="room_id">Kamar</x-label>
                @error('room_id')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select name="room_id" id="room_id"
                    class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-violet-500 focus:outline-none">
                    <option value="">-- Pilih Kamar --</option>
                    @foreach ($rooms as $room)
                    {{-- PERBAIKAN: Cek 'old' dan '$reservation' --}}
                    <option value="{{ $room->id }}" {{ old('room_id', $reservation->room_id ?? null) == $room->id ?
                        'selected' : '' }}>
                        {{ $room->room_code }} — {{ $room->roomType->room_type_name ?? 'Tipe Tidak Diketahui' }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div>
                <x-label for="status">Status Reservasi</x-label>
                @error('status')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select name="status" id="status"
                    class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-violet-500 focus:outline-none">
                    @php
                    $statuses = [
                    'pending' => 'Pending',
                    'checked_in' => 'Check-in',
                    ];
                    @endphp
                    @foreach ($statuses as $value => $label)
                    {{-- PERBAIKAN: Cek 'old' dan '$reservation', beri default 'pending' --}}
                    <option value="{{ $value }}" {{ old('status', $reservation->status ?? 'pending') == $value ?
                        'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Metode Pembayaran --}}
            <div>
                <x-label for="payment_method">Metode Pembayaran</x-label>
                @error('payment_method')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select name="payment_method" id="payment_method"
                    class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-violet-500 focus:outline-none">
                    @php
                    $methods = [
                    'cash' => 'Tunai',
                    'transfer' => 'Transfer Bank',
                    'card' => 'Kartu Kredit / Debit',
                    ];
                    @endphp
                    @foreach ($methods as $value => $label)
                    {{-- PERBAIKAN: Cek 'old' dan '$reservation' --}}
                    <option value="{{ $value }}" {{ old('payment_method', $reservation->payment_method ?? null) ==
                        $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol Submit --}}
            <x-button type="submit"
                class="w-full bg-violet-600 hover:bg-violet-700 text-white font-semibold py-2 rounded-lg">
                Lanjut ke Rincian Pembayaran
            </x-button>
        </form>
    </x-card>
</x-admin.layout>