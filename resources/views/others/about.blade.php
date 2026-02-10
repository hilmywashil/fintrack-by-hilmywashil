@extends('layouts.main')

@section('title', 'Tentang FinTrack')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tentang FinTrack</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="{{ asset('assets/images/logos/logo-square.png') }}" alt="Logo FinTrack" class="img-fluid mb-3"
                        style="max-width: 200px;">
                </div>
                <p class="mb-0  ">FinTrack adalah aplikasi manajemen keuangan pribadi yang dirancang untuk membantu Anda
                    melacak dan mengelola pengeluaran serta pemasukan Anda secara efektif. Disini Anda dapat melihat
                    laporan
                    keuangan bulanan, mengelola kategori transaksi, dan menyesuaikan pengaturan sesuai kebutuhan Anda.
                </p>
                <div class="mt-4">
                    <h6 class="fw-semibold mb-3">Fitur Utama:</h6>
                    <ul class="list-unstyled">
                        <li><i class="ti ti-check text-success me-2"></i>Pencatatan transaksi pendapatan dan
                            pengeluaran</li>
                        <li><i class="ti ti-check text-success me-2"></i>Laporan keuangan bulanan dan analitik
                        </li>
                        <li><i class="ti ti-check text-success me-2"></i>Dashboard ringkasan keuangan real-time
                        </li>
                        <li><i class="ti ti-check text-success me-2"></i>Pengaturan profil dan preferensi
                            pengguna</li>
                        <li><i class="ti ti-check text-success me-2"></i>Antarmuka yang responsif dan
                            user-friendly</li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4 text-center">Tentang Developer</h5>
                <div class="row align-items-center">
                    <!-- Kolom kiri: Foto -->
                    <div class="col-md-4 text-center mb-3 mb-md-0">
                        <img src="{{ asset('assets/images/developer/developer.jpeg') }}" alt="Foto Developer"
                            class="img-fluid rounded" style="width: 100%; height: 300px; object-fit: cover;">
                    </div>

                    <!-- Kolom kanan: Judul dan teks panjang -->
                    <div class="col-md-8">
                        <h6 class="fw-semibold">Hilmy Washil</h6>
                        <p>Ia adalah seorang junior developer yang memiliki passion tinggi dan fondasi kuat dalam
                            pengembangan web. Perjalanannya dimulai dari rasa ingin tahu dalam menciptakan solusi digital,
                            yang kemudian berkembang menjadi komitmen untuk membangun aplikasi yang efisien dan mudah
                            digunakan. Dengan pengalaman di frontend maupun backend development, ia memiliki keahlian khusus
                            dalam Laravel dan React JS untuk mengembangkan aplikasi web yang responsif dan dinamis. Sebagai
                            seorang pembelajar cepat, ia mudah beradaptasi dengan berbagai tools dan teknologi baru serta
                            selalu bersemangat untuk meningkatkan keterampilan.</p>

                        <!-- Link sosial media -->
                        <div class="d-flex gap-3 mt-2">
                            <a href="https://github.com/hilmywashil" target="_blank" class="text-decoration-none">GitHub</a>
                            <a href="https://instagram.com/hilmywashil" target="_blank"
                                class="text-decoration-none">Instagram</a>
                            <a href="https://sociabuzz.com/hilmywashil/tribe" target="_blank"
                                class="text-decoration-none">Support Me</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection