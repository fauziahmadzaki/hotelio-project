<x-admin.layout>
    <x-card.index class="max-w-md mx-auto">
        <h1 class="text-2xl font-bold mb-4">Tambah Fasilitas</h1>

        <form action="{{ route('admin.facilities.store') }}" method="POST" class="space-y-4">
            @csrf

            <x-input-group label="Nama Fasilitas" id="facility_name" placeholder="Contoh: Kolam Renang" type="text"
                error="{{ $errors->first('facility_name') }}" value="{{ old('facility_name') }}" />

            <x-button type="submit" class="w-full bg-violet-600 text-white hover:bg-violet-700">
                Simpan
            </x-button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('admin.facilities.index') }}" class="text-violet-600 text-sm hover:underline">
                Kembali ke daftar fasilitas
            </a>
        </div>
    </x-card.index>
</x-admin.layout>