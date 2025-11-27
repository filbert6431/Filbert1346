{{-- start main content --}}
@extends('layout-admin.app')
@section('content')
    <main>
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
                    <li class="breadcrumb-item"><a href="#">Pelanggan</a></li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Data Pelanggan</h1>
                    <p class="mb-0">List data seluruh pelanggan</p>
                </div>
                <div>
                    <a href="{{ route('pelanggan.create') }}" class="btn btn-success text-white"><i
                            class="far fa-question-circle me-1"></i> Tambah Pelanggan</a>
                </div>
            </div>
        </div>
        {{-- info session update --}}
        @if (session('update'))
            <div class="alert alert-info">
                {!! session('update') !!}
            </div>
        @endif

        {{-- info session destroy --}}
        @if (session('destroy'))
            <div class="alert alert-info">
                {!! session('destroy') !!}
            </div>
        @endif

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <form method="GET" action="{{ route('pelanggan.index') }}" class="mb-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select name="gender" class="form-select" onchange="this.form.submit()">
                                                <option value="">All</option>
                                                <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="Female"
                                                    {{ request('gender') == 'Female' ? 'selected' : '' }}>
                                                    Female</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" name="search" class="form-control"
                                                    id="exampleInputIconRight" value="{{ request('search') }}"
                                                    placeholder="Search" aria-label="Search">
                                                <button type="submit" class="input-group-text" id="basic-addon2">
                                                    @if (request('search'))
                                                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                                                            class="btn btn-outline-secondary ml-3" id="clear-search">
                                                            Clear</a>
                                                    @endif
                                                    <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <table id="table-pelanggan" class="table table-centered table-nowrap mb-0 rounded">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-0">First Name</th>
                                            <th class="border-0">Last Name</th>
                                            <th class="border-0">Birthday</th>
                                            <th class="border-0">Gender</th>
                                            <th class="border-0">Email</th>
                                            <th class="border-0">Phone</th>
                                            <th class="border-0">Files</th>
                                            <th class="border-0 rounded-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataPelanggan as $item)
                                            <tr>
                                                <td>{{ $item->first_name }}</td>
                                                <td>{{ $item->last_name }}</td>
                                                <td>{{ $item->birthday }}</td>
                                                <td>{{ $item->gender }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td style="max-width: 200px;">
                                                    @php
                                                        $pelangganFiles = \App\Models\Multipleupload::where(
                                                            'ref_table',
                                                            'pelanggan',
                                                        )
                                                            ->where('ref_id', $item->pelanggan_id)
                                                            ->get();
                                                    @endphp

                                                    @if ($pelangganFiles->count())
                                                        <div class="file-attachments">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <span class="badge bg-primary rounded-pill me-2">
                                                                    {{ $pelangganFiles->count() }} file(s)
                                                                </span>
                                                                <a href="{{ route('pelanggan.files', $item->pelanggan_id) }}"
                                                                    class="btn btn-sm btn-outline-primary py-0 px-2">
                                                                    <small>Lihat Semua</small>
                                                                </a>
                                                            </div>

                                                            <div class="file-preview-list">
                                                                @foreach ($pelangganFiles->take(2) as $file)
                                                                    <div
                                                                        class="file-preview-item d-flex align-items-center justify-content-between mb-1 p-1 rounded bg-light">
                                                                        <div class="d-flex align-items-center">
                                                                            @if (in_array(pathinfo($file->filename, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                                                                                <i
                                                                                    class="fas fa-image text-success me-2"></i>
                                                                            @elseif(pathinfo($file->filename, PATHINFO_EXTENSION) == 'pdf')
                                                                                <i
                                                                                    class="fas fa-file-pdf text-danger me-2"></i>
                                                                            @else
                                                                                <i
                                                                                    class="fas fa-file text-secondary me-2"></i>
                                                                            @endif
                                                                            <small class="text-truncate"
                                                                                style="max-width: 120px;"
                                                                                title="{{ $file->filename }}">
                                                                                {{ $file->filename }}
                                                                            </small>
                                                                        </div>
                                                                        <div class="file-actions">
                                                                            <a href="{{ asset('storage/uploads/' . $file->filename) }}"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-link text-primary p-0 me-1"
                                                                                title="Lihat">
                                                                                <i class="fas fa-eye fa-xs"></i>
                                                                            </a>
                                                                            <a href="{{ asset('storage/uploads/' . $file->filename) }}"
                                                                                download
                                                                                class="btn btn-sm btn-link text-success p-0"
                                                                                title="Download">
                                                                                <i class="fas fa-download fa-xs"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach

                                                                @if ($pelangganFiles->count() > 2)
                                                                    <div class="text-center mt-1">
                                                                        <small class="text-muted">
                                                                            +{{ $pelangganFiles->count() - 2 }} file
                                                                            lainnya
                                                                        </small>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="text-center">
                                                            <span class="badge bg-secondary rounded-pill">No files</span>
                                                            <div class="mt-1">
                                                                <a href="{{ route('uploads', ['pelanggan_id' => $item->pelanggan_id]) }}"
                                                                    class="btn btn-sm btn-outline-success py-0 px-2">
                                                                    <small>Upload</small>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('pelanggan.edit', $item->pelanggan_id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <svg class="icon icon-xs me-1" data-slot="icon" fill="none"
                                                        stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10">
                                                        </path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('pelanggan.destroy', $item->pelanggan_id) }}"
                                                    method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <svg class="icon icon-xs me-1" data-slot="icon" fill="none"
                                                            stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0">
                                                            </path>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $dataPelanggan->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    {{-- end main content --}}

    <style>
        .file-attachments {
            font-size: 0.8rem;
        }

        .file-preview-list {
            max-height: 120px;
            overflow-y: auto;
        }

        .file-preview-item {
            border: 1px solid #e3e6f0;
            transition: all 0.2s ease;
        }

        .file-preview-item:hover {
            background-color: #f8f9fa;
            border-color: #b7b9cc;
        }

        .file-actions {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .file-preview-item:hover .file-actions {
            opacity: 1;
        }

        .btn-group .btn {
            margin-right: 5px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }
    </style>
@endsection
