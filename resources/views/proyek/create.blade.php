@extends('layouts.app')
@section('title', 'Tambah Proyek')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-plus-circle"></i> Tambah Proyek Baru</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('proyek.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_proyek" class="form-label fw-semibold">Nama Proyek</label>
                            <input type="text" class="form-control @error('nama_proyek') is-invalid @enderror" id="nama_proyek" name="nama_proyek" value="{{ old('nama_proyek') }}" required>
                            @error('nama_proyek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jenis_proyek" class="form-label fw-semibold">Jenis Proyek</label>
                            <select class="form-select @error('jenis_proyek') is-invalid @enderror" id="jenis_proyek" name="jenis_proyek" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Web" {{ old('jenis_proyek') == 'Web' ? 'selected' : '' }}>Website</option>
                                <option value="Mobile" {{ old('jenis_proyek') == 'Mobile' ? 'selected' : '' }}>Aplikasi Mobile</option>
                                <option value="Desktop" {{ old('jenis_proyek') == 'Desktop' ? 'selected' : '' }}>Aplikasi Desktop</option>
                                <option value="UI Design" {{ old('jenis_proyek') == 'UI Design' ? 'selected' : '' }}>UI/UX Design</option>
                            </select>
                            @error('jenis_proyek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="teknologi" class="form-label fw-semibold">Teknologi</label>
                            <input type="text" class="form-control @error('teknologi') is-invalid @enderror" id="teknologi" name="teknologi" value="{{ old('teknologi') }}" placeholder="Contoh: Laravel, Flutter, React" required>
                            @error('teknologi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status_proyek" class="form-label fw-semibold">Status Proyek</label>
                            <select class="form-select @error('status_proyek') is-invalid @enderror" id="status_proyek" name="status_proyek" required>
                                <option value="Perencanaan" {{ old('status_proyek') == 'Perencanaan' ? 'selected' : '' }}>Perencanaan</option>
                                <option value="Proses" {{ old('status_proyek') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Revisi" {{ old('status_proyek') == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                                <option value="Selesai" {{ old('status_proyek') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status_proyek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                            @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai (Opsional)</label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
                            @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi Proyek</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('proyek.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Proyek</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection