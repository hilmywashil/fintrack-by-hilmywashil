@extends('layouts.main')

@section('title', 'Dashboard - FinTrack')

@section('content')
    <div class="col-12">
        <div class="card bg-primary text-white overflow-hidden">
            <div class="card-body position-relative p-4">
                <!-- Sambutan & Balance -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div class="mb-3 mb-md-0">
                        <h4 class="fw-bold text-white">Halo, {{ auth()->user()->name }}</h4>
                        <p class="mb-0">Selamat datang kembali</p>
                    </div>
                    <div class="text-md-end">
                        <h3 class="fw-bold mb-1 text-white">
                            Rp {{ number_format(auth()->user()->balance ?? 0, 0, ',', '.') }}
                        </h3>
                        <small class="d-block">IDR</small>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-6">
                    <!-- Yearly Breakup -->
                    <div class="card overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-9 fw-semibold">Rata-rata Pemasukan perbulan</h5>
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <h4 class="fw-semibold mb-3">Rp
                                        {{ number_format($averageMonthlyIncome, 0, ',', '.') }} IDR
                                    </h4>
                                    <div class="d-flex align-items-center mb-3">
                                        <span
                                            class="me-2 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-info-circle"></i>
                                        </span>
                                        <p class="text-dark me-1 fs-3 mb-0">Berdasarkan data pemasukan Anda</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <!-- Monthly Earnings -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-start">
                                <div class="col-8">
                                    <h5 class="card-title mb-9 fw-semibold">Rata-rata Pengeluaran Bulanan</h5>
                                    <h4 class="fw-semibold mb-3">
                                        Rp {{ number_format($averageMonthlyExpense, 0, ',', '.') }} IDR
                                    </h4>
                                    <div class="d-flex align-items-center pb-1">
                                        <span
                                            class="me-2 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-info-circle"></i>
                                        </span>
                                        <p class="text-dark me-1 fs-3 mb-0">Berdasarkan data pengeluaran Anda</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Grafik Data Pemasukan dan Pengeluaran</h5>
                        </div>
                        <div>
                            <select id="periodFilter" class="form-select">
                                <option value="7" selected>7 Hari Terakhir</option>
                                <option value="14">14 Hari Terakhir</option>
                                <option value="month">Bulan Ini</option>
                            </select>

                        </div>
                    </div>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">

        {{-- Income Terbaru --}}
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-3">
                        Pemasukan Terbaru
                    </h5>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestIncomes as $income)
                                    <tr>
                                        <td class="fw-semibold text-success">
                                            Rp {{ number_format($income->amount, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-light-success text-success">
                                                {{ Str::ucfirst($income->incomeCategory->name ?? '-') }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">
                                            Belum ada income
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        {{-- Expense Terbaru --}}
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-3">
                        Pengeluaran Terbaru
                    </h5>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestExpenses as $expense)
                                    <tr>
                                        <td class="fw-semibold text-danger">
                                            Rp {{ number_format($expense->amount, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-light-danger text-danger">
                                                {{ Str::ucfirst($expense->expenseCategory->name ?? '-') }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">
                                            Belum ada expense
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        window.chartDays = @json($days);
        window.chartIncome = @json($income);
        window.chartExpense = @json($expense);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush