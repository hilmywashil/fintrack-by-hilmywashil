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
                <div class="mb-4">
                    <h5 class="card-title mb-1">Kirim Feedback</h5>
                    <p class="text-muted mb-0">
                        Sampaikan kritik, saran, atau masukan untuk pengembangan FinTrack.
                    </p>
                </div>

                {{-- ALERT SUCCESS --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- VALIDATION ERROR --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM --}}
                <form action="{{ route('feedback.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                        <input type="hidden" name="email" value="{{ auth()->user()->email }}">

                        <div class="col-12 mb-3">
                            <label class="form-label">Pesan</label>
                            <textarea name="message" class="form-control" rows="4" placeholder="Tulis pesan Anda di sini..."
                                required>{{ old('message') }}</textarea>
                        </div>

                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-send me-1"></i>
                            Kirim Feedback
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection