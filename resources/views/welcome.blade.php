<x-layout>
    <x-slot:title>Hotelio App</x-slot:title>

    {{-- Navbar --}}
    <x-navbar />

    {{-- Hero Section --}}
    <section id="home" class="relative min-h-screen bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ asset('images/hero.jpg') }}')">
        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative z-10 flex flex-col items-center justify-center text-center h-full px-6 pt-60">
            <p class="text-white text-lg md:text-xl font-medium">
                Hotel nyaman, bersih, dan fasilitas terbaik
            </p>

            <h1 class="text-5xl md:text-7xl font-extrabold text-white mt-3 drop-shadow-lg">
                Hotelio
            </h1>

            <p class="text-sm md:text-base font-light text-gray-100 mt-4 max-w-md leading-relaxed">
                Nikmati pengalaman menginap terbaik dengan pelayanan profesional dan fasilitas modern.
            </p>

            <x-button class="text-white bg-violet-500 mt-6 hover:bg-violet-600 transition">
                <a href="#about">Mulai Sekarang</a>
            </x-button>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" class="max-w-5xl mx-auto py-20 px-5 space-y-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800">Tentang Kami</h2>
        <p class="text-gray-600 leading-relaxed max-w-3xl mx-auto">
            <span class="font-semibold text-violet-600">Hotelio</span> adalah hotel modern yang mengutamakan kenyamanan
            dan kepuasan tamu.
            Dengan pelayanan ramah, kamar yang bersih, dan lokasi strategis di pusat kota, kami siap memberikan
            pengalaman menginap terbaik.
        </p>
        <div class="flex justify-center">
            <img src="{{ asset('images/hero.jpg') }}" alt="Tentang Hotel"
                class="rounded-xl shadow-lg max-w-md w-full object-cover">
        </div>
    </section>

    {{-- Facilities Section --}}
    <section id="facilities" class="bg-violet-50 py-20 px-6">
        <div class="max-w-6xl mx-auto text-center space-y-10">
            <h2 class="text-3xl font-bold text-gray-800">Fasilitas Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Kami menyediakan berbagai fasilitas terbaik untuk menunjang kenyamanan Anda selama menginap di Hotelio.
            </p>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-8 text-gray-700">
                {{-- Wi-Fi Gratis --}}
                <div
                    class="flex flex-col items-center bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-violet-600 mb-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 20h.01" />
                        <path d="M2 8.82a15 15 0 0 1 20 0" />
                        <path d="M5 12.55a10 10 0 0 1 14 0" />
                        <path d="M8.5 16.15a5 5 0 0 1 7 0" />
                    </svg>
                    <h3 class="font-semibold text-gray-800">Wi-Fi Gratis</h3>
                    <p class="text-sm text-gray-500 mt-1 text-center">Akses internet cepat di seluruh area hotel</p>
                </div>

                {{-- Sarapan Pagi --}}
                <div
                    class="flex flex-col items-center bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-violet-600 mb-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M18 8a6 6 0 0 1-12 0V4h12Z" />
                        <path d="M12 18v3" />
                        <path d="M8 21h8" />
                    </svg>
                    <h3 class="font-semibold text-gray-800">Sarapan Pagi</h3>
                    <p class="text-sm text-gray-500 mt-1 text-center">Nikmati sarapan lezat setiap pagi</p>
                </div>

                {{-- Parkir Luas --}}
                <div
                    class="flex flex-col items-center bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-violet-600 mb-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="10" rx="2" />
                        <path d="M7 11V7a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v4" />
                    </svg>
                    <h3 class="font-semibold text-gray-800">Parkir Luas</h3>
                    <p class="text-sm text-gray-500 mt-1 text-center">Tempat parkir aman dan luas untuk tamu</p>
                </div>

                {{-- TV & AC --}}
                <div
                    class="flex flex-col items-center bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-violet-600 mb-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="4" width="20" height="14" rx="2" ry="2" />
                        <line x1="8" y1="20" x2="16" y2="20" />
                        <line x1="12" y1="18" x2="12" y2="22" />
                    </svg>
                    <h3 class="font-semibold text-gray-800">TV & AC</h3>
                    <p class="text-sm text-gray-500 mt-1 text-center">Kenyamanan maksimal di setiap kamar</p>
                </div>
            </div>



        </div>
    </section>

    {{-- Available Rooms --}}
    <section id=" rooms" class="max-w-6xl mx-auto py-20 px-5 space-y-10">
        <h2 class="text-3xl font-bold text-center text-gray-800">
            Kamar Tersedia
        </h2>

        @if ($rooms->isEmpty())
        <x-card class="text-center py-10 text-gray-500">
            <p>Belum ada kamar tersedia saat ini.</p>
        </x-card>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 place-items-center">
            @foreach ($rooms as $room)
            <x-card-room img="{{ $room->image }}" title="{{ $room->room_name }}" price="{{ $room->room_price }}"
                id="{{ $room->id }}" status="{{ $room->room_status }}" />
            @endforeach
        </div>
        @endif
    </section>

    {{-- Contact Section --}}
    <section id="contact" class="bg-gray-100 py-20 px-6">
        <div class="max-w-4xl mx-auto text-center space-y-6">
            <h2 class="text-3xl font-bold text-gray-800">Hubungi Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Butuh bantuan atau ingin melakukan reservasi? Silakan hubungi kami melalui kontak di bawah ini.
            </p>

            <div class="flex flex-col md:flex-row justify-center gap-8 mt-8">
                <div class="bg-white p-6 rounded-lg shadow-md w-full md:w-1/3">
                    <h3 class="font-semibold text-violet-600 mb-2">Alamat</h3>
                    <p class="text-gray-600">Jl. Veteran No. 123, Malang, Indonesia</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md w-full md:w-1/3">
                    <h3 class="font-semibold text-violet-600 mb-2">Telepon</h3>
                    <p class="text-gray-600">+62 812-3456-7890</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md w-full md:w-1/3">
                    <h3 class="font-semibold text-violet-600 mb-2">Email</h3>
                    <p class="text-gray-600">info@hotelio.com</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-violet-600 py-6 text-center text-sm text-white">
        © {{ date('Y') }} Hotelio. Semua Hak Dilindungi.
    </footer>
</x-layout>