<x-admin.layout>
    <x-slot:title>Pengguna</x-slot:title>


    <h1 class="text-2xl font-semibold text-gray-800 mb-5">Daftar Pengguna</h1>

    {{-- Flash Message --}}
    {{-- @if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">{{ session('success') }}</div>
    @elseif (session('error'))
    <div class="bg-red-100 text-red-800 p-3 rounded-lg mb-4">{{ session('error') }}</div>
    @endif --}}

    {{-- Tabel Reservasi --}}
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Aksi</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">
                        <p class="font-semibold">{{ $user->name }}</p>

                    </td>
                    <td class="px-4 py-3">
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </td>

                    <td class="px-4 py-3 text-left">
                        <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <select name="role" onchange="this.form.submit()"
                                class="text-xs border-gray-300 rounded-md focus:ring-violet-400 focus:border-violet-400">
                                <option value="guest" @selected($user->role == 'guest')>Tamu</option>
                                <option value="receptionist" @selected($user->role == 'receptionist')>Resepsionis
                                </option>

                            </select>
                        </form>
                    </td>
                    <td class="px-4 py-3">
                        <form action="" method="POST" onsubmit="return confirm('Hapus fasilitas ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1 bg-red-500 text-white rounded-md text-xs hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">Belum ada user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $users->links() }}
    </div>
</x-admin.layout>