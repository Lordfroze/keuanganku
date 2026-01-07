<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionsController extends Controller
{
    //index function untuk menampilkan halaman transaksi sesuai bulan
    public function index(Request $request)
    {
        $query = Transaction::query();
        if ($request->filled('month')) {
            $date = Carbon::parse($request->month);

            $query->whereYear('transaction_date', $date->year)
                ->whereMonth('transaction_date', $date->month);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->get();
        $totalAmount = $query->sum('amount');
        $totalIncome = (clone $query)->where('category_id', '1')->sum('amount');
        $totalExpense = (clone $query)->where('category_id', '2')->sum('amount');



        // tampilkan transaksi
        return view('transactions.index', compact('transactions', 'totalAmount', 'totalIncome', 'totalExpense'));
    }

    // function create untuk menampilkan halaman tambah transaksi
    public function create()
    {
        // mengambil data category
        $categories = Category::orderBy('name', 'asc')->get();
        return view('transactions.create', compact('categories'));
    }

    // function store untuk menyimpan transaksi
    public function store(Request $request)
    {
        // validasi data
        $request->validate([
            'transaction_date' => 'required|date',
            'category_id' => 'required',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        // simpan transaksi
        Transaction::create([
            // 'user_id' => Auth::id(), // mengambil id user yang login
            'user_id' => 1, // sementara hardcode user_id ke 1
            'transaction_date' => $request->transaction_date,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        // redirect ke halaman transaksi
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        // mengambil data transaction
        $transaction = Transaction::findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        // validasi data
        $request->validate([
            'transaction_date' => 'required|date',
            'category_id' => 'required',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        // update transaksi
        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'transaction_date' => $request->transaction_date,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        // redirect ke halaman transaksi
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate');
    }

    // function destroy untuk menghapus transaksi
    public function destroy(string $id)
    {
        // hapus transaksi
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        // redirect ke halaman transaksi
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
