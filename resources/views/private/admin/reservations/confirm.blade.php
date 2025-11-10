<x-admin.layout>
    <x-card.index class="max-w-2xl mx-auto p-6 space-y-6">

        {{-- PERBAIKAN: Tentukan route secara dinamis --}}
        @php
        $createRoute = Auth::user()->role === 'receptionist'
        ? 'receptionist.reservations.create'
        : 'admin.reservations.create';

        // Ini adalah route BARU yang akan kita buat untuk menyimpan
        $saveRoute = Auth::user()->role === 'receptionist'
        ? 'receptionist.reservations.save'
        : 'admin.reservations.save';
        @endphp

        {{-- 🧾 Judul --}}
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Konfirmasi Reservasi</h1>
            <span class="text-xs px-3 py-1 border rounded-full font-semibold 
                {{-- PERBAIKAN: Gunakan objek $reservation --}}
                @if (($reservation->status ?? 'pending') === 'pending') bg-yellow-100 text-yellow-700 border-yellow-300
                @elseif (($reservation->status ?? 'pending') === 'checked_in') bg-blue-100 text-blue-700 border-blue-300
                @else bg-gray-100 text-gray-600 border-gray-300 @endif">
                {{-- PERBAIKAN: Gunakan objek $reservation --}}
                {{ ucfirst($reservation->status ?? 'pending') }}
            </span>
        </div>

        {{-- 🏠 Gambar kamar --}}
        <div class="relative">
            <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://placehold.co/600x400/violet/white?text=Kamar' }}"
                alt="Gambar {{ $room->room_name }}" class="w-full h-64 object-cover rounded-xl shadow"
                onerror="this.src='https://placehold.co/600x400/violet/white?text=Kamar'">
            <div class="absolute bottom-2 left-2 bg-violet-600 text-white text-sm font-semibold px-3 py-1 rounded-md">
                {{ $room->room_name }}
            </div>
        </div>


        {{-- ℹ️ Detail Kamar --}}
        <div class="space-y-2 text-gray-700">
            <h2 class="text-lg font-semibold text-violet-600">Informasi Kamar</h2>
            <p><span class="font-medium">Kode:</span> {{ $room->room_code }}</p>
            <p><span class="font-medium">Tipe:</span> {{ $room->roomType->room_type_name ?? '-' }}</p>
            <p><span class="font-medium">Kapasitas:</span> {{ $room->room_capacity }} orang</p>
            <p><span class="font-medium">Harga per malam:</span> Rp {{ number_format($room->room_price, 0, ',', '.') }}
            </p>
        </div>

        {{-- 👤 Informasi Pemesan --}}
        <div class="space-y-2 text-gray-700">
            <h2 class="text-lg font-semibold text-violet-600">Informasi Pemesan</h2>
            {{-- PERBAIKAN: Gunakan objek $reservation untuk semua data --}}
            <p><span class="font-medium">Nama:</span> {{ $reservation->person_name }}</p>
            <p><span class="font-medium">Nomor HP:</span> {{ $reservation->person_phone_number }}</p>
            <p><span class="font-medium">Check-in:</span>
                {{ \Carbon\Carbon::parse($reservation->check_in_date)->translatedFormat('d F Y') }}
            </p>
            <p><span class="font-medium">Check-out:</span>
                {{ \Carbon\Carbon::parse($reservation->check_out_date)->translatedFormat('d F Y') }}
            </p>
            <p><span class="font-medium">Jumlah Tamu:</span> {{ $reservation->total_guests }}</p>
            <p><span class="font-medium">Metode Pembayaran:</span> {{ ucfirst($reservation->payment_method) }}</p>
        </div>

        {{-- 💰 Rincian Biaya --}}
        <div class="space-y-2 text-gray-700">
            <h2 class="text-lg font-semibold text-violet-600">Rincian Biaya</h2>
            <div class="grid grid-cols-2 text-sm">
                <p>Harga per malam</p>
                <p class="text-right">Rp {{ number_format($reservation->room_price, 0, ',', '.') }}</p>
                <p>Durasi</p>
                <p class="text-right">{{ $reservation->days }} malam</p>
                <p class="font-semibold border-t border-gray-200 pt-1">Subtotal</p>
                <p class="text-right font-semibold border-t border-gray-200 pt-1">
                    Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                </p>

                {{-- PERBAIKAN: Tambahkan Pajak dan Grand Total --}}
                <p>Pajak (10%)</p>
                <p class="text-right">Rp {{ number_format($reservation->tax, 0, ',', '.') }}</p>
                <p class="font-bold text-base border-t border-gray-300 pt-1">Grand Total</p>
                <p class="text-right font-bold text-base border-t border-gray-300 pt-1 text-violet-600">
                    Rp {{ number_format($reservation->grand_total, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- 🔘 Tombol Aksi --}}
        <div class="flex justify-between mt-6">
            {{-- Tombol kembali ke form --}}
            {{-- PERBAIKAN: Gunakan route dinamis --}}
            <a href="{{ route($createRoute) }}"
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium text-gray-700">
                Kembali
            </a>

            {{-- Form simpan final --}}
            {{-- PERBAIKAN: Arahkan ke route $saveRoute BARU --}}
            <form action="{{ route($saveRoute) }}" method="POST">
                @csrf
                {{--
                    PERBAIKAN: Hapus semua hidden input.
                    Kita tidak perlu mengirim data lagi. Data yang aman ada di
                    dalam Sesi (Session) dan akan kita ambil di controller.
                    Ini jauh lebih aman.
                --}}
                <x-button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white">
                    Konfirmasi & Simpan
                </x-button>
            </form>
        </div>
    </x-card.index>
</x-admin.layout>