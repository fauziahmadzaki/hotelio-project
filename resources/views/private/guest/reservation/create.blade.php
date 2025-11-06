@php
$user = auth()->user()
@endphp

<x-guest.layout>
    <x-card.index class="w-fit mx-auto">
        <img src="{{ asset('/storage/'. $room->image ) }}" width="500" alt="">
        <h1 class="text-xl font-bold">{{ $room->room_name }}</h1>
        <p class="text-lg font-light">{{ $room->room_description }}</p>
        <form action="{{ route('reservations.store1') }}" class="space-y-3" method="POST">
            @csrf
            @method('POST')
            <x-input-group id="person_name" value="{{ old('person_name') ?? $user->name }}" label="Name" type="text"
                placeholder="John Doe" error="{{ $errors->first('person_name') }}">
            </x-input-group>
            <x-input-group id="person_phone_number" value="{{  old('person_phone_number') ?? $user->phone_number }}"
                label="Nomor HP" type="text" placeholder="0858..." error="{{ $errors->first('person_phone_number') }}">
            </x-input-group>
            <div class="flex gap-4 w-full items-end">
                <x-input-group id="check_in_date" value="{{ old('check_in_date') }}" label="Tanggal Checkin" type="date"
                    error="{{ $errors->first('check_in_date') }}">
                </x-input-group>
                <x-input-group id="check_out_date" value="{{ old('check_out_date') }}" label="Tanggal Checkout"
                    type="date" error="{{ $errors->first('check_out_date') }}">
                </x-input-group>
            </div>
            <x-input-group id="total_guests" value="" label="Jumlah Orang" placeholder="1" type="number"
                error="{{ $errors->first('total_guests') }}">
            </x-input-group>
            <input type="text" hidden value="{{ $room->id }}">
            <x-button type="submit" class="w-full bg-violet-500 text-white">Lanjut</x-button>
        </form>
    </x-card.index>
</x-guest.layout>