<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

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
        return view('transactions.create');
    }
}
