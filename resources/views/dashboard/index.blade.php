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
                        <p class="mb-0">Selamat datang kembali! Kelola keuanganmu disini.</p>
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
    <div class="row">
        <div class="col-12">
            <h5 class="card-title fw-semibold mb-4">Barang Wishlist</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="card overflow-hidden rounded-2">
                <div class="position-relative">
                    <a href="javascript:void(0)"><img src="../assets/images/products/s4.jpg" class="card-img-top rounded-0"
                            alt="..."></a>
                    <a href="javascript:void(0)"
                        class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i
                            class="ti ti-basket fs-4"></i></a>
                </div>
                <div class="card-body pt-3 p-4">
                    <h6 class="fw-semibold fs-4">Boat Headphone</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-semibold fs-4 mb-0">$50</h6>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card overflow-hidden rounded-2">
                <div class="position-relative">
                    <a href="javascript:void(0)"><img src="../assets/images/products/s5.jpg" class="card-img-top rounded-0"
                            alt="..."></a>
                    <a href="javascript:void(0)"
                        class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i
                            class="ti ti-basket fs-4"></i></a>
                </div>
                <div class="card-body pt-3 p-4">
                    <h6 class="fw-semibold fs-4">MacBook Air Pro</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-semibold fs-4 mb-0">$650</h6>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card overflow-hidden rounded-2">
                <div class="position-relative">
                    <a href="javascript:void(0)"><img src="../assets/images/products/s7.jpg" class="card-img-top rounded-0"
                            alt="..."></a>
                    <a href="javascript:void(0)"
                        class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i
                            class="ti ti-basket fs-4"></i></a>
                </div>
                <div class="card-body pt-3 p-4">
                    <h6 class="fw-semibold fs-4">Red Valvet Dress</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-semibold fs-4 mb-0">$150</h6>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card overflow-hidden rounded-2">
                <div class="position-relative">
                    <a href="javascript:void(0)"><img src="../assets/images/products/s11.jpg" class="card-img-top rounded-0"
                            alt="..."></a>
                    <a href="javascript:void(0)"
                        class="bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i
                            class="ti ti-basket fs-4"></i></a>
                </div>
                <div class="card-body pt-3 p-4">
                    <h6 class="fw-semibold fs-4">Cute Soft Teddybear</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-semibold fs-4 mb-0">$285</h6>

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