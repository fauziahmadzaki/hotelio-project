@props(['reservation'])

@php
use Carbon\Carbon;

$room = $reservation->room;
$checkIn = Carbon::parse($reservation->check_in_date);
$checkOut = Carbon::parse($reservation->check_out_date);

$statusColors = [
'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
'confirmed' => 'bg-green-100 text-green-700 border-green-300',
'cancelled' => 'bg-red-100 text-red-700 border-red-300',
];
$statusLabel = ucfirst($reservation->status ?? 'Pending');
$statusColor = $statusColors[$reservation->status] ?? $statusColors['pending'];
@endphp

<a href="{{ route('reservations.show', $reservation->id) }}"
    class="block rounded-xl overflow-hidden bg-white border hover:shadow-md transition-shadow duration-200">
    {{-- Gambar kamar --}}
    <div class="relative">
        <img src="{{ asset('storage/' . $room->image) }}" alt="Foto kamar {{ $room->room_name }}"
            class="h-48 w-full object-cover">
        <span class="absolute top-2 right-2 text-xs px-3 py-1 border rounded-full font-semibold {{ $statusColor }}">
            {{ $statusLabel }}
        </span>
    </div>

    {{-- Isi Card --}}
    <div class="p-4 space-y-2 text-gray-700">
        <h3 class="text-lg font-semibold text-violet-600">{{ $room->room_name }}</h3>
        <p class="text-sm text-gray-600 truncate">{{ $room->room_description }}</p>

        <div class="flex justify-between text-sm mt-2">
            <div>
                <p><span class="font-medium">Check-in:</span><br> {{ $checkIn->translatedFormat('d M Y') }}</p>
            </div>
            <div>
                <p><span class="font-medium">Check-out:</span><br> {{ $checkOut->translatedFormat('d M Y') }}</p>
            </div>
        </div>

        <div class="flex justify-between items-center mt-3">
            <p class="text-violet-700 font-semibold">
                Rp {{ number_format($room->room_price, 0, ',', '.') }}/malam
            </p>
            <x-button class="bg-violet-500 text-white px-3 py-1 text-xs rounded-md">
                Lihat Detail
            </x-button>
        </div>
    </div>
</a>