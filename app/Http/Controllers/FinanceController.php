<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialTransaction;

class FinanceController extends Controller
{
    //menampilkan halaman laporan kas & daftar transaksi
    public function index()
    {
        $transactions = FinancialTransaction::orderBy('date', 'desc')->paginate(10);
        $totalIncome = FinancialTransaction::where('type', 'income')->sum('amount');
        $totalExpense = FinancialTransaction::where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('admin.finance.index', compact('transaction', 'balance', 'totalIncome', 'totalExpense'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:1',
            'category' => 'required|string',
            'date' => 'required|date',
            'description' => 'required|string',
            'proof_file' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Maksimal 2MB
        ]);

        if ($request->hasFile('proof_file')) {
            $validated['proof_file'] = $request->file('proof_file')->store('receipts', 'public');
        }

        $validated['created_by'] = \Illuminate\Support\Facades\Auth::id();
        FinancialTransaction::create($validated);
        
        return redirect()->back()->with('succes', 'Transaksi kas berhasil dicatat!');
    }
}
