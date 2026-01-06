@extends('layouts.master')
@section('title', 'Tambah Transaksi')
@section('content')
<div id="main">
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading">Submit Error!</h5>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <!-- Basic Horizontal form layout section start -->
        <section id="basic-horizontal-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tambah transaksi</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-horizontal" method="POST" action="{{ route('transactions.store') }}">
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="transaction_date">Tanggal</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="date" id="transaction_date" class="form-control" name="transaction_date"
                                                    placeholder="Tanggal" value="{{ now()->format('Y-m-d') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="category_id">Jenis Transaksi</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <select class="form-select" id="category_id" name="category_id">
                                                    @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="amount">Jumlah</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="number" id="amount" class="form-control" name="amount"
                                                    placeholder="Jumlah transaksi">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="keterangan">Keterangan</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="keterangan" class="form-control" name="keterangan"
                                                    placeholder="pendapatan dari jualan">
                                            </div>

                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                                <button type="reset"
                                                    class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic Horizontal form layout section end -->
        @endsection