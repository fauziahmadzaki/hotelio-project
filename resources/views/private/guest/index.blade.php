<x-guest.layout>
    <div x-data="dashboardData()" x-init="fetchData()" class="space-y-6 px-4 sm:px-6 lg:px-8">

        {{-- Judul --}}
        <h1 class="text-2xl font-bold text-gray-800 text-center sm:text-left">
            Selamat Datang, {{ auth()->user()->name }} 👋
        </h1>

        {{-- Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <template x-for="stat in stats" :key="stat.title">
                <div>
                    <x-card
                        class="border-l-4 p-4 flex flex-col justify-center items-start sm:items-center text-center sm:text-left shadow-sm hover:shadow-md transition-all duration-200"
                        x-bind:class="stat.color">
                        <h2 class="font-semibold text-gray-700" x-text="stat.title"></h2>
                        <p class="text-3xl font-bold mt-1" x-bind:class="stat.textColor" x-text="stat.value"></p>
                    </x-card>
                </div>
            </template>
        </div>

        {{-- Reservasi Terakhir --}}
        <template x-if="latest">
            <x-card
                class="max-w-2xl mx-auto p-5 flex flex-col sm:flex-row gap-4 items-center shadow-sm hover:shadow-md transition-all duration-200">
                <template x-if="latest.room_image">
                    <img :src="latest.room_image" alt="Gambar kamar"
                        class="w-full sm:w-32 h-48 sm:h-32 object-cover rounded-lg shadow-md">
                </template>

                <div class="flex-1 text-center sm:text-left">
                    <h2 class="text-xl font-semibold text-violet-700" x-text="latest.room_name"></h2>
                    <p class="text-gray-600 text-sm mt-1 leading-relaxed">
                        <span x-text="'Check-in: ' + latest.check_in"></span><br>
                        <span x-text="'Check-out: ' + latest.check_out"></span>
                    </p>
                    <p class="mt-2 text-sm">
                        Status:
                        <span class="font-semibold capitalize" :class="{
                            'text-yellow-600': latest.status === 'pending',
                            'text-green-600': latest.status === 'confirmed',
                            'text-red-600': latest.status === 'cancelled'
                        }" x-text="latest.status"></span>
                    </p>
                </div>
            </x-card>
        </template>

        {{-- Jika belum ada reservasi --}}
        <template x-if="!latest">
            <div class="text-gray-500 mt-8 text-center">
                <p>
                    Belum ada reservasi aktif. Yuk,
                    <a href="{{ route('home') }}" class="text-violet-600 underline hover:text-violet-700">
                        pesan kamar
                    </a> sekarang!
                </p>
            </div>
        </template>
    </div>

    {{-- Alpine.js Dashboard Logic --}}
    @push('scripts')
    <script>
        window.dashboardData = function () {
                return {
                    stats: [
                        { title: 'Kamar Dibooking', value: 0, color: 'border-violet-500', textColor: 'text-violet-600' },
                        { title: 'Belum Check-in', value: 0, color: 'border-yellow-500', textColor: 'text-yellow-600' },
                        { title: 'Dibatalkan', value: 0, color: 'border-red-500', textColor: 'text-red-600' },
                    ],
                    latest: null,

                    async fetchData() {
                        try {
                            const res = await fetch('{{ route('guest.dashboard.data') }}', {
                                headers: { 'Accept': 'application/json' }
                            });
                            if (!res.ok) throw new Error('Gagal memuat data');
                            const data = await res.json();

                            this.stats[0].value = data.pending ?? 0;
                            this.stats[1].value = data.confirmed ?? 0;
                            this.stats[2].value = data.cancelled ?? 0;
                            this.latest = data.latest;
                        } catch (error) {
                            console.error('❌ Error memuat data dashboard:', error);
                        }
                    }
                }
            }
    </script>
    @endpush
</x-guest.layout>