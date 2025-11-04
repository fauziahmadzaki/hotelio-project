<nav class="p-5 bg-white w-full fixed border-b border-gray-200 ">test</nav>
<aside class="fixed  z-50 bg-white w-64 h-svh py-5 border-r border-gray-200 shadow-sm flex flex-col">
    <div>
        <h1 class="text-lg text-center font-semibold"><span class="text-violet-500">Admin</span> Dashboard</h1>
    </div>
    <ul class="w-full flex flex-col justify-center items-center mt-10 gap-5 ">
        <x-admin.navlink :active="request()->routeIs('admin.')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                <rect width="7" height="9" x="3" y="3" rx="1" />
                <rect width="7" height="5" x="14" y="3" rx="1" />
                <rect width="7" height="9" x="14" y="12" rx="1" />
                <rect width="7" height="5" x="3" y="16" rx="1" />
            </svg> <a href="{{ route('admin.') }}">Dashboard</a>
        </x-admin.navlink>
        <x-admin.navlink :active="request()->is('admin/rooms*')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-bed-single-icon lucide-bed-single">
                <path d="M3 20v-8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8" />
                <path d="M5 10V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v4" />
                <path d="M3 18h18" />
            </svg>
            <a href="{{ route('admin.rooms.index') }}">Kamar</a>
        </x-admin.navlink>
        <x-admin.navlink>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-concierge-bell-icon lucide-concierge-bell">
                <path d="M3 20a1 1 0 0 1-1-1v-1a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v1a1 1 0 0 1-1 1Z" />
                <path d="M20 16a8 8 0 1 0-16 0" />
                <path d="M12 4v4" />
                <path d="M10 4h4" />
            </svg>
            <a href="">Reservasi</a>
        </x-admin.navlink>
        <x-admin.navlink>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-user-icon lucide-user">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
            </svg>
            <a href="">Pegawai</a>
        </x-admin.navlink>


    </ul>
    <div class="w-full  absolute bottom-20">

        <x-logout-button class="w-8/10 mx-auto text-white"></x-logout-button>
    </div>
</aside>