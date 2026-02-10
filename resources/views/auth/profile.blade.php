@extends('layouts.main')

@section('title', 'Profil Saya - FinTrack')

@section('content')
    <div class="container-fluid">

        <div class="row">

            <!-- Kartu Profil -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">

                        <img src="{{ auth()->user()->photo
        ? asset('storage/' . auth()->user()->photo)
        : asset('assets/images/profile/user-1.png') }}" class="rounded-circle mb-3" width="120" height="120"
                            style="object-fit: cover;" alt="Foto Profil">
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

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}"
                                    required>
                            </div>

                            <hr>

                            <h6 class="fw-semibold mb-3">Ganti Password (Opsional)</h6>

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