@extends('layouts.main')

@section('title', 'Data Pengeluaran - FinTrack')

@section('content')

    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Pengeluaran</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-start">

                            <div class="col-8">
                                <h5 class="card-title mb-2 fw-semibold">
                                    Pengeluaran Bulan Ini
                                </h5>

                                <h4 class="fw-semibold mb-3">
                                    Rp {{ number_format($currentMonthExpense, 0, ',', '.') }}
                                </h4>

                                <div class="d-flex align-items-center pb-1">

                                    @if($percentageExpense >= 0)
                                        <span
                                            class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-arrow-up-right text-danger"></i>
                                        </span>

                                        <p class="text-danger me-1 fs-3 mb-0">
                                            {{ number_format($percentageExpense, 1) }}%
                                        </p>
                                    @else
                                        <span
                                            class="me-2 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-arrow-down-right text-success"></i>
                                        </span>

                                        <p class="text-success me-1 fs-3 mb-0">
                                            {{ number_format(abs($percentageExpense), 1) }}%
                                        </p>
                                    @endif

                                    <p class="fs-3 mb-0">dibanding bulan lalu</p>

                                </div>
                            </div>

                            <div class="col-4">
                                <div class="d-flex justify-content-end">
                                    <div
                                        class="text-white bg-danger rounded-circle p-6 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-receipt fs-6"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABEL DATA PENGELUARAN --}}
        <div class="card">
            <div class="card-body">

                <h5 class="card-title mb-4">Data Pengeluaran</h5>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($expenses as $expense)
                                <tr>

                                    <td>
                                        {{ \Carbon\Carbon::parse($expense->date)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>
                                        {{ Str::title(str_replace('_', ' ', $expense->expenseCategory?->name)) }}
                                    </td>

                                    <td class="text-danger fw-bold">
                                        Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        <p class="mb-0 fw-normal" data-tippy-content="{{ $expense->description ?? '-' }}">
                                            {{ Str::limit($expense->description ?? '-', 20) }}
                                        </p>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        Belum ada data pengeluaran
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($expenses->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="text-muted small">
                            Menampilkan {{ $expenses->firstItem() }} - {{ $expenses->lastItem() }}
                            dari {{ $expenses->total() }} data
                        </div>

                        <nav>
                            <ul class="pagination mb-0">

                                <li class="page-item {{ $expenses->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $expenses->previousPageUrl() ?? '#' }}">
                                        <i class="ti ti-chevron-left"></i>
                                    </a>
                                </li>

                                @foreach ($expenses->links()->elements[0] as $page => $url)
                                    <li class="page-item {{ $page == $expenses->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <li class="page-item {{ $expenses->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $expenses->nextPageUrl() ?? '#' }}">
                                        <i class="ti ti-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @endif

            </div>
        </div>

    </div>

@endsection