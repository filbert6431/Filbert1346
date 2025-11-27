@extends('layout-admin.app')

@section('content')

<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="#">
                    <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="#">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail User</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Detail User</h1>
            <p class="mb-0">Informasi lengkap user.</p>
        </div>
        <div>
            <a href="{{ route('user.index') }}" class="btn btn-primary">
                Kembali
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card border-0 shadow mb-4">
            <div class="card-body text-center">

                {{-- FOTO PROFIL --}}
                @if($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}"
                         width="120" height="120"
                         style="object-fit:cover; border-radius:50%; border:3px solid #ddd;">
                @else
                    <img src="https://via.placeholder.com/120"
                         class="rounded-circle mb-3" alt="No Image">
                @endif

                <h3 class="mt-3">{{ $user->name }}</h3>
                <p class="text-muted">{{ $user->email }}</p>

                <hr>

                <div class="text-start px-4">
                    <p><strong>Nama Lengkap:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Password (hash):</strong> {{ $user->password }}</p>
                </div>

                <hr>

                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info w-100 mb-2">Edit User</a>

                <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger w-100">Hapus User</button>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
