@php
use Carbon\Carbon;
$user = auth()->user();

$checkIn = Carbon::parse($reservation->check_in_date);
$checkOut = Carbon::parse($reservation->check_out_date);
$days = max(1, $checkOut->diffInDays($checkIn)); // minimal 1 malam
@endphp

<x-guest.layout>
    <x-card.index class="max-w-xl mx-auto space-y-6 p-6">
        {{-- Gambar kamar --}}
        <div class="flex flex-col items-center space-y-3">
            <img src="{{ asset('/storage/' . $room->image) }}" alt="Foto kamar {{ $room->room_name }}"
                class="rounded-xl shadow-md w-full object-cover h-64 bg-gray-500 max-h-72">
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

        {{-- Garis pemisah --}}
        <hr class="my-4 border-gray-200">

        {{-- Informasi pemesanan --}}
        <div class="space-y-2 text-gray-700">
            <h2 class="text-xl font-semibold text-violet-600">Rincian Pemesanan</h2>

            <div class="grid grid-cols-2 gap-x-2 gap-y-2">
                <p><span class="font-medium text-sm">Nama Pemesan :</span> {{ $user->name }}</p>
                <p><span class="font-medium text-sm">Nomor HP :</span> {{ $reservation->person_phone_number }}</p>

                <p><span class="font-medium text-sm">Check-in :</span> {{ $checkIn->translatedFormat('l, d F Y') }}</p>
                <p><span class="font-medium text-sm">Check-out :</span> {{ $checkOut->translatedFormat('l, d F Y') }}
                </p>

                <p><span class="font-medium text-sm">Durasi :</span> {{ $reservation->days }} malam</p>
                <p><span class="font-medium text-sm">Jumlah Tamu :</span> {{ $reservation->total_guests }} orang</p>
            </div>
        </div>

        {{-- Garis pemisah --}}
        <hr class="my-4 border-gray-200">

        {{-- Rincian Biaya --}}
        <div class="space-y-2 text-gray-700">
            <h2 class="text-xl font-semibold text-violet-600">Rincian Biaya</h2>
            <div class="grid grid-cols-2 gap-y-1">
                <p>Harga per malam</p>
                <p class="text-right">Rp {{ number_format($room->room_price, 0, ',', '.') }}</p>

                <p>Lama menginap</p>
                <p class="text-right">{{ $reservation->days }} malam</p>

                <p>Pajak (10%)</p>
                <p class="text-right">Rp {{ number_format($reservation->tax, 0, ',', '.') }}</p>

                <p class="font-semibold border-t border-gray-200 pt-1">Total Bayar</p>
                <p class="text-right font-semibold border-t border-gray-200 pt-1 text-violet-600">
                    Rp {{ number_format($reservation->grand_total, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- Progress Steps --}}
        <div>
            <div
                class="relative mt-6 after:absolute after:inset-x-0 after:top-1/2 after:block after:h-0.5 after:-translate-y-1/2 after:rounded-lg after:bg-gray-200">
                <ol class="relative z-10 flex justify-between text-sm font-medium text-gray-600">
                    <li class="flex items-center gap-2 bg-white p-2">
                        <span class="size-6 rounded-full bg-gray-100 text-center text-[10px]/6 font-bold">1</span>
                        <span class="hidden sm:block">Detail Pemesanan</span>
                    </li>
                    <li class="flex items-center gap-2 bg-white p-2">
                        <span
                            class="size-6 rounded-full bg-violet-500 text-center text-[10px]/6 font-bold text-white">2</span>
                        <span class="hidden sm:block">Konfirmasi Pembayaran</span>
                    </li>
                    <li class="flex items-center gap-2 bg-white p-2">
                        <span class="size-6 rounded-full bg-gray-100 text-center text-[10px]/6 font-bold">3</span>
                        <span class="hidden sm:block">Bukti Pembayaran</span>
                    </li>
                </ol>
            </div>
        </div>

        {{-- Form Lanjut --}}
        <form action="{{ route('guest.reservations.store2') }}" method="POST" class="space-y-4">
            @csrf
            @method('POST')

            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="room_id" value="{{ $room->id }}">
            <input type="hidden" name="person_name" value="{{ $reservation->person_name }}">
            <input type="hidden" name="person_phone_number" value="{{ $reservation->person_phone_number }}">
            <input type="hidden" name="check_in_date" value="{{ $reservation->check_in_date }}">
            <input type="hidden" name="check_out_date" value="{{ $reservation->check_out_date }}">
            <input type="hidden" name="number_of_nights" value="{{ $reservation->days }}">
            <input type="hidden" name="total_guests" value="{{ $reservation->total_guests }}">
            <input type="hidden" name="total_price" value="{{ $reservation->grand_total }}">


            <x-button id="openModal" class="w-full bg-violet-600 hover:bg-violet-700 text-white py-2 rounded-lg">
                Lanjut ke Pembayaran
            </x-button>




            <div id="overlay" class="hidden fixed inset-0 z-50 grid place-content-center bg-black/50 p-4" role="dialog"
                aria-modal="true" aria-labelledby="modalTitle">
                <div id="modal" class="hidden w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
                    <div class="flex items-start justify-between">
                        <h2 id="modalTitle" class="text-xl font-bold text-gray-900 sm:text-2xl">Konfirmasi Pembayaran
                        </h2> <button type="button"
                            class="-me-4 -mt-4 rounded-full p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-600 focus:outline-none"
                            aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg> </button>
                    </div>
                    <div class="mt-4">
                        <p class="text-pretty text-gray-700"> Dengan ini anda menyetujui semua ketentuan yang ada, dan
                            siap membayar sesuai jumlah yang telah ditentukan. </p>
                    </div>
                    <footer class="mt-6 flex justify-end gap-2"> <button type="button"
                            class="rounded bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200">
                            Cancel </button> <button type="submit"
                            class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">
                            Konfirmasi </button> </footer>
                </div>
            </div>
        </form>
    </x-card.index>
</x-guest.layout>

<script>
    const openModal = document.getElementById('openModal');
    const modal = document.getElementById('modal')
    const overlay = document.getElementById('overlay')
    
    openModal.addEventListener('click', (e) => {
        e.preventDefault()
        overlay.classList.toggle('hidden')
        modal.classList.toggle('hidden')

    })

</script>