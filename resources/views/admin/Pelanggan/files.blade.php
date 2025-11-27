@extends('layout-admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Files Pelanggan - {{ $pelanggan->first_name }} {{ $pelanggan->last_name }}
                        </h3>
                        <div>
                            <a href="{{ route('uploads', ['pelanggan_id' => $pelanggan->pelanggan_id]) }}"
                                class="btn btn-primary">
                                <i class="fas fa-upload"></i> Upload Files
                            </a>
                            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($files->count() > 0)
                            <div class="row">
                                @foreach ($files as $file)
                                    <div class="col-md-3 mb-4">
                                        <div class="card file-card">
                                            <div class="card-body text-center">
                                                @php
                                                    // File disimpan sebagai FULL PATH: "uploads/namafile.png"
                                                    $fileExists = \Storage::disk('public')->exists($file->filename);
                                                    $imageUrl = asset('storage/' . $file->filename);
                                                    $justFilename = basename($file->filename); // Hanya nama file tanpa folder
                                                @endphp

                                                @if (in_array(pathinfo($file->filename, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp']) && $fileExists)
                                                    <div class="image-preview mb-2">
                                                        <img src="{{ $imageUrl }}" class="img-fluid rounded"
                                                            alt="{{ $justFilename }}"
                                                            style="max-height: 150px; object-fit: cover; width: 100%; border: 1px solid #ddd;">
                                                    </div>
                                                @else
                                                    <div class="file-icon mb-2">
                                                        <i class="fas fa-file fa-3x text-secondary"></i>
                                                    </div>
                                                @endif

                                                <h6 class="file-name text-truncate" title="{{ $justFilename }}">
                                                    {{ $justFilename }}
                                                </h6>

                                                <small class="text-muted d-block">
                                                    {{ $file->created_at->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                            <div class="card-footer">
                                                <div class="btn-group w-100" role="group">
                                                    {{-- Tombol View --}}
                                                    <a href="{{ asset('storage/uploads/' . $file->filename) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary"
                                                        data-toggle="tooltip" title="Lihat File">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    {{-- Tombol Delete --}}
                                                    <form action="{{ route('uploads.destroy', $file->id) }}" method="POST"
                                                        style="display:inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Hapus file ini?')"
                                                            data-toggle="tooltip" title="Hapus File" Hapus>
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Belum ada files</h4>
                                <p class="text-muted">Silakan upload file pertama Anda</p>
                                <a href="{{ route('uploads', ['pelanggan_id' => $pelanggan->pelanggan_id]) }}"
                                    class="btn btn-primary mt-3">
                                    <i class="fas fa-upload"></i> Upload Files
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .file-card {
            transition: transform 0.2s ease-in-out;
            border: 1px solid #e3e6f0;
        }

        .file-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .file-name {
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .file-icon {
            color: #6c757d;
        }

        .btn-group .btn {
            border-radius: 0;
        }

        .btn-group .btn:first-child {
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }

        .btn-group .btn:last-child {
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
        }
    </style>
@endpush
