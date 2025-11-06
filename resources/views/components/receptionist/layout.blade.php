<x-layout>
    <x-slot:title>{{ $title ?? 'Dashboard' }}</x-slot:title>

    {{-- ======== NAVBAR ======== --}}
    <nav
        class="fixed top-0 left-0 w-full bg-white border-b border-gray-200 shadow-sm z-40 flex justify-between items-center px-5 py-3">
        {{-- Brand --}}
        <h1 class="font-bold text-violet-600 text-lg">
            Hotelio {{ auth()->user()->role === 'admin' ? 'Admin' : 'Receptionist' }}
        </h1>

        {{-- Right Side --}}
        <div class="flex items-center gap-4">
            {{-- Profile Dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=7c3aed&color=fff"
                        alt="Avatar {{ Auth::user()->name }}" class="w-8 h-8 rounded-full shadow-sm">
                    <span class="hidden sm:block font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 hidden sm:block" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Dropdown Menu --}}
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-lg shadow-md py-2 z-50">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                    </form>
                </div>
            </div>

            {{-- Mobile Toggle --}}
            <button id="menu-toggle" class="lg:hidden p-2 rounded-md hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </nav>

    {{-- ======== SIDEBAR ======== --}}
    <aside id="sidebar"
        class="fixed top-[56px] left-0 z-30 bg-white w-64 h-[calc(100vh-56px)] py-5 border-r border-gray-200 shadow-sm flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-200">
        <div>
            <h1 class="text-lg text-center font-semibold">
                <span class="text-violet-500">
                    {{ auth()->user()->role === 'admin' ? 'Admin' : 'Receptionist' }}
                </span> Dashboard
            </h1>

            <ul class="w-full flex flex-col items-center mt-10 gap-5">
                {{-- Dashboard --}}
                <x-admin.navlink :active="request()->routeIs(auth()->user()->role.'.dashboard')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-layout-dashboard">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                    <a href="{{ route(auth()->user()->role.'.dashboard') }}">Dashboard</a>
                </x-admin.navlink>

                {{-- Kamar (Admin only) --}}
                @if (auth()->user()->role === 'admin')
                <x-admin.navlink :active="request()->is('admin/room*')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-bed-single">
                        <path d="M3 20v-8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8" />
                        <path d="M5 10V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4" />
                        <path d="M3 18h18" />
                    </svg>
                    <a href="{{ route('admin.rooms.index') }}">Kamar</a>
                </x-admin.navlink>
                @endif

                {{-- Reservasi (Both Roles) --}}
                <x-admin.navlink :active="request()->is(auth()->user()->role.'/reservation*')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-concierge-bell">
                        <path d="M3 20a1 1 0 0 1-1-1v-1a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1Z" />
                        <path d="M20 16a8 8 0 1 0-16 0" />
                        <path d="M12 4v4" />
                        <path d="M10 4h4" />
                    </svg>
                    <a href="{{ route(auth()->user()->role.'.reservations.index') }}">Reservasi</a>
                </x-admin.navlink>
            </ul>
        </div>

        <div class="p-5 text-center text-xs text-gray-400 border-t border-gray-100">
            &copy; {{ date('Y') }} <span class="text-violet-500 font-semibold">Hotelio</span>
        </div>
    </aside>

    {{-- ======== MAIN CONTENT ======== --}}
    <main class="lg:ml-64 mt-[56px] p-10 bg-gray-50 min-h-screen transition-all duration-200 space-y-5">
        {{ $slot ?? '' }}
    </main>

    {{-- Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</x-layout>