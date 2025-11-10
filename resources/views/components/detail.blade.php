@php
use Carbon\Carbon;

$user = auth()->user();
$checkIn = Carbon::parse($reservation->check_in_date);
$checkOut = Carbon::parse($reservation->check_out_date);
$room = $reservation->room;
$days = max(1, $checkOut->diffInDays($checkIn));
$status = strtolower($reservation->status);
@endphp

<x-guest.layout>
    <x-card.index class="max-w-2xl mx-auto p-6 sm:p-8 space-y-6">
        {{-- Judul Halaman --}}
        <div class="text-center mb-4">
            <h1 class="text-2xl font-bold text-violet-600">Detail Reservasi</h1>
            <p class="text-gray-500 text-sm">Informasi lengkap reservasi Anda</p>
        </div>

        {{-- Gambar kamar --}}
        <div class="flex flex-col items-center space-y-3">
            <img src="{{ asset('storage/' . $room->image) }}" alt="Foto kamar {{ $room->room_name }}"
                class="rounded-xl shadow-md w-full object-cover max-h-72">

            {{-- Status --}}
            <span class="px-4 py-1.5 rounded-full text-sm font-semibold 
                @if ($status === 'pending') bg-yellow-100 text-yellow-700
                @elseif ($status === 'confirmed') bg-green-100 text-green-700
                @elseif ($status === 'cancelled') bg-red-100 text-red-700
                @elseif ($status === 'checkin') bg-blue-100 text-blue-700
                @elseif ($status === 'completed') bg-violet-100 text-violet-700
                @else bg-gray-100 text-gray-700 @endif">
                {{ ucfirst($status) }}
            </span>
        </div>

        {{-- Informasi kamar --}}
        <div class="space-y-3 text-gray-700">
            <h2 class="text-xl font-semibold text-violet-600 border-b border-gray-200 pb-2">Detail Kamar</h2>
            <p><span class="font-medium">Nama Kamar:</span> {{ $room->room_name }}</p>
            <p><span class="font-medium">Deskripsi:</span> {{ $room->room_description }}</p>

            <div>
                <p class="font-medium mb-1">Fasilitas:</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-4 text-sm font-medium">
                    @forelse ($room->facilities as $facility)
                    <p>• {{ $facility->facility_name }}</p>
                    @empty
                    <p class="text-gray-500 italic">Tidak ada fasilitas terdaftar</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Informasi pemesanan --}}
        <div class="space-y-3 text-gray-700">
            <h2 class="text-xl font-semibold text-violet-600 border-b border-gray-200 pb-2">Rincian Pemesanan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-2 gap-y-2 text-sm">
                <p><span class="font-medium">Nama Pemesan:</span> {{ $reservation->person_name }}</p>
                <p><span class="font-medium">Nomor HP:</span> {{ $reservation->person_phone_number }}</p>
                <p><span class="font-medium">Check-in:</span> {{ $checkIn->translatedFormat('l, d F Y') }}</p>
                <p><span class="font-medium">Check-out:</span> {{ $checkOut->translatedFormat('l, d F Y') }}</p>
                <p><span class="font-medium">Durasi:</span> {{ $days }} malam</p>
                <p><span class="font-medium">Jumlah Tamu:</span> {{ $reservation->total_guests }} orang</p>

                @if (!empty($reservation->notes))
                <p class="sm:col-span-2">
                    <span class="font-medium">Catatan Tambahan:</span> {{ $reservation->notes }}
                </p>
                @endif
            </div>
        </div>

        {{-- Rincian biaya --}}
        @php
        $subtotal = $room->room_price * $days;
        $tax = $subtotal * 0.1;
        $grandTotal = $subtotal + $tax;
        @endphp

        <div class="space-y-2 text-gray-700">
            <h2 class="text-xl font-semibold text-violet-600 border-b border-gray-200 pb-2">Rincian Biaya</h2>

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

                <p class="font-medium border-t border-gray-200 pt-2">Metode Pembayaran</p>
                <p class="text-right border-t border-gray-200 pt-2 capitalize">
                    {{ $reservation->payment_method ?? '-' }}
                </p>
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="pt-4">
            <a href="{{ route('guest.reservations.index') }}"
                class="block text-center font-semibold w-full bg-violet-600 hover:bg-violet-700 text-white py-2 rounded-lg transition-all duration-200">
                Kembali ke Daftar Reservasi
            </a>
        </div>
    </x-card.index>
</x-guest.layout>