@extends('layouts.main')

@section('title', 'Profil Saya - FinTrack')

@section('content')
    <div class="container-fluid">

        <div class="row">

            <!-- Kartu Profil -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">

                        <div class="position-relative d-inline-block">

                            <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('assets/images/profile/user-1.png') }}"
                                class="rounded-circle mb-3" width="120" height="120" style="object-fit: cover;"
                                alt="Foto Profil">

                            @if(auth()->user()->photo)
                                <form action="{{ route('profile.photo.delete') }}" method="POST" class="delete-photo-form">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="btn btn-danger btn-sm position-absolute btn-delete-photo"
                                        style="top: 5px; right: 5px; border-radius: 50%; width: 32px; height: 32px;">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            @endif

                        </div>
                        <h5 class="fw-semibold">
                            {{ auth()->user()->name }}
                        </h5>

                        <p class="text-muted mb-1">
                            {{ auth()->user()->email }}
                        </p>

                        <hr>

                        <div class="mt-3">
                            <h6 class="fw-semibold">Saldo Saat Ini</h6>
                            <h4 class="text-success fw-bold">
                                Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}
                            </h4>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Form Edit Profil -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title fw-semibold mb-4">
                            Pengaturan Profil
                        </h5>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="photo" class="form-control" accept="image/*">

                                <small class="text-muted">
                                    Format: JPG, PNG, JPEG. Maksimal 2MB
                                </small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}"
                                    id="disabledTextInput" for="disabledTextInput" disabled>
                            </div>


                            <hr class="my-2">

                            <h6 class="fw-semibold mb-3 mt-4">Ganti Password (Opsional)</h6>

                            <div class="mb-3">
                                <label class="form-label">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control"
                                    placeholder="Masukkan password saat ini">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Kosongkan jika tidak ingin mengganti">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>

                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const deleteBtn = document.querySelector('.btn-delete-photo');

            if (deleteBtn) {
                deleteBtn.addEventListener('click', function () {

                    Swal.fire({
                        title: 'Hapus Foto Profil?',
                        text: "Foto profil kamu akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('form').submit();
                        }
                    });

                });
            }

        });
    </script>
@endpush