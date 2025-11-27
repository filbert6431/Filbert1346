{{-- resources/views/multipleuploads.blade.php --}}
@extends('layout-admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('Upload Multiple Files') }}</h4>
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali ke Pelanggan
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan:
                            <ul class="mb-0 mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('uploads.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Hidden fields untuk ref_table dan ref_id -->
                        <input type="hidden" name="ref_table" value="pelanggan">
                        <input type="hidden" name="ref_id" value="{{ request('pelanggan_id') }}">

                        <div class="form-group">
                            <label for="pelanggan_info">Pelanggan</label>
                            <input type="text" class="form-control" value="{{ $pelanggan->first_name }} {{ $pelanggan->last_name }} (ID: {{ $pelanggan->pelanggan_id }})" readonly>
                            <small class="form-text text-muted">File akan dikaitkan dengan pelanggan ini</small>
                        </div>

                        <div class="form-group">
                            <label for="files">Pilih Files</label>
                            <div class="custom-file">
                                {{-- PERBAIKAN: name="files[]" bukan name="filename[]" --}}
                                <input type="file"
                                       class="custom-file-input @error('files.*') is-invalid @enderror"
                                       id="files"
                                       name="files[]"
                                       multiple
                                       required
                                       accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt">
                                <label class="custom-file-label" for="files" id="fileLabel">
                                    Pilih satu atau multiple files
                                </label>
                                @error('files.*')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                Format: images, PDF, Word, Excel. Maksimal 2MB per file.
                            </small>
                        </div>

                        <div class="form-group">
                            <div id="filePreview" class="mt-3"></div>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-upload"></i> {{ __('Upload Files') }}
                            </button>
                            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
