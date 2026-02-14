@extends('layouts.main')

@section('title', 'Feedback - FinTrack')

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
                            Feedback
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
                    <h5 class="card-title mb-0">Daftar Feedback</h5>
                </div>

                {{-- SEARCH --}}
                <form method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari nama atau email..."
                            value="{{ $keyword ?? '' }}">
                        <button class="btn btn-primary">
                            <i class="ti ti-search me-1"></i> Search
                        </button>
                    </div>
                </form>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Pesan</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($feedbacks as $key => $fb)
                                <tr>
                                    <td>{{ $feedbacks->firstItem() + $key }}</td>
                                    <td>{{ $fb->name }}</td>
                                    <td>{{ $fb->email }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#feedbackModal{{ $fb->id }}">
                                            <i class="ti ti-eye me-1"></i>Lihat
                                        </button>
                                    </td>
                                    <td>{{ $fb->created_at->translatedFormat('d F Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('feedback.destroy', $fb->id) }}" method="POST"
                                            class="form-delete d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="ti ti-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- MODAL PESAN --}}
                                <div class="modal fade" id="feedbackModal{{ $fb->id }}" tabindex="-1"
                                    aria-labelledby="feedbackModalLabel{{ $fb->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="feedbackModalLabel{{ $fb->id }}">
                                                    Pesan dari {{ $fb->name }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ $fb->message }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada feedback</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if ($feedbacks->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="text-muted small">
                            Menampilkan {{ $feedbacks->firstItem() }} - {{ $feedbacks->lastItem() }}
                            dari {{ $feedbacks->total() }} data
                        </div>

                        <nav>
                            <ul class="pagination mb-0">

                                <li class="page-item {{ $feedbacks->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $feedbacks->previousPageUrl() ?? '#' }}">
                                        <i class="ti ti-chevron-left"></i>
                                    </a>
                                </li>

                                @foreach ($feedbacks->links()->elements[0] as $page => $url)
                                    <li class="page-item {{ $page == $feedbacks->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <li class="page-item {{ $feedbacks->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $feedbacks->nextPageUrl() ?? '#' }}">
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