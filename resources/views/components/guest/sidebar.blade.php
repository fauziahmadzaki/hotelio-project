<nav class="p-5 bg-white w-full fixed border-b border-gray-200 ">test</nav>
<aside class="fixed  z-50 bg-white w-64 h-svh py-5 border-r border-gray-200 shadow-sm flex flex-col">
    <div>
        <h1 class="text-lg text-center font-semibold text-violet-500">Dashboard</h1>
    </div>
    <ul class="w-full flex flex-col justify-center items-center mt-10 gap-5 ">
        <x-guest.navlink :active="request()->routeIs('guest.dashboard')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                <rect width="7" height="9" x="3" y="3" rx="1" />
                <rect width="7" height="5" x="14" y="3" rx="1" />
                <rect width="7" height="9" x="14" y="12" rx="1" />
                <rect width="7" height="5" x="3" y="16" rx="1" />
            </svg> <a href="{{ route('guest.dashboard') }}">Dashboard</a>
        </x-guest.navlink>
        <x-guest.navlink :active="request()->is('dashboard/reservasi*')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-concierge-bell-icon lucide-concierge-bell">
                <path d="M3 20a1 1 0 0 1-1-1v-1a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1Z" />
                <path d="M20 16a8 8 0 1 0-16 0" />
                <path d="M12 4v4" />
                <path d="M10 4h4" />
            </svg>
            <a href="{{ route('guest.dashboard')}}">Reservasi Saya</a>
        </x-guest.navlink>
        <x-guest.navlink :active="request()->is('dashboard/reservasi*')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-settings-icon lucide-settings">
                <path
                    d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
                <circle cx="12" cy="12" r="3" />
            </svg>
            <a href="{{ route('guest.dashboard')}}">Pengaturan</a>
        </x-guest.navlink>


    </ul>

</aside>