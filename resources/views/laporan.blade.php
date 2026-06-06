@extends('layouts.app')
@section('title', 'Laporan Proyek')

@section('content')
{{-- Tombol Cetak (Hanya muncul di layar, hilang saat diprint) --}}
<div class="d-flex justify-content-end mb-3 no-print">
    <a href="{{ route('laporan.pdf') }}" target="_blank" class="btn btn-danger fw-bold">
        <i class="bi bi-file-pdf"></i> Download PDF
    </a>
    <a href="{{ route('proyek.index') }}" class="btn btn-secondary ms-2">Kembali</a>
</div>

{{-- Area Dokumen Laporan --}}
<div class="card border-0 shadow-sm print-area">
    <div class="card-body p-5">
        {{-- Header Laporan --}}
        <div class="text-center mb-4 border-bottom pb-3">
            <h3 class="fw-bold mb-1">LAPORAN CATATAN PROYEK SISWA RPL</h3>
            <p class="text-muted mb-0">Sistem Informasi Manajemen Proyek Siswa</p>
        </div>

        {{-- Informasi Siswa --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td width="120" class="fw-semibold">Nama Siswa</td>
                        <td>: {{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Email</td>
                        <td>: {{ $user->email }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 text-md-end">
                <table class="table table-borderless table-sm ms-auto">
                    <tr>
                        <td class="fw-semibold text-end">Tanggal Cetak</td>
                        <td>: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</td>
                    </tr>
                </table>
            </div
        </div>

        {{-- Tabel Data Proyek --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Proyek</th>
                        <th>Jenis</th>
                        <th>Teknologi</th>
                        <th>Status</th>
                        <th width="12%">Tgl Mulai</th>
                        <th width="12%">Tgl Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proyeks as $index => $proyek)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $proyek->nama_proyek }}</td>
                        <td>{{ $proyek->jenis_proyek }}</td>
                        <td>{{ $proyek->teknologi }}</td>
                        <td class="text-center">{{ $proyek->status_proyek }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($proyek->tanggal_mulai)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            {{ $proyek->tanggal_selesai ? \Carbon\Carbon::parse($proyek->tanggal_selesai)->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Tidak ada data proyek untuk dicetak.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tanda Tangan (Opsional, menambah kesan profesional) --}}
        <div class="row mt-5">
            <div class="col-md-6 offset-md-6 text-center">
                <p>Diketahui oleh,</p>
                <br><br><br>
                <p class="fw-bold border-bottom d-inline-block pb-1">{{ $user->name }}</p>
                <p class="small text-muted">Siswa RPL</p>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS KHUSUS UNTUK CETAK (PRINT) */
    @media print {
        /* Setting kertas A4 Portrait */
        @page {
            size: A4 portrait;
            margin: 1.5cm 1cm;
        }
        
        /* Sembunyikan elemen yang tidak perlu */
        .no-print, .navbar, footer, .btn, .alert {
            display: none !important;
        }
        
        /* Reset card */
        .card, .print-area {
            box-shadow: none !important;
            border: none !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }
        
        body {
            background-color: white !important;
            color: black !important;
            font-size: 10pt !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Perkecil header */
        .print-area h3 {
            font-size: 14pt !important;
            margin-bottom: 5px !important;
        }
        
        .print-area .text-muted {
            font-size: 9pt !important;
        }
        
        /* Info siswa - perkecil */
        .print-area table.table-sm td {
            padding: 2px 4px !important;
            font-size: 10pt !important;
        }
        
        /* TABEL - LEBAR PENUH & MUAAT */
        .table-responsive {
            overflow: visible !important;
            width: 100% !important;
        }
        
        .table {
            font-size: 9pt !important;
            width: 100% !important;
            max-width: 100% !important;
            table-layout: fixed !important; /* Kunci lebar kolom */
            margin: 10px 0 !important;
            border-collapse: collapse !important;
        }
        
        .table th, .table td {
            padding: 6px 8px !important;
            vertical-align: middle !important;
            word-wrap: break-word !important;
            overflow: hidden !important;
            text-align: center !important;
        }
        
        /* Header tabel - font lebih kecil */
        .table th {
            font-size: 8.5pt !important;
            font-weight: bold !important;
            background-color: #343a40 !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        /* Atur lebar kolom spesifik (total 100%) */
        .table th:nth-child(1), .table td:nth-child(1) { width: 5%; }  /* No */
        .table th:nth-child(2), .table td:nth-child(2) { width: 27%; }  /* Nama Proyek */
        .table th:nth-child(3), .table td:nth-child(3) { width: 12%; }  /* Jenis */
        .table th:nth-child(4), .table td:nth-child(4) { width: 16%; }  /* Teknologi */
        .table th:nth-child(5), .table td:nth-child(5) { width: 10%; }  /* Status */
        .table th:nth-child(6), .table td:nth-child(6) { width: 15%; }  /* Tgl Mulai */
        .table th:nth-child(7), .table td:nth-child(7) { width: 15%; }  /* Tgl Selesai */
        
        /* Border tabel */
        .table-bordered {
            border: 1px solid #dee2e6 !important;
        }
        
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6 !important;
        }
        
        /* Tanda tangan */
        .mt-5 {
            margin-top: 2rem !important;
        }
    }
</style>
@endsection