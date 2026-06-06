@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-primary mb-1">Dashboard</h2>
        <p class="text-muted mb-0">Selamat datang kembali, <strong>{{ $user->name }}</strong>!</p>
    </div>
</div>

<!-- Kartu Statistik -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Total Proyek</p>
                        <h3 class="fw-bold mb-0">{{ $totalProyek }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                        <i class="bi bi-folder-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Perencanaan</p>
                        <h3 class="fw-bold mb-0 text-warning">{{ $statusPerencanaan }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                        <i class="bi bi-lightbulb-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Proses / Revisi</p>
                        <h3 class="fw-bold mb-0 text-info">{{ $statusProsesRevisi }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info p-3 rounded-3">
                        <i class="bi bi-gear-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Selesai</p>
                        <h3 class="fw-bold mb-0 text-success">{{ $statusSelesai }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 5 Proyek Terbaru -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <h5 class="fw-bold mb-0"><i class="bi bi-clock-history text-primary"></i> 5 Proyek Terbaru Anda</h5>
    </div>
    <div class="card-body px-4 pb-4">
        @if($proyekTerbaru->isEmpty())
            <div class="text-center py-4">
                <i class="bi bi-inbox display-4 text-muted"></i>
                <p class="text-muted mt-2">Anda belum memiliki proyek. Mulai tambahkan proyek pertama Anda!</p>
                <a href="{{ route('proyek.index') }}" class="btn btn-primary mt-2">Kelola Proyek</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Proyek</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Tanggal Mulai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proyekTerbaru as $proyek)
                        <tr>
                            <td class="fw-semibold">{{ $proyek->nama_proyek }}</td>
                            <td>{{ $proyek->jenis_proyek }}</td>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('proyek.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua Proyek <i class="bi bi-arrow-right"></i></a>
            </div>
        @endif
    </div>
</div>
@endsection