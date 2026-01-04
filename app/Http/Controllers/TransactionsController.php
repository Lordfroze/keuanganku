<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    //index function untuk menampilkan halaman transaksi
    public function index()
    {
        // tampilkan transaksi
        $transactions = Transaction::orderBy('created_at', 'desc')->get();
        return view('transactions.index', compact('transactions'));
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
}
