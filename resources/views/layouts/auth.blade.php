<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - FinTrack</title>

    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
</head>

<body>

    <div class="page-wrapper min-vh-100 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card">
                        <div class="card-body">

                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/images/logos/logo.png') }}" width="180">
                            </div>

                            @yield('content')

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

            @if(session('success'))
                notyf.success("{{ session('success') }}");
            @endif

            @if(session('error'))
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