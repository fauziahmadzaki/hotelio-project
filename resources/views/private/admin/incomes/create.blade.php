<x-admin.layout>
    <x-card class="max-w-xl">
        <h1 class="text-lg font-bold">Tambah Laporan</h1>
        <form action="{{ route('admin.incomes.store') }}" method="POST" class="space-y-3">
            @csrf
            <x-input-group id="description" placeholder="Deskripsi singkat" label="Deskripsi" type="text"
                value="{{ old('description') }}" error="{{ $errors->first('description') }}"></x-input-group>
            <x-input-group id="amount" placeholder="10000" label="Nominal" type="number" value="{{ old('amount') }}"
                error="{{ $errors->first('amount') }}">
            </x-input-group>
            <x-input-group id="date" label="Tanggal" type="date" value="{{ old('date') }}"
                error="{{ $errors->first('date') }}"></x-input-group>
            <div class="flex gap-4 items-end">
                <div>
                    <x-label>Tipe</x-label>
                    @error('type')
                    <x-error>{{ $message }}</x-error>
                    @enderror
                    <select name="type" value="{{ old('type') ?? 'income' }}"
                        class="w-fit border border-gray-200 rounded-lg p-2">
                        <option value="income">Pemasukan</option>
                        <option value="expense">Pengeluaran</option>
                    </select>
                </div>
                <div>
                    <x-label>Metode Pembayaran</x-label>
                    @error('payment_method')
                    <x-error>{{ $message }}</x-error>
                    @enderror
                    <select name="payment_method" value="{{ old('type') ?? 'income' }}"
                        class="w-fit border border-gray-200 rounded-lg p-2">
                        <option value="cash">Tunai</option>
                        <option value="transfer">Transfer</option>
                        <option value="card">Kartu</option>
                    </select>
                </div>
                <div>

                    <x-label>Kategori</x-label>
                    @error('category')
                    <x-error>{{ $message }}</x-error>
                    @enderror
                    <select name="category" value="{{ old('category') ?? 'income' }}"
                        class="w-fit border border-gray-200 rounded-lg p-2">
                        @foreach (['rental', 'food', 'other'] as $item)
                        <option value="{{ $item }}">{{ ucfirst($item) }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <x-button type="submit" class="w-full bg-violet-500 text-white">Buat</x-button>
        </form>
    </x-card>
</x-admin.layout>