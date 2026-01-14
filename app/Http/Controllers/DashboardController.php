<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{
    //menampilkan halaman dashboard
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id());

        if ($request->filled('month')) {
            $date = Carbon::parse($request->month);

            $query->whereYear('transaction_date', $date->year)
                ->whereMonth('transaction_date', $date->month);
        }

        $transactions = (clone $query)
            ->orderBy('transaction_date', 'desc')
            ->get();

        $totalAmount = (clone $query)->sum('amount');

        $totalIncome = (clone $query)
            ->whereHas('category', function ($q) {
                $q->where('type', 'income');
            })
            ->sum('amount');

        $totalExpense = (clone $query)
            ->whereHas('category', function ($q) {
                $q->where('type', 'expense');
            })
            ->sum('amount');

        // DATA CHART PENDAPATAN PER BULAN dikrim ke chart-income.js
        $year = $request->filled('month')
            ? Carbon::parse($request->month)->year
            : now()->year;

        $chartQuery = Transaction::where('user_id', Auth::id())
            ->whereHas('category', function ($q) {
                $q->where('type', 'income');
            })
            ->whereYear('transaction_date', $year);

        $incomePerMonth = (clone $chartQuery)
            ->selectRaw('MONTH(transaction_date) as month, SUM(amount) as total')
            ->whereYear('transaction_date', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyIncome = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyIncome[] = $incomePerMonth[$i] ?? 0;
        }


        return view('dashboard', compact(
            'transactions',
            'totalAmount',
            'totalIncome',
            'totalExpense',
            'monthlyIncome'
        ));
    }
}
