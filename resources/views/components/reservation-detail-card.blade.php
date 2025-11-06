@props(['reservation', 'user'])
@php
use Carbon\Carbon;

$room = $reservation->room;
$checkIn = Carbon::parse($reservation->check_in_date);
$checkOut = Carbon::parse($reservation->check_out_date);
$days = max(1, $checkOut->diffInDays($checkIn));

// Mapping warna/status tampilan
$statusColors = [
'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
'confirmed' => 'bg-green-100 text-green-700 border-green-300',
'cancelled' => 'bg-red-100 text-red-700 border-red-300',
];
$statusLabel = ucfirst($reservation->status ?? 'Pending');
$statusColor = $statusColors[$reservation->status] ?? $statusColors['pending'];
@endphp


<x-card.index class="flex-1 max-w-xl space-y-6 p-6">
    {{-- Gambar kamar --}}
    <div class="flex flex-col space-y-3">
        <h1 class="text-lg font-bold">Reservasi Terbaru</h1>
        <img src="{{ asset('/storage/' . $room->image) }}" alt="Foto kamar {{ $room->room_name }}"
            class="rounded-xl shadow-md w-full object-cover max-h-72">
    </div>

    {{-- Informasi kamar --}}
    <div class="space-y-3 text-gray-700">
        <h2 class="text-xl font-semibold text-violet-600">Detail Kamar</h2>
        <p><span class="font-medium">Nama Kamar:</span> {{ $room->room_name }}</p>
        <p><span class="font-medium">Deskripsi:</span> {{ $room->room_description }}</p>

        <div>
            <p class="font-medium mb-1">Fasilitas:</p>
            <div class="grid grid-cols-2 gap-x-4 text-sm font-medium">
                @foreach ($room->facilities as $facility)
                <p>• {{ $facility->facility_name }}</p>
                @endforeach
            </div>
        </div>
    </div>

    <hr class="my-4 border-gray-200">

    {{-- Informasi pemesanan --}}
    <div class="space-y-2 text-gray-700">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-violet-600">Rincian Pemesanan</h2>
            <span class="text-xs px-3 py-1 border rounded-full font-semibold {{ $statusColor }}">
                {{ $statusLabel }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-x-2 gap-y-2 text-sm">
            <p><span class="font-medium">Nama Pemesan:</span> {{ $reservation->person_name }}</p>
            <p><span class="font-medium">Nomor HP:</span> {{ $reservation->person_phone_number }}</p>
            <p><span class="font-medium">Check-in:</span> {{ $checkIn->translatedFormat('l, d F Y') }}</p>
            <p><span class="font-medium">Check-out:</span> {{ $checkOut->translatedFormat('l, d F Y') }}</p>
            <p><span class="font-medium">Durasi:</span> {{ $reservation->number_of_nights ?? $days }} malam</p>
            <p><span class="font-medium">Jumlah Tamu:</span> {{ $reservation->total_guests }} orang</p>
        </div>
    </div>

    <hr class="my-4 border-gray-200">

    {{-- Rincian Biaya --}}
    @php
    $subtotal = $room->room_price * $days;
    $tax = $subtotal * 0.1;
    $grandTotal = $subtotal + $tax;
    @endphp
    <div class="space-y-2 text-gray-700">
        <h2 class="text-xl font-semibold text-violet-600">Rincian Biaya</h2>

        <div class="grid grid-cols-2 gap-y-1 text-sm">
            <p>Harga per malam</p>
            <p class="text-right">Rp {{ number_format($room->room_price, 0, ',', '.') }}</p>
            <p>Lama menginap</p>
            <p class="text-right">{{ $days }} malam</p>
            <p>Pajak (10%)</p>
            <p class="text-right">Rp {{ number_format($tax, 0, ',', '.') }}</p>
            <p class="font-semibold border-t border-gray-200 pt-1">Total Bayar</p>
            <p class="text-right font-semibold border-t border-gray-200 pt-1 text-violet-600">
                Rp {{ number_format($grandTotal, 0, ',', '.') }}
            </p>
        </div>
    </div>
</x-card.index>