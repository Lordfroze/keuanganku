<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    //index function untuk menampilkan halaman transaksi
    public function index()
    {
        return view('transactions.index');
    }
}
