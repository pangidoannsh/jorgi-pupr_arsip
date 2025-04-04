@php
    use Carbon\Carbon;
    $userRole = Auth::user()->role;
@endphp
@extends('layouts.main')
@section('content')
    <a href="{{ route('usulan.index') }}" class="btn btn-primary mb-3" style="width: max-content">Kembali</a>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm p-4 rounded">
                @if ($userRole != 'user')
                    <div class="d-flex justify-content-end" style="gap: 12px">
                        @if (
                            ($userRole === 'admin' && $model->status === 'menunggu') ||
                                ($userRole === 'kepala_dinas' && $model->status === 'disetujui_admin'))
                            <button id="btnTolak" data-id="{{ $model->id }}" class="btn btn-outline-danger">
                                <i class="bi bi-x-lg"></i>
                                Tolak
                            </button>
                        @endif
                        @if ($model->status === 'menunggu')
                            <a href="{{ route('suratPengantar.setujuiAdmin', $model->id) }}" class="btn btn-success">
                                <i class="bi bi-check-lg"></i>
                                Setujui
                            </a>
                        @elseif ($model->status === 'disetujui_admin' && $userRole === 'kepala_dinas')
                            <a href="{{ route('suratPengantar.setujui', $model->id) }}" class="btn btn-success">
                                <i class="bi bi-check-lg"></i>
                                Setujui
                            </a>
                        @endif
                        @if ($userRole === 'admin' && ($model->status === 'disetujui_admin' || $model->status === 'disetujui'))
                            <a href="{{ route('suratPengantar.print', $model->id) }}" class="btn btn-primary"
                                style="width: max-content" target="_blank">
                                <i class="bi bi-printer-fill"></i>
                                Cetak
                            </a>
                        @endif
                    </div>
                @endif
                <h4 class="card-title mb-4 text-center">Detail Surat Pengantar</h4>
                <div class="row mb-3">
                    <div class="col-4"><strong>Pengaju </strong></div>
                    <div class="col-8">: {{ $model->pengaju?->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Keperluan</strong></div>
                    <div class="col-8">: {{ $model->keperluan }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Lokasi Kegiatan</strong></div>
                    <div class="col-8">: {{ $model->lokasi_kegiatan }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Diajukan Kepada</strong></div>
                    <div class="col-8">: {{ $model->ditujukan?->user?->name }} ({{ $model->ditujukan?->nama }})</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <div>
                            <strong>Status </strong>
                        </div>
                        @if ($model->status === 'ditolak')
                            <div class="text-danger">
                                <strong>Alasan Ditolak </strong>
                            </div>
                        @endif
                    </div>
                    <div class="col-8">:
                        @if ($model->status === 'menunggu')
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif ($model->status === 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @elseif ($model->status === 'disetujui_admin')
                            <span class="badge bg-primary">Disetujui Admin</span>
                        @elseif ($model->status === 'disetujui')
                            <span class="badge bg-success">Surat Pengantar Disetujui</span>
                        @endif
                        @if ($model->status === 'ditolak')
                            <div class="text-danger">
                                <span class="text-black">:</span> {{ $model->alasan_ditolak }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-md-6">
                        <div><strong>File Lampiran </strong></div>
                        @if ($model->lampiran)
                            <a href="{{ asset($model->lampiran) }}" class="btn btn-primary btn-sm" target="_blank">
                                Lihat File
                            </a>
                        @else
                            <span>Tidak ada lampiran.</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3 mt-3">
                    <div class="col-4"><strong>Tembusan </strong></div>
                    @if ($model->tembusan && count($model->tembusan) > 0)
                        <ol class="ms-4">
                            @foreach ($model->tembusan as $tembusan)
                                <li>{{ $tembusan->user->name }}</li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $("#btnTolak").click(function() {
            let id = $(this).data("id");
            Swal.fire({
                title: 'Tolak Pengajuan Surat Pengantar',
                text: "Masukkan alasan penolakan:",
                input: 'textarea',
                inputPlaceholder: "Tulis alasan penolakan di sini...",
                inputAttributes: {
                    'aria-label': 'Tulis alasan penolakan'
                },
                showCancelButton: true,
                confirmButtonText: 'Tolak',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Anda harus mengisi alasan penolakan!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let alasan = encodeURIComponent(result.value);
                    window.location.href = `/usulan/surat-pengantar/${id}/tolak?alasan_ditolak=${alasan}`;
                }
            });
        });
    </script>
@endpush
