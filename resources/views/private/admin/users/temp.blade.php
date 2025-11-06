<x-admin.layout>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Pengguna</h1>

            <form method="GET" action="{{ route('admin.users') }}" class="flex items-center gap-2">
                <input type="text" name="search" placeholder="Cari nama/email..."
                    class="border-gray-300 rounded-md focus:ring-violet-400 focus:border-violet-400 w-64 text-sm"
                    value="{{ request('search') }}">
                <x-button type="submit" class="bg-violet-500 text-white text-sm px-4 py-2">Cari</x-button>
            </form>
        </div>

        {{-- Notifikasi --}}
        @if (session('success'))
        <x-card class="bg-green-50 border border-green-200 text-green-700 p-3">
            ✅ {{ session('success') }}
        </x-card>
        @endif

        {{-- Tabel User --}}
        @if ($users->isEmpty())
        <x-card class="text-center py-10 text-gray-500">
            <p>Belum ada pengguna yang terdaftar.</p>
        </x-card>
        @else
        <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3 text-center">Ubah Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                        <td class="px-4 py-3 capitalize">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        @switch($user->role)
                                            @case('admin') bg-violet-100 text-violet-700 @break
                                            @case('receptionist') bg-blue-100 text-blue-700 @break
                                            @default bg-gray-100 text-gray-700
                                        @endswitch">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <form method="POST" action="{{ route('admin.users.updateRole', $user) }}"
                                class="inline-flex gap-2 items-center justify-center">
                                @csrf
                                @method('PUT')
                                <select name="role" onchange="this.form.submit()"
                                    class="text-xs border-gray-300 rounded-md focus:ring-violet-400 focus:border-violet-400 cursor-pointer">
                                    <option value="guest" @selected($user->role === 'guest')>Tamu</option>
                                    <option value="receptionist" @selected($user->role === 'receptionist')>Recepsionis
                                    </option>
                                    <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-5">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</x-admin.layout>