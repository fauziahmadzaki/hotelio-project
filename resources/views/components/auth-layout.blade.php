<x-layout>
    <x-slot:title>{{ $title ?? "Auth" }}</x-slot:title>
    <div class="flex flex-col justify-center items-center min-h-svh gap-5 bg-neutral-100">
        <h1 class="text-xl text-violet-500 font-semibold">Hotelio</h1>
        <div class="p-5 shadow-md rounded-lg max-w-lg min-w-sm space-y-5 bg-white">
            <div id="cardHeader" class="text-center">
                <h1 class="text-2xl font-bold text-violet-500">
                    {{ $pageName ?? "Login" }}
                </h1>
                <p class="text-gray-600">{{ $description ?? "Silahkan Login untuk mengakses semua fitur" }}</p>
            </div>
            {{ $slot }}
        </div>
    </div>
</x-layout>