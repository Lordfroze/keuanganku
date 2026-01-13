@extends('layouts.master')
@section('title', 'Tambah Kategori')
@section('content')
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
                        <h4 class="card-title">Tambah Kategori</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" method="POST" action="{{ route('categories.store') }}">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="name">Jenis Kategori</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <select class="form-select" id="category_type" name="category_type">
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->type }}">{{ $category->type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="description">Keterangan</label>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <input type="text" id="description" class="form-control" name="description"
                                                placeholder="pendapatan dari jualan" value="jualan">
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
    </section>
    <!-- // Basic Horizontal form layout section end -->
    @endsection