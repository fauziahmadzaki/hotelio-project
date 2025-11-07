<x-admin.layout>
    <x-card class="max-w-xl">
        <form action="{{ route('admin.reservations.store') }}" method="POST" class="space-y-3">
            @csrf
            <x-input-group id="person_name" placeholder="John Doe" label="Nama" type="text"
                value="{{ old('person_name') }}" error="{{ $errors->first('person_name') }}"></x-input-group>
            <x-input-group id="person_phone_number" placeholder="0858..." label="Nomor HP" type="text"
                value="{{ old('person_phone_number') }}" error="{{ $errors->first('person_phone_number') }}">
            </x-input-group>
            <x-input-group id="notes" placeholder="Catatan tambahan" label="Catatan Tambahan" type="textarea"
                value="{{ old('notes') }}" error="{{ $errors->first('notes') }}">
            </x-input-group>
            <div class="flex gap-4 w-full items-end">
                <x-input-group id="check_in_date" label="Tanggal Checkin" type="date" value="{{ old('check_in_date') }}"
                    error="{{ $errors->first('check_in_date') }}"></x-input-group>
                <x-input-group id="check_out_date" label="Tanggal Checkout" type="date"
                    value="{{ old('check_out_date') }}" error="{{ $errors->first('check_out_date') }}"></x-input-group>
            </div>
            <x-input-group id="total_guests" placeholder="1" label="Jumlah Orang" type="number"
                value="{{ old('total_guests') }}" error="{{ $errors->first('total_guests') }}"></x-input-group>
            <div>
                <x-label>Kamar</x-label>
                @error('room_id')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select name="room_id" id="" value="{{ old('room_id')  }}"
                    class="w-fit border border-gray-200 rounded-lg p-2">
                    @foreach ($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->room_code }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-label>Status</x-label>
                @error('status')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select name="status" value="{{ old('status') ?? 'pending' }}"
                    class="w-fit border border-gray-200 rounded-lg p-2">
                    <option value="pending">Pending</option>
                    <option value="checked_in">Check-in</option>
                </select>
            </div>
            <div>
                <x-label>Metode Pembayaran</x-label>
                @error('payment_method')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select name="payment_method" value="{{ old('type') ?? 'income' }}"
                    class="w-fit border border-gray-200 rounded-lg p-2">
                    <option value="cash">Tunai</option>
                    <option value="transfer">Transfer</option>
                    <option value="card">Kartu</option>
                </select>
            </div>
            <x-button type="submit" class="w-full bg-violet-500 text-white">Buat</x-button>
        </form>
    </x-card>
</x-admin.layout>