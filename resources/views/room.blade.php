<x-layout>
    <x-slot:title>Hotelio App</x-slot:title>
    <x-navbar />

    <section id="rooms" class="max-w-6xl mx-auto py-30 px-5 space-y-10">
        <h2 class="text-3xl font-bold text-center text-gray-800">Kamar Tersedia</h2>

        {{-- 🔹 Filter --}}
        <form method="GET" class="flex justify-end items-center gap-2">
            <label for="sort" class="text-sm text-gray-600">Urutkan:</label>
            <select name="sort" id="sort" onchange="this.form.submit()"
                class="border border-gray-300 rounded-md text-sm px-2 py-1">
                <option value="termurah" {{ request('sort')=='termurah' ? 'selected' : '' }}>Harga Termurah</option>
                <option value="termahal" {{ request('sort')=='termahal' ? 'selected' : '' }}>Harga Termahal</option>
                <option value="terbaru" {{ request('sort')=='terbaru' ? 'selected' : '' }}>Kamar Terbaru</option>
                <option value="terlama" {{ request('sort')=='terlama' ? 'selected' : '' }}>Kamar Terlama</option>
            </select>
        </form>

        {{-- 🔹 Daftar kamar --}}
        @if ($rooms->isEmpty())
        <x-card class="text-center py-10 text-gray-500">
            <p>Belum ada kamar tersedia saat ini.</p>
        </x-card>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 place-items-center">
            @foreach ($rooms as $room)
            <x-card-room img="{{ $room->image }}" title="{{ $room->room_name }}" price="{{ $room->room_price }}"
                id="{{ $room->id }}" status="{{ $room->room_status }}" />
            @endforeach
        </div>
        @endif
    </section>
</x-layout>