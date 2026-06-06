@extends('layouts.app')
@section('title', 'Daftar Proyek')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-primary mb-1">Daftar Proyek Saya</h2>
        <p class="text-muted mb-0">Kelola semua proyek RPL yang telah Anda kerjakan.</p>
    </div>
    <a href="{{ route('proyek.create') }}" class="btn btn-primary fw-bold">
        <i class="bi bi-plus-circle"></i> Tambah Proyek
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        @if($proyeks->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-folder2-open display-1 text-muted"></i>
                <h5 class="mt-3 text-muted">Belum ada proyek</h5>
                <p class="text-muted">Klik tombol "Tambah Proyek" untuk memulai mencatat proyek pertama Anda.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Proyek</th>
                            <th>Jenis</th>
                            <th>Teknologi</th>
                            <th width="12%">Status</th>
                            <th width="12%">Tgl Mulai</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proyeks as $index => $proyek)
                        <tr>
                            <td>{{ $proyeks->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-semibold">{{ $proyek->nama_proyek }}</div>
                                <small class="text-muted">{{ Str::limit($proyek->deskripsi, 50) }}</small>
                            </td>
                            <td>{{ $proyek->jenis_proyek }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $proyek->teknologi }}</span></td>
                            <td>
                                @php
                                    $badgeClass = 'secondary';
                                    if($proyek->status_proyek == 'Perencanaan') $badgeClass = 'warning';
                                    elseif(in_array($proyek->status_proyek, ['Proses', 'Revisi'])) $badgeClass = 'info';
                                    elseif($proyek->status_proyek == 'Selesai') $badgeClass = 'success';
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ $proyek->status_proyek }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($proyek->tanggal_mulai)->format('d M Y') }}</td>
                            <td class="text-center">
                                <!-- Tombol Edit & Hapus (Aksi belum berfungsi penuh, akan aktif di Tahap 4) -->
                                <a href="{{ route('proyek.edit', $proyek->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('proyek.destroy', $proyek->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus proyek ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-center">
                {{ $proyeks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection