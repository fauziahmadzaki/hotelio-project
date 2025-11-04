<x-admin.layout>
    <x-button><a href="{{ route('admin.rooms.create') }}" class="text-white">Tambah Kamar</a></x-button>

    <div class="flex flex-wrap gap-4 justify-center items-center">
        @foreach ($rooms as $room)
        <x-card-room img="{{ $room->image }}" title="{{ $room->room_name }}" price="{{ $room->room_price }}"
            id="{{ $room->id }}"></x-card-room>
        @endforeach
    </div>
</x-admin.layout>