<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        @include('layouts.partials.sidebar')
        <div class="body-wrapper">
            @if(session('admin_id'))
                <div class="bg-dark text-white py-2 px-4 d-flex justify-content-between align-items-center position-sticky top-0"
                    style="z-index: 10;">
                    <div>
                        Logged in as {{ Auth::user()->name }}
                    </div>
                    <form method="POST" action="{{ route('admin.users.login-as-back') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">
                            Back to Admin
                        </button>
                    </form>
                </div>
            @endif

            @include('layouts.partials.header')
            <div class="container-fluid">
                @yield('content')
                <div class="py-6 px-6 text-center">
                    <p class="mb-0 fs-4">Made with <i class="ti ti-heart text-danger ms-1 me-1"></i> by Hilmy Washil
                    </p>
                </div>
            </div>
        </div>
    </div>
    @if(session('welcome_popup'))
        <!-- POPUP MODAL -->
        <div class="modal fade" id="welcomePopup" tabindex="-1" aria-labelledby="welcomePopupLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow text-center">
                    <div class="modal-body py-5">
                        {{-- Ilustrasi robot --}}
                        <img src="{{ asset('assets/images/robot.svg') }}" alt="Robot" class="mb-4" style="max-width:150px;">

                        <h5 class="fw-semibold mb-3">Selamat Datang!</h5>
                        <p class="text-muted mb-4">
                            Aplikasi saat ini masih dalam tahap akses awal.<br>
                            Beri feedback agar aplikasi bisa lebih baik!
                        </p>

                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="{{ route('feedback.index') }}" class="btn btn-primary">Beri Feedback</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var welcomeModal = new bootstrap.Modal(document.getElementById('welcomePopup'));
            welcomeModal.show();
        });
    </script>
    <script>
        tippy('[data-tippy-content]', {
            placement: 'top',
            animation: 'scale',
            theme: 'light',
        });
    </script>
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
    <script>
        function confirmReset() {
            Swal.fire({
                title: 'Hapus Semua Data?',
                text: "Semua catatan keuangan akan dihapus dan saldo direset menjadi 0!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('resetForm').submit();
                }
            })
        }
    </script>
</body>

</html>