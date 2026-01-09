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

        // DATA CHART PENDAPATAN PER BULAN dikrim ke chart-income.js
        $year = $request->filled('month')
            ? Carbon::parse($request->month)->year
            : now()->year;

        $incomePerMonth = Transaction::selectRaw('MONTH(transaction_date) as month, SUM(amount) as total')
            ->where('category_id', 1)
            ->whereYear('transaction_date', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyIncome = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyIncome[] = $incomePerMonth[$i] ?? 0;
        }


        // tampilkan transaksi
        return view('dashboard', compact('transactions', 'totalAmount', 'totalIncome', 'totalExpense', 'monthlyIncome'));
    }
}
