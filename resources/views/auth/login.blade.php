<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - FinTrack</title>
    <link rel="apple-touch-icon" sizes="180x180" href=" apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ asset('assets/images/logos/logo.png') }}" width="180" alt="">
                                </a>
                                <p class="text-center">Teman Finansialmu.</p>
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required
                                            value="{{ old('email') }}">
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            required>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" name="remember"
                                                id="remember">
                                            <label class="form-check-label text-dark" for="remember">
                                                Ingat Saya
                                            </label>
                                        </div>

                                        <a class="text-primary fw-bold" href="{{ route('forgot.password') }}">
                                            Lupa Password ?
                                        </a>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">
                                        Login
                                    </button>

                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">Tidak punya Akun?</p>
                                        <a class="text-primary fw-bold ms-2" href="{{ route('register') }}">
                                            Buat Akun
                                        </a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(session('suspended'))
        <div class="modal fade" id="suspendedModal" tabindex="-1">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header text-white p-0">
                        <div class="w-100 bg-danger p-3 rounded-top text-center">
                            <h5 class="modal-title text-white">Akun Di-Suspend</h5>
                        </div>

                    </div>

                    <div class="modal-body text-center">
                        <i class="ti ti-alert-triangle text-danger" style="font-size: 50px;"></i>

                        <p class="mt-3">
                            <strong>{{ session('name') }}</strong>,
                            akun Anda telah di suspend karena adanya aktifitas tidak wajar atau pelanggaran ketentuan.
                        </p>

                        <p>
                            Hubungi Administrator untuk informasi lebih lanjut.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    @endif
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const notyf = new Notyf({
                position: { x: 'right', y: 'bottom' },
                duration: 3000,
                ripple: false,
                dismissible: true
            });

            @if (session('success'))
                notyf.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                notyf.error("{{ session('error') }}");
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    notyf.error("{{ $error }}");
                @endforeach
            @endif

    });
    </script>
    @if(session('suspended'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var modal = new bootstrap.Modal(
                    document.getElementById('suspendedModal')
                );

                modal.show();
            });
        </script>
    @endif

</body>

</html>