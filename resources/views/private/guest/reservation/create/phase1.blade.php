@php
$user = auth()->user();
@endphp

<x-guest.layout>
    <x-card.index class="max-w-lg mx-auto space-y-6 p-6">

        {{-- Gambar kamar --}}
        <div class="flex flex-col items-center space-y-3">
            <img src="{{ asset('/storage/' . $room->image) }}" alt="Foto kamar {{ $room->room_name }}"
                class="rounded-xl shadow-md w-full h-64 max-h-72 object-cover bg-gray-500">
        </div>

        {{-- Informasi kamar --}}
        <div class="space-y-3 text-gray-700">
            <h2 class="text-xl font-semibold text-violet-600">Detail Kamar</h2>
            <p><span class="font-medium">Nama Kamar:</span> {{ $room->room_name }}</p>
            <p><span class="font-medium">Deskripsi:</span> {{ $room->room_description ?? 'Tidak ada deskripsi.' }}</p>

            <div>
                <p class="font-medium mb-1">Fasilitas:</p>
                <ul class="grid grid-cols-2 gap-2 text-sm list-disc list-inside">
                    @forelse ($room->facilities as $facility)
                    <li>{{ $facility->facility_name }}</li>
                    @empty
                    <li>Tidak ada fasilitas terdaftar.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- Step progress --}}


        {{-- Form pemesanan --}}
        <form action="{{ route('guest.reservations.store1') }}" method="POST" class="space-y-4">
            @csrf

            <x-input-group id="person_name" name="person_name" label="Nama Pemesan" type="text" placeholder="John Doe"
                value="{{ old('person_name', $user->name) }}" error="{{ $errors->first('person_name') }}" />

            <x-input-group id="person_phone_number" name="person_phone_number" label="Nomor Handphone" type="text"
                placeholder="0858xxxxxxx" value="{{ old('person_phone_number', $user->profile->phone_number) }}"
                error="{{ $errors->first('person_phone_number') }}" />

            <div class="flex flex-col sm:flex-row gap-4 w-full">
                <x-input-group id="check_in_date" name="check_in_date" label="Tanggal Check-in" type="date"
                    value="{{ old('check_in_date') }}" error="{{ $errors->first('check_in_date') }}" />

                <x-input-group id="check_out_date" name="check_out_date" label="Tanggal Check-out" type="date"
                    value="{{ old('check_out_date') }}" error="{{ $errors->first('check_out_date') }}" />
            </div>

            <x-input-group id="total_guests" name="total_guests" label="Jumlah Tamu" type="number" placeholder="1"
                value="{{ old('total_guests') }}" error="{{ $errors->first('total_guests') }}" />

            {{-- Hidden input --}}
            <input type="hidden" name="room_id" value="{{ $room->id }}">
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <div class="mt-6">
                <div
                    class="relative after:absolute after:inset-x-0 after:top-1/2 after:h-0.5 after:bg-gray-200 after:-translate-y-1/2">
                    <ol class="relative z-10 flex justify-between text-sm font-medium text-gray-600">
                        <li class="flex items-center gap-2 bg-white p-2">
                            <span
                                class="size-6 rounded-full bg-violet-600 text-center text-[10px]/6 font-bold text-white">1</span>
                            <span class="hidden sm:block">Detail Pemesanan</span>
                        </li>
                        <li class="flex items-center gap-2 bg-white p-2">
                            <span class="size-6 rounded-full bg-gray-100 text-center text-[10px]/6 font-bold">2</span>
                            <span class="hidden sm:block">Konfirmasi Pembayaran</span>
                        </li>
                        <li class="flex items-center gap-2 bg-white p-2">
                            <span class="size-6 rounded-full bg-gray-100 text-center text-[10px]/6 font-bold">3</span>
                            <span class="hidden sm:block">Bukti Pembayaran</span>
                        </li>
                    </ol>
                </div>
            </div>

            {{-- Tombol submit --}}
            <x-button type="submit"
                class="w-full bg-violet-600 hover:bg-violet-700 text-white py-2 rounded-lg font-semibold">
                Konfirmasi
            </x-button>
        </form>
    </x-card.index>
</x-guest.layout>