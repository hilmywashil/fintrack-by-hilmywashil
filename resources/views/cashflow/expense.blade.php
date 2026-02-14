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

                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
                    <h5 class="card-title mb-0">Data Pengeluaran</h5>

                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTambahPengeluaran">
                        <i class="ti ti-plus me-1"></i> Tambah Pengeluaran
                    </button>
                </div>
                <form method="GET" action="{{ route('expenses.index') }}" class="mb-4">
                    <div class="row g-3 align-items-end">

                        {{-- Dari Tanggal --}}
                        <div class="col-12 col-md-3">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>

                        {{-- Sampai Tanggal --}}
                        <div class="col-12 col-md-3">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>

                        {{-- Kategori --}}
                        <div class="col-12 col-md-3">
                            <label class="form-label">Kategori</label>
                            <select name="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ Str::title(str_replace('_', ' ', $category->name)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tombol --}}
                        <div class="col-12 col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-danger w-100">
                                Filter
                            </button>

                            <a href="{{ route('expenses.index') }}" class="btn btn-outline-muted w-100">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
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
                                    <td>
                                        <form action="{{ route('transactions.destroy', $expense->id) }}" method="POST"
                                            class="form-delete">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
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
    <!-- Modal Tambah Pengeluaran -->
    <div class="modal fade" id="modalTambahPengeluaran" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="type" value="expense">

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pengeluaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="expense_category_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
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
                            <label class="form-label">Catatan (Opsional)</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-danger">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
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
    document.addEventListener('DOMContentLoaded', function () {

        const deleteForms = document.querySelectorAll('.form-delete');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });

            });
        });

    });
</script>

@endpush