<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreIncomeRequest;

class IncomeController extends Controller
{
    public function index(){
        $incomes = Income::all();
        return view('private.admin.incomes.index', compact('incomes'));
    }

    public function create(){
        return view('private.admin.incomes.create');
    }
    public function store(StoreIncomeRequest $request){
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            Income::create($validated);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pemasukan: ' . $th->getMessage());
        }
        return redirect()->route('admin.incomes.index')->with('success', 'Pemasukan berhasil dibuat!');

    }

    public function edit(Income $income){
        return view('private.admin.incomes.edit', compact('income'));
    }

    public function update(StoreIncomeRequest $request, Income $income){
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            $income->update($validated);
            DB::commit();
            return redirect()->route('admin.incomes.index')->with('success', 'Pemasukan berhasil diperbarui!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui pemasukan: ' . $th->getMessage());
        }
    }

    public function destroy(Income $income){
        $income->delete();
        return redirect()->route('admin.incomes.index')->with('success', 'Pemasukan berhasil dihapus!');
    }
}

