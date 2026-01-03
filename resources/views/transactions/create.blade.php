@section('title', 'Tambah Transaksi')
@extends('layouts.master')
@section('content')
<div id="main">
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
                            <form class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="jenis-transaksi">Jenis Transaksi</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="jenis-transaksi" class="form-control" name="jenis_transaksi"
                                                placeholder="Jenis Transaksi">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="jumlah">Jumlah</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="number" id="jumlah" class="form-control" name="jumlah"
                                                placeholder="Jumlah">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="keterangan">Keterangan</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="keterangan" class="form-control" name="keterangan"
                                                placeholder="Keterangan">
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