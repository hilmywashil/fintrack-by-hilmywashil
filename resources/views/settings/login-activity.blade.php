@extends('layouts.main')

@section('title', 'Aktivitas Login - FinTrack')

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
                            Aktivitas Login
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- CARD UTAMA --}}
        <div class="card">
            <div class="card-body">

                {{-- HEADER --}}
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
                    <h5 class="card-title mb-0">Riwayat Aktivitas Login</h5>

                    <form action="{{ route('settings.login-activity.clear') }}" method="POST" class="form-delete">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">
                            <i class="ti ti-trash me-1"></i>
                            Clear History
                        </button>
                    </form>
                </div>

                {{-- SEARCH --}}
                <form method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari IP atau Device..."
                            value="{{ request('keyword') }}">

                        <button class="btn btn-primary">
                            <i class="ti ti-search me-1"></i>
                            Search
                        </button>
                    </div>
                </form>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>IP Address</th>
                                <th>Device</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($activities as $key => $activity)
                                                <tr>
                                                    <td>
                                                        {{ $activities->firstItem() + $key }}
                                                    </td>

                                                    <td>
                                                        {{ \Carbon\Carbon::parse($activity->login_at)
                                ->translatedFormat('d F Y H:i') }}
                                                    </td>

                                                    <td>
                                                        {{ $activity->ip_address }}
                                                    </td>

                                                    <td>
                                                        <span class="text-muted">
                                                            {{ $activity->device }}
                                                        </span>
                                                    </td>
                                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        Tidak ada aktivitas login
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION CUSTOM (BIAR KONSISTEN) --}}
                @if ($activities->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="text-muted small">
                            Menampilkan {{ $activities->firstItem() }} - {{ $activities->lastItem() }}
                            dari {{ $activities->total() }} data
                        </div>

                        <nav>
                            <ul class="pagination mb-0">

                                <li class="page-item {{ $activities->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $activities->previousPageUrl() ?? '#' }}">
                                        <i class="ti ti-chevron-left"></i>
                                    </a>
                                </li>

                                @foreach ($activities->links()->elements[0] as $page => $url)
                                    <li class="page-item {{ $page == $activities->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <li class="page-item {{ $activities->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $activities->nextPageUrl() ?? '#' }}">
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

@push('scripts')
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