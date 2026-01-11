@extends('layouts.master')
@section('title', 'Transaksi')
@section('content')

<div class="card-body">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Transaksi</h3>
                <p class="text-subtitle text-muted">Transaksi seluruh data.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">DataTable</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>


<section class="row">
    <div class="col-12 col-lg-9">
        <div class="row">
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon green mb-2">
                                    <i class="fa-solid fa-circle-arrow-down"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Pendapatan</h6>
                                <h6 class="font-extrabold mb-0">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon red mb-2">
                                    <i class="fa-solid fa-circle-arrow-up"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Pengeluaran</h6>
                                <h6 class="font-extrabold mb-0">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon purple mb-2">
                                    <i class="fa-solid fa-piggy-bank"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Total transaksi</h6>
                                <h6 class="font-extrabold mb-0">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Tabel Transaksi
            </h5>


        </div>
        <div class="card-body">
            <!-- form pencarian -->
            <form method="GET" action="{{ route('transactions.index') }}" class="mb-3">
                <div class="row g-2 align-items-end">
                    <div class="col-auto">
                        <label>Bulan</label>
                        <input
                            type="month"
                            name="month"
                            class="form-control"
                            value="{{ request('month', now()->format('Y-m')) }}">
                    </div>

                    <div class="col-auto">
                        <button class="btn btn-primary">
                            Filter
                        </button>
                    </div>

                    <div class="col-auto">
                        <a href="{{ route('transactions.create') }}" class="btn icon icon-left btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg> Tambah data</a>
                    </div>
                </div>
            </form>
            <!-- end form pencarian -->

            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}</td>
                        <td>{{ 'Rp'. number_format($transaction->amount, 0, ',','.') }}</td>
                        <td>{{ $transaction->category->name }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>
                            <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Ubah
                            </a>
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus transaksi ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                        <td>

                        </td>
                    </tr>
                    <!-- jika table kosong -->
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endsection