<x-layout>
    <x-slot:title>{{ $title ?? 'Dashboard' }}</x-slot:title>

    {{-- Navbar --}}
    <nav class="p-4 bg-white fixed w-full border-b top-0 border-gray-200 flex items-center justify-between z-50">
        {{-- Tombol toggle sidebar (mobile) --}}
        <button id="sidebarToggle" class="lg:hidden text-gray-600 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.75h16.5M3.75 12h16.5m-16.5 6.25h16.5" />
            </svg>
        </button>

        {{-- Judul --}}
        <h1 class="font-semibold text-lg text-violet-600">Dashboard Tamu</h1>

        {{-- Profil kanan --}}
        <div class="relative">
            <button id="profileButton" class="flex items-center gap-3 focus:outline-none">
                <span class="hidden sm:block text-gray-700 font-medium">{{ auth()->user()->name ?? 'Tamu' }}</span>
                <div
                    class="w-9 h-9 rounded-full bg-violet-100 text-violet-700 flex items-center justify-center font-semibold uppercase">
                    {{ substr(auth()->user()->name ?? 'T', 0, 1) }}
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-chevron-down text-gray-500">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </button>

            {{-- Dropdown menu --}}
            <div id="profileMenu"
                class="hidden absolute right-0 mt-2 w-44 bg-white rounded-md shadow-lg border border-gray-100 py-2 z-50">
                <a href="{{ route('guest.profile.show') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                <hr class="my-1 border-gray-200">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Overlay (untuk mobile) --}}
    <div id="overlay" class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden transition-opacity duration-300"></div>

    {{-- Sidebar --}}
    <aside id="sidebar"
        class="fixed top-0 left-0 z-40 bg-white w-64 h-svh py-5 border-r border-gray-200 shadow-sm flex flex-col transform transition-transform duration-300 -translate-x-full lg:translate-x-0">
        <div class="mb-6">
            <h1 class="text-lg text-center font-semibold text-violet-500">Dashboard</h1>
        </div>

        <ul class="flex flex-col items-center mt-8 gap-5">
            <x-guest.navlink :active="request()->routeIs('guest.dashboard')">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-layout-dashboard">
                    <rect width="7" height="9" x="3" y="3" rx="1" />
                    <rect width="7" height="5" x="14" y="3" rx="1" />
                    <rect width="7" height="9" x="14" y="12" rx="1" />
                    <rect width="7" height="5" x="3" y="16" rx="1" />
                </svg>
                <a href="{{ route('guest.dashboard') }}">Dashboard</a>
            </x-guest.navlink>

            <x-guest.navlink :active="request()->is('dashboard/reservation*')">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-concierge-bell">
                    <path d="M3 20a1 1 0 0 1-1-1v-1a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1Z" />
                    <path d="M20 16a8 8 0 1 0-16 0" />
                    <path d="M12 4v4" />
                    <path d="M10 4h4" />
                </svg>
                <a href="{{ route('guest.reservations.index') }}">Reservasi Saya</a>
            </x-guest.navlink>

            <x-guest.navlink :active="request()->is('dashboard/profile*')">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings">
                    <path
                        d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                <a href="{{ route('guest.profile.show') }}">Pengaturan</a>
            </x-guest.navlink>
        </ul>

        <div class="p-5 text-center text-xs text-gray-400 border-t border-gray-100">
            &copy; {{ date('Y') }} <span class="text-violet-500 font-semibold">Hotelio</span>
        </div>
    </aside>

    {{-- Konten utama --}}
    <main class="lg:ml-64 mt-[56px] p-6 bg-gray-50 min-h-screen transition-all duration-200 space-y-5">
        {{ $slot ?? '' }}
    </main>

    {{-- Script toggle sidebar & dropdown --}}
    <script>
        const toggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const profileBtn = document.getElementById('profileButton');
        const profileMenu = document.getElementById('profileMenu');

        // Sidebar toggle
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Dropdown menu toggle
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileMenu.classList.toggle('hidden');
        });

        // Tutup dropdown jika klik di luar
        window.addEventListener('click', (e) => {
            if (!profileBtn.contains(e.target)) {
                profileMenu.classList.add('hidden');
            }
        });
    </script>


    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        window.dashboardData = function() {
        return {
            stats: [
                { title: 'Kamar Dibooking', value: 0, color: 'border-violet-500', textColor: 'text-violet-600' },
                { title: 'Belum Check-in', value: 0, color: 'border-yellow-500', textColor: 'text-yellow-600' },
                { title: 'Dibatalkan', value: 0, color: 'border-red-500', textColor: 'text-red-600' },
            ],
            latest: null,

            async fetchData() {
                try {
                    const res = await fetch('{{ route('guest.dashboard.data') }}', {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (!res.ok) throw new Error('Gagal memuat data');

                    const data = await res.json();
                    this.stats[0].value = data.pending ?? 0;
                    this.stats[1].value = data.confirmed ?? 0;
                    this.stats[2].value = data.cancelled ?? 0;
                    this.latest = data.latest;
                } catch (error) {
                    console.error('❌ Error memuat data dashboard:', error);
                }
            }
        };
    };
    </script>

</x-layout>