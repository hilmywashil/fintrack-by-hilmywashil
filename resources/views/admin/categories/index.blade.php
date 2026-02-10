@extends('layouts.main')

@section('title', 'Kategori Pemasukan - FinTrack')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Kategori</li>
                    </ol>
                </nav>
            </div>
        </div>
        {{-- TABEL DATA PEMASUKAN --}}
        <div class="card">
            <div class="card-body">

                <h5 class="card-title mb-4">Data Kategori Pemasukan</h5>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th class="text-center">Jumlah Transaksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($incomeCategories as $income)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ Str::title(str_replace('_', ' ', $income->name)) }}
                                    </td>
                                    <td class="text-center">
                                        <strong class="me-1">{{ $income->transactions_count }}</strong> Transaksi
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        Belum ada data kategori pemasukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="card">
            <div class="card-body">

                <h5 class="card-title mb-4">Data Kategori Pengeluaran</h5>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th class="text-center">Jumlah Transaksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($expenseCategories as $expense)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ Str::title(str_replace('_', ' ', $expense->name)) }}
                                    </td>
                                    <td class="text-center">
                                        <strong class="me-1">{{ $expense->transactions_count }}</strong> Transaksi
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        Belum ada data kategori pengeluaran
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection