<x-layout>
    <x-slot:title>{{ $title ?? "Dashboard" }}</x-slot:title>

    {{-- 🔹 Navbar --}}
    <nav
        class="fixed top-0 left-0 w-full bg-white border-b border-gray-200 shadow-sm z-40 flex justify-between items-center px-5 py-3">
        <h1 class="font-bold text-violet-600 text-lg">
            Hotelio {{ auth()->user()->role === "admin" ? "Admin" : "Receptionist" }}
        </h1>

        <div class="flex items-center gap-4">
            {{-- Profil --}}
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

                {{-- Dropdown --}}
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

            {{-- Toggle Mobile --}}
            <button id="menu-toggle" class="lg:hidden p-2 rounded-md hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </nav>

    {{-- 🔹 Sidebar --}}
    <aside id="sidebar"
        class="fixed top-[56px] left-0 z-30 bg-white w-64 h-[calc(100vh-56px)] border-r border-gray-200 shadow-sm flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-200">
        <div class="flex h-screen flex-col justify-between border-e border-gray-100 bg-white">
            <div class="px-4 py-6">
                <ul class="mt-6 space-y-1">

                    <li>
                        <x-admin.navlink href="{{ route('admin.dashboard') }}"
                            :active="request()->routeIs('admin.dashboard')">Dashboard</x-admin.navlink>
                    </li>
                    <li>
                        <details class="group [&_summary::-webkit-details-marker]:hidden">
                            <summary
                                class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                <span class="text-sm font-medium">Kamar</span>
                                <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </summary>

                            <ul class="mt-2 space-y-1 px-4">
                                <li><a href="{{ route('admin.rooms.index') }}"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                        Daftar Kamar</a></li>
                                <li><a href="{{ route('admin.room-types.index') }}"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                        Tipe Kamar</a></li>
                                <li><a href="{{ route('admin.facilities.index') }}"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                        Fasilitas</a></li>
                            </ul>
                        </details>
                    </li>
                    <li>
                        <details class="group [&_summary::-webkit-details-marker]:hidden">
                            <summary
                                class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                <span class="text-sm font-medium">Reservasi</span>
                                <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </summary>

                            <ul class="mt-2 space-y-1 px-4">
                                <li><a href="{{ route('admin.reservations.index') }}"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                        Reservasi Aktif</a></li>
                                <li><a href="{{ route('admin.reservations.completed') }}"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                        Reservasi Selesai</a></li>
                                <li><a href="{{ route('admin.reservations.cancelled') }}"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                        Reservasi Dibatalkan</a></li>
                            </ul>
                        </details>
                    </li>

                    <li>
                        <a href="{{ route('admin.incomes.index') }}"
                            class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                            Keuangan
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.users') }}"
                            class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                            Daftar Pengguna
                        </a>
                    </li>

                    {{-- Akun --}}
                    <li>
                        <details class="group [&_summary::-webkit-details-marker]:hidden">
                            <summary
                                class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                <span class="text-sm font-medium">Akun</span>
                                <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </summary>

                            <ul class="mt-2 space-y-1 px-4">
                                <li>
                                    <a href="{{ route('reset-password') }}"
                                        class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                        Reset Password
                                    </a>
                                </li>

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full rounded-lg px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 text-left">
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </details>
                    </li>
                </ul>
            </div>

            {{-- Footer --}}
            <div class="border-t border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=7c3aed&color=fff"
                        alt="User avatar" class="size-9 rounded-full object-cover">
                    <div>
                        <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <main class="lg:ml-64 mt-[56px] p-10 bg-gray-50 min-h-screen transition-all duration-200 space-y-5">
        {{ $slot ?? '' }}
    </main>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</x-layout>