<x-layout>
    <x-slot:title>{{ $title ?? "Dashboard" }}</x-slot:title>
    <x-admin.sidebar></x-admin.sidebar>
    <main class="p-20 pl-80 py-20 bg-neutral-100 min-h-svh space-y-5">

        {{ $slot }}
    </main>

</x-layout>