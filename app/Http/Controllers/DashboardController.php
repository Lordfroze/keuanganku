<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //menampilkan halaman dashboard
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
        return view('dashboard', compact('transactions', 'totalAmount', 'totalIncome', 'totalExpense'));
    }
}
