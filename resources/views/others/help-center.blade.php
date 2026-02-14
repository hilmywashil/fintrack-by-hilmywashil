@extends('layouts.main')

@section('title', 'Pusat Bantuan - FinTrack')

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
                            Pusat Bantuan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- CARD UTAMA --}}
        <div class="card">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="mb-4">
                    <h5 class="card-title mb-1">Butuh Bantuan?</h5>
                    <p class="text-muted mb-0">
                        Hubungi developer untuk mendapatkan bantuan lebih lanjut.
                    </p>
                </div>

                {{-- CTA WHATSAPP --}}
                <div
                    class="alert alert-success d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
                    <div>
                        <strong>Hubungi via WhatsApp</strong>
                        <div class="small text-muted">
                            Klik tombol di samping untuk memulai chat dengan developer.
                        </div>
                    </div>

                    <a href="https://wa.me/6283853371584" target="_blank" class="btn btn-success">
                        <i class="ti ti-brand-whatsapp me-1"></i>
                        Chat Sekarang
                    </a>
                </div>

                {{-- FAQ SECTION --}}
                <h6 class="mb-3">Pertanyaan Umum (FAQ)</h6>

                <div class="accordion" id="faqAccordion">

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq1">
                                Bagaimana cara menambahkan pemasukan?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Masuk ke menu Pemasukan, klik tombol Tambah Data,
                                isi form yang tersedia lalu simpan.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq2">
                                Bagaimana cara reset password?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Klik menu Profil > Ubah Password,
                                lalu masukkan password lama dan password baru.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq3">
                                Kenapa data tidak muncul di dashboard?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Pastikan filter tanggal sesuai dan data sudah berhasil disimpan.
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection