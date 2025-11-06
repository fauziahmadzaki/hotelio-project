<x-admin.layout>
    <x-card class="max-w-xl mx-auto">
        <h1 class="text-xl font-bold">Edit Reservasi</h1>
        <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST" class="space-y-3">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <x-input-group id="person_name" placeholder="John Doe" label="Nama" type="text"
                value="{{ old('person_name', $reservation->person_name) }}"
                error="{{ $errors->first('person_name') }}" />

            {{-- Nomor HP --}}
            <x-input-group id="person_phone_number" placeholder="0858..." label="Nomor HP" type="text"
                value="{{ old('person_phone_number', $reservation->person_phone_number) }}"
                error="{{ $errors->first('person_phone_number') }}" />

            {{-- Check-in & Check-out --}}

            {{-- Jumlah Tamu --}}
            <x-input-group id="total_guests" placeholder="1" label="Jumlah Orang" type="number"
                value="{{ old('total_guests', $reservation->total_guests) }}"
                error="{{ $errors->first('total_guests') }}" />

            {{-- Pilihan Kamar --}}
            <div>
                <x-label>Kamar</x-label>
                @error('room_id')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select name="room_id" class="border border-gray-200 rounded-lg p-2 w-full">
                    <option value="{{ $reservation->room_id }}" selected>
                        {{ $reservation->room->room_code }}
                    </option>
                    @foreach ($rooms as $room)
                    @if ($room->id !== $reservation->room_id)
                    <option value="{{ $room->id }}">{{ $room->room_code }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div>
                <x-label>Status</x-label>
                @error('status')
                <x-error>{{ $message }}</x-error>
                @enderror
                <select name="status" class="border border-gray-200 rounded-lg p-2 w-full">
                    @foreach (['pending', 'cancelled', 'checked_in', 'completed'] as $status)
                    @if ($reservation->status === $status)
                    <option value="{{ $status }}" selected>
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </option>
                    @else
                    <option value="{{ $status }}">
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </option>

                    @endif
                    @endforeach
                </select>
            </div>

            <x-button type="submit" class="w-full bg-violet-500 text-white">Perbarui</x-button>
        </form>
    </x-card>
</x-admin.layout>