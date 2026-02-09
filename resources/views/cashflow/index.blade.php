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
                        <li class="breadcrumb-item active">Cashflow</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">

                    <h5 class="card-title fw-semibold mb-4">
                        Recent Cashflows
                        @if(request('type'))
                            - {{ ucfirst(request('type')) }}
                        @endif
                    </h5>

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <form method="GET" class="d-flex gap-2 align-items-center">

                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>
                                    Income
                                </option>
                                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>
                                    Expense
                                </option>
                            </select>

                            <button type="submit" class="btn btn-primary">
                                Filter
                            </button>

                            @if(request('type'))
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
                                        <h6 class="fw-semibold mb-0">Number</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Type</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Category</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Amount</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Note</h6>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td>
                                            <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="badge {{ $transaction->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ ucfirst($transaction->type) }}
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
                                                Rp. {{ number_format($transaction->amount, 2) }}
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
                                    dari {{ $transactions->total() }} transaksi
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
                            <h5 class="card-title fw-semibold">Data Income & Expense</h5>
                        </div>
                        <div>
                            <select id="periodFilter" class="form-select">
                                <option value="7" selected>Last 7 Days</option>
                                <option value="14">Last 14 Days</option>
                                <option value="month">This Month</option>
                            </select>

                        </div>
                    </div>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Add Transaction</h5>

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
                        <label class="form-label">Transaction Type</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Income</option>
                            <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>

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
                        <label class="form-label">Amount</label>

                        <input type="text" id="amount_format" class="form-control" placeholder="Enter amount"
                            value="{{ old('amount') ? number_format(old('amount'), 0, ',', '.') : '' }}" required>

                        <input type="hidden" name="amount" id="amount_raw" value="{{ old('amount') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"
                            placeholder="Transaction notes (optional)">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" id="dateInput" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                            Back
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Save Transaction
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
        tippy('[data-tippy-content]', {
            placement: 'top',
            animation: 'scale',
            theme: 'light',
        });
    </script>
    <script>
        window.chartDays = @json($days);
        window.chartIncome = @json($income);
        window.chartExpense = @json($expense);
    </script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush