@extends('layouts.main')

@section('title', 'Tambah Transaksi - FinTrack')

@section('content')

    @php use Illuminate\Support\Str; @endphp

    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">

                    <h5 class="card-title fw-semibold mb-4">
                        Semua Pengguna ({{ $users->total() }})
                        @if(request('role'))
                            - {{ ucfirst(request('role')) }}
                        @endif
                    </h5>

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <form method="GET" class="d-flex gap-2 align-items-center">

                            <select name="role" class="form-select">
                                <option value="">All Role</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>
                                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>
                                    User
                                </option>
                            </select>

                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>
                                    Suspended
                                </option>
                            </select>

                            <button type="submit" class="btn btn-primary">
                                Filter
                            </button>

                            @if(request('role') || request('status'))
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    Reset
                                </a>
                            @endif

                        </form>

                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>

                                    <th>
                                        <h6 class="fw-semibold mb-0">Foto</h6>
                                    </th>

                                    <th>
                                        <h6 class="fw-semibold mb-0">Nama</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Role</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Status</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Tanggal Register</h6>
                                    </th>
                                    <th>
                                        <h6 class="fw-semibold mb-0">Action</h6>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>
                                            <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                        </td>

                                        <td>
                                            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/images/profile/user-1.png') }}"
                                                class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                        </td>

                                        <td>
                                            <h6 class="fw-semibold mb-1" data-tippy-content="{{ $user->name }}">
                                                {{ Str::limit($user->name, 20) }}
                                            </h6>
                                            <p class="text-muted small mb-0">{{ $user->email }}</p>
                                        </td>
                                        <td>
                                            <span class="badge {{ $user->role == 'admin' ? 'bg-primary' : 'bg-secondary' }} ">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->is_suspended)
                                                <span class="badge bg-danger ">Suspended</span>
                                            @else
                                                <span class="badge bg-success">Active</span>
                                            @endif
                                        </td>

                                        <td>
                                            <p class="mb-0 fw-normal">
                                                {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                            </p>
                                        </td>
                                        <td class="position-static">
                                            @if(Auth::id() != $user->id)

                                                <div class="dropdown position-static">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>

                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form method="POST"
                                                                action="{{ route('admin.users.login-as', $user->id) }}">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item">
                                                                    Login as {{ strtok($user->name, ' ') }}
                                                                </button>
                                                            </form>
                                                        </li>

                                                        <li>
                                                            <form method="POST"
                                                                action="{{ route('admin.users.toggle-suspend', $user->id) }}">
                                                                @csrf
                                                                @method('PUT')

                                                                @if($user->is_suspended)
                                                                    <button type="submit" class="dropdown-item text-success">
                                                                        Unsuspend
                                                                    </button>
                                                                @else
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        Suspend
                                                                    </button>
                                                                @endif
                                                            </form>
                                                        </li>

                                                        <li>
                                                            <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure want to delete this user?')">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    Delete User
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>

                                            @else
                                                <span class="text-muted">Current User</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if ($users->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-3">

                                <div class="text-muted small">
                                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }}
                                    dari {{ $users->total() }} pengguna
                                </div>

                                <nav>
                                    <ul class="pagination mb-0">

                                        <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $users->previousPageUrl() ?? '#' }}">
                                                <i class="ti ti-chevron-left"></i>
                                            </a>
                                        </li>

                                        @foreach ($users->links()->elements[0] as $page => $url)
                                            <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $users->nextPageUrl() ?? '#' }}">
                                                <i class="ti ti-chevron-right"></i>
                                            </a>
                                        </li>

                                    </ul>
                                </nav>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection