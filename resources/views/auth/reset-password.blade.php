<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - FinTrack</title>

    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">

                                <h5 class="text-center mb-3">Buat Password Baru</h5>

                                <p class="text-center text-muted">
                                    Silakan masukkan password baru untuk akun Anda.
                                </p>

                                <form action="{{ route('reset.password') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Password Baru</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            required>
                                    </div>

                                    <button class="btn btn-primary w-100 py-8 fs-4 mb-3 rounded-2">
                                        Simpan Password
                                    </button>

                                    <div class="text-center">
                                        <a href="{{ route('login') }}" class="text-primary fw-bold">
                                            Kembali ke Login
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

</body>

</html>