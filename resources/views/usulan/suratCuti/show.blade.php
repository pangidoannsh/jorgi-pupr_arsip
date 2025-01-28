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
                            <a href="{{ route('suratCuti.tolak', $model->id) }}" class="btn btn-outline-danger">
                                <i class="bi bi-x-lg"></i>
                                Tolak
                            </a>
                        @endif
                        @if ($model->status === 'menunggu')
                            <a href="{{ route('suratCuti.setujuiAdmin', $model->id) }}" class="btn btn-success">
                                <i class="bi bi-check-lg"></i>
                                Setujui
                            </a>
                        @elseif ($model->status === 'disetujui_admin' && $userRole === 'kepala_dinas')
                            <a href="{{ route('suratCuti.setujui', $model->id) }}" class="btn btn-success">
                                <i class="bi bi-check-lg"></i>
                                Setujui
                            </a>
                        @endif
                        @if ($userRole === 'admin')
                            <a href="{{ route('suratCuti.print', $model->id) }}" class="btn btn-primary"
                                style="width: max-content" target="_blank">
                                <i class="bi bi-printer-fill"></i>
                                Cetak
                            </a>
                        @endif
                    </div>
                @endif
                <h4 class="card-title mb-4 text-center">Detail Surat Cuti</h4>
                <div class="row mb-3">
                    <div class="col-4"><strong>Pengaju </strong></div>
                    <div class="col-8">: {{ $model->pengaju?->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Jenis Cuti </strong></div>
                    <div class="col-8">: {{ $model->jenis_cuti }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Lama Cuti </strong></div>
                    <div class="col-8">: {{ $model->lama_cuti }} hari</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Tanggal Mulai </strong></div>
                    <div class="col-8">: {{ Carbon::parse($model->tanggal_mulai)->format('d F Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Alasan Cuti </strong></div>
                    <div class="col-8">: {{ $model->alasan_cuti }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Status </strong></div>
                    <div class="col-8">:
                        @if ($model->status === 'menunggu')
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif ($model->status === 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @elseif ($model->status === 'disetujui_admin')
                            <span class="badge bg-primary">Disetujui Admin</span>
                        @elseif ($model->status === 'disetujui')
                            <span class="badge bg-success">Cuti Disetujui</span>
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
