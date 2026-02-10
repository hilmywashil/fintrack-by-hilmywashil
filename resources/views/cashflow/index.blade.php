@extends('layouts.main')

@section('title', 'Tambah Transaksi - FinTrack')

@section('content')

    @php use Illuminate\Support\Str; @endphp

    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Keuangan</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">

                    <h5 class="card-title fw-semibold mb-4">
                        Daftar Transaksi Terbaru

                        @if(request('type'))
                            - {{ request('type') == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        @endif

                        @if(request('date'))
                            - {{ \Carbon\Carbon::parse(request('date'))->translatedFormat('d F Y') }}
                        @endif
                    </h5>

                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">

                        <form method="GET"
                            class="d-flex flex-column flex-md-row gap-2 align-items-stretch align-items-md-center w-100 w-md-auto">

                            <select name="type" class="form-select">
                                <option value="">Semua Tipe</option>
                                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>
                                    Pemasukan
                                </option>
                                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>
                                    Pengeluaran
                                </option>
                            </select>

                            <input type="date" name="date" class="form-control" value="{{ request('date') }}">

                            <button type="submit" class="btn btn-primary">
                                Filter
                            </button>

                            @if(request('type') || request('date'))
                                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                                    Reset
                                </a>
                            @endif

                        </form>

                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Tanggal</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Tipe</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Kategori</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Jumlah</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Catatan</h6>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td>
                                            <h6 class="fw-semibold mb-0">
                                                {{ \Carbon\Carbon::parse($transaction->date)->translatedFormat('d F Y') }}
                                            </h6>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="badge {{ $transaction->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="fw-semibold mb-1">
                                                {{ Str::title(str_replace('_', ' ', $transaction->type === 'income' ? $transaction->incomeCategory?->name : $transaction->expenseCategory?->name)) ?? '-' }}
                                            </h6>
                                        </td>

                                        <td>
                                            <h6 class="fw-semibold mb-0 fs-4">
                                                Rp. {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </h6>
                                        </td>

                                        <td>
                                            <p class="mb-0 fw-normal"
                                                data-tippy-content="{{ $transaction->description ?? '-' }}">
                                                {{ Str::limit($transaction->description ?? '-', 20) }}
                                            </p>
                                        </td>

                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada Data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if ($transactions->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-3">

                                <div class="text-muted small">
                                    Menampilkan {{ $transactions->firstItem() }} - {{ $transactions->lastItem() }}
                                    dari {{ $transactions->total() }} data
                                </div>

                                <nav>
                                    <ul class="pagination mb-0">

                                        <li class="page-item {{ $transactions->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $transactions->previousPageUrl() ?? '#' }}">
                                                <i class="ti ti-chevron-left"></i>
                                            </a>
                                        </li>

                                        @foreach ($transactions->links()->elements[0] as $page => $url)
                                            <li class="page-item {{ $page == $transactions->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <li class="page-item {{ $transactions->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $transactions->nextPageUrl() ?? '#' }}">
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
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Tambah Transaksi</h5>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Jenis Transaksi</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>

                        <select name="income_category_id" id="incomeCategory" class="form-control">
                            @foreach($incomeCategories as $category)
                                <option value="{{ $category->id }}">
                                    {{ Str::title(str_replace('_', ' ', $category->name)) }}
                                </option>
                            @endforeach
                        </select>

                        <select name="expense_category_id" id="expenseCategory" class="form-control d-none">
                            @foreach($expenseCategories as $category)
                                <option value="{{ $category->id }}">
                                    {{ Str::title(str_replace('_', ' ', $category->name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>

                        <input type="text" id="amount_format" class="form-control" placeholder="Masukkan jumlah"
                            value="{{ old('amount') ? number_format(old('amount'), 0, ',', '.') : '' }}" required>

                        <input type="hidden" name="amount" id="amount_raw" value="{{ old('amount') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="description" class="form-control" rows="3"
                            placeholder="Catatan transaksi (opsional)">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="date" class="form-control" id="dateInput" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Simpan Transaksi
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection

@push('scripts')

    <script>
        const dateInput = document.getElementById('dateInput');
        const today = new Date().toISOString().split('T')[0];
        dateInput.value = today;
    </script>

    <script>
        const inputFormat = document.getElementById('amount_format');
        const inputRaw = document.getElementById('amount_raw');

        inputFormat.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '');
            inputRaw.value = value;
            this.value = new Intl.NumberFormat('id-ID').format(value);
        });
    </script>

    <script>
        document.getElementById('type').addEventListener('change', function () {
            let type = this.value;

            let incomeSelect = document.getElementById('incomeCategory');
            let expenseSelect = document.getElementById('expenseCategory');

            if (type === 'income') {
                incomeSelect.classList.remove('d-none');
                expenseSelect.classList.add('d-none');
            } else if (type === 'expense') {
                incomeSelect.classList.add('d-none');
                expenseSelect.classList.remove('d-none');
            }
        });
    </script>

    <script>
        window.chartDays = @json($days);
        window.chartIncome = @json($income);
        window.chartExpense = @json($expense);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush