<x-admin.layout>
    <x-card class="max-w-xl">
        <h1 class="text-lg font-bold">Edit Laporan</h1>
        <form action="{{ route('admin.incomes.update', $income) }}" method="POST" class="space-y-3">
            @csrf
            @method('PUT')
            <x-input-group id="description" placeholder="Deskripsi singkat" label="Deskripsi" type="text"
                value="{{ old('description', $income->description) }}" error="{{ $errors->first('description') }}">
            </x-input-group>

            <x-input-group id="amount" placeholder="10000" label="Nominal" type="number"
                value="{{ old('amount', $income->amount) }}" error="{{ $errors->first('amount') }}"></x-input-group>

            <x-input-group id="date" label="Tanggal" type="date" value="{{ old('date', $income->date )}}"
                error="{{ $errors->first('date') }}">
            </x-input-group>

            <div class="flex gap-4 items-end">
                <div>
                    <x-label>Tipe</x-label>
                    @error('type')
                    <x-error>{{ $message }}</x-error>
                    @enderror
                    <select name="type" class="w-fit border border-gray-200 rounded-lg p-2">
                        <option value="income" {{ old('type', $income->type) == 'income' ? 'selected' : '' }}>Pemasukan
                        </option>
                        <option value="expense" {{ old('type', $income->type) == 'expense' ? 'selected' : ''
                            }}>Pengeluaran</option>
                    </select>
                </div>

                <div>
                    <x-label>Metode Pembayaran</x-label>
                    @error('payment_method')
                    <x-error>{{ $message }}</x-error>
                    @enderror
                    <select name="payment_method" class="w-fit border border-gray-200 rounded-lg p-2">
                        <option value="cash" {{ old('payment_method', $income->payment_method) == 'cash' ? 'selected' :
                            '' }}>Tunai</option>
                        <option value="transfer" {{ old('payment_method', $income->payment_method) == 'transfer' ?
                            'selected' : '' }}>Transfer</option>
                        <option value="card" {{ old('payment_method', $income->payment_method) == 'card' ? 'selected' :
                            '' }}>Kartu</option>
                    </select>
                </div>

                <div>
                    <x-label>Kategori</x-label>
                    @error('category')
                    <x-error>{{ $message }}</x-error>
                    @enderror
                    <select name="category" class="w-fit border border-gray-200 rounded-lg p-2">
                        @foreach (['rental', 'maintenance', 'food & beverage', 'other'] as $item)
                        <option value="{{ $item }}" {{ old('category', $income->category) == $item ? 'selected' : '' }}>
                            {{ ucfirst($item) }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <x-button type="submit" class="w-full bg-violet-500 text-white">Simpan Perubahan</x-button>
        </form>
    </x-card>
</x-admin.layout>