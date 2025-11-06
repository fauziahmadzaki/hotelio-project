<x-guest.layout>
    <x-card class="max-w-lg mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4 text-gray-800">Profil Saya</h1>

        @if (session('success'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('guest.profile.update') }}" class="space-y-4">
            @csrf

            <x-input-group label="Nama" id="name" type="text" value="{{ old('name', $user->name ?? '-') }}" disabled />

            <x-input-group label="Nomor Telepon" id="phone_number" name="phone_number" type="text"
                value="{{ old('phone_number', $profile->phone_number ?? '') }}" />

            <x-input-group label="Alamat" id="address" name="address" type="text"
                value="{{ old('address', $profile->address ?? '') }}" />

            <div>
                <x-label>Jenis Kelamin</x-label>
                <select name="gender"
                    class="border-gray-300 rounded-lg w-full p-2 focus:ring-violet-400 focus:border-violet-400">
                    <option value="">Pilih</option>
                    <option value="male" {{ ($profile->gender ?? '') === 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ ($profile->gender ?? '') === 'female' ? 'selected' : '' }}>Perempuan
                    </option>
                    <option value="other" {{ ($profile->gender ?? '') === 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <x-button class="w-full bg-violet-500 text-white">Simpan Perubahan</x-button>
        </form>
    </x-card>
</x-guest.layout>