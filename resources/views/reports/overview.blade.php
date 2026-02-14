@extends('layouts.main')

@section('title', 'Laporan Ringkasan - FinTrack')

@section('content')

    <div class="container-fluid">

        {{-- BREADCRUMB --}}
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Laporan Ringkasan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- FILTER BULAN --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Pilih Bulan</label>
                        <input type="month" name="month" value="{{ $month }}" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- SUMMARY CARD --}}
        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Total Pemasukan</h6>
                        <h4 class="text-success">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Total Pengeluaran</h6>
                        <h4 class="text-danger">
                            Rp {{ number_format($totalExpense, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Saldo / Selisih</h6>
                        <h4 class="{{ $balance >= 0 ? 'text-primary' : 'text-danger' }}">
                            Rp {{ number_format($balance, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection