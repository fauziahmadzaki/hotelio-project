<header class="w-full fixed lg:top-5">
    <nav
        class="max-w-5xl lg:p-5  lg:px-20 bg-white mx-auto lg:rounded-lg shadow-md lg:border border-gray-200 lg:flex justify-between items-center">
        <div class="p-5 lg:p-0 flex w-full lg:w-fit justify-between border-b border-gray-200 lg:border-none">
            <h1 class="text-xl font-bold text-violet-500 ">Hotelio</h1>
            <button id="openBtn" class="lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-menu-icon lucide-menu">
                    <path d="M4 5h16" />
                    <path d="M4 12h16" />
                    <path d="M4 19h16" />
                </svg>
            </button>
            <button id="closeBtn" class="hidden lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-x-icon lucide-x">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>
        <ul id="menu" class="max-h-0 lg:max-h-fit  text-center overflow-hidden  transition-all  duration-700">
            <div class="space-y-5 lg:space-y-0 lg:flex items-center gap-5 p-5 lg:p-0">
                <li>
                    <a href="/" class="hover:text-violet-500">Home</a>
                </li>
                <li>
                    <a href="/rooms" class="hover:text-violet-500">Rooms</a>
                </li>
                <li>
                    <a href="/about" class="hover:text-violet-500">About</a>
                </li>
                <li>
                    <a href="/contact" class="hover:text-violet-500">Contact</a>
                </li>
                <li class="space-y-2 lg:hidden">
                    @guest
                    <x-button class="text-white w-full"><a href="{{ route('login') }}">Login</a></x-button>
                    <x-button class=" text-violet-500 bg-white border border-violet-500 w-full"><a
                            href="{{ route('login') }}">Register</a></x-button>
                    @endguest
                    @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <x-button class="text-white w-full">Logout</x-button>
                    </form>
                    @endauth
                </li>
            </div>
        </ul>
        <div class="hidden lg:flex gap-2">
            @guest
            <x-button class="text-white"><a href="{{ route('login') }}">Login</a></x-button>
            @endguest
        </div>
    </nav>
</header>

<script>
    const openBtn = document.getElementById('openBtn');
    const closeBtn = document.getElementById('closeBtn');
    const menu = document.getElementById('menu');
    openBtn.addEventListener('click', () => {
        menu.classList.remove('max-h-0');
        menu.classList.add('max-h-96');
        openBtn.classList.add('hidden');
        closeBtn.classList.remove('hidden');
    })
    closeBtn.addEventListener('click', () => {
        menu.classList.add('max-h-0');
        menu.classList.remove('max-h-96');
        openBtn.classList.toggle('hidden');
        closeBtn.classList.toggle('hidden');
    })
</script>