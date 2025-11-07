<header class="w-full fixed top-0 left-0 z-50 bg-white/90 backdrop-blur border-b border-gray-200">
    <nav class="max-w-6xl mx-auto flex items-center justify-between px-6 py-3 lg:px-10 lg:py-4">
        {{-- Logo --}}
        <div class="flex items-center justify-between w-full lg:w-fit">
            <a href="/" class="flex items-center gap-2">
                {{-- SVG LOGO --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="text-violet-600">
                    <path d="M3 9l9-6 9 6v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                <h1 class="text-xl font-bold text-violet-600">Hotelio</h1>
            </a>

            {{-- Tombol Menu Mobile --}}
            <button id="menu-toggle" class="lg:hidden">
                <svg id="menu-open" xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="text-gray-700">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="menu-close" xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="hidden text-gray-700">
                    <path d="M18 6 6 18M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Menu Navigasi --}}
        <ul id="nav-menu"
            class="absolute top-full left-0 w-full bg-white lg:bg-transparent shadow-md border-b border-gray-200 overflow-hidden max-h-0 transition-all duration-500 ease-in-out lg:relative lg:max-h-fit lg:shadow-none lg:border-none lg:flex lg:items-center lg:gap-8 lg:w-auto">
            <div class="flex flex-col items-center lg:flex-row lg:gap-8 p-5 lg:p-0 text-gray-700">
                <li><a href="/" class="hover:text-violet-600 transition">Home</a></li>
                <li><a href="/room" class="hover:text-violet-600 transition">Rooms</a></li>
                <li><a href="#about" class="hover:text-violet-600 transition">About</a></li>
                <li><a href="#contact" class="hover:text-violet-600 transition">Contact</a></li>

                {{-- Tombol Mobile --}}
                <li class="mt-5 lg:hidden w-full space-y-2">
                    @guest
                    <x-button class="w-full bg-violet-600 text-white"><a href="{{ route('login') }}">Login</a>
                    </x-button>
                    <x-button class="w-full border border-violet-600 text-violet-600 bg-white"><a
                            href="{{ route('register') }}">Register</a></x-button>
                    @endguest
                    @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <x-button class="w-full bg-violet-600 text-white">Logout</x-button>
                    </form>
                    @endauth
                </li>
            </div>
        </ul>

        {{-- Tombol Desktop --}}
        <div class="hidden lg:flex gap-3">
            @guest
            <x-button class="bg-violet-600 text-white"><a href="{{ route('login') }}">Login</a></x-button>
            <x-button class="border border-violet-600 text-violet-600 bg-white"><a
                    href="{{ route('register') }}">Register</a></x-button>
            @endguest
            @auth
            <x-dashboard-button></x-dashboard-button>
            @endauth
        </div>
    </nav>
</header>

{{-- Script --}}
<script>
    const toggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('nav-menu');
    const openIcon = document.getElementById('menu-open');
    const closeIcon = document.getElementById('menu-close');

    toggle.addEventListener('click', () => {
        const isOpen = menu.classList.contains('max-h-96');
        menu.classList.toggle('max-h-0', isOpen);
        menu.classList.toggle('max-h-96', !isOpen);
        openIcon.classList.toggle('hidden', !isOpen);
        closeIcon.classList.toggle('hidden', isOpen);
    });
</script>