@php
    use Carbon\Carbon;
@endphp
@extends('layouts.main')
@section('content')
    <a href="{{ route('arsip.index') }}" class="btn btn-primary mb-3" style="width: max-content">Kembali</a>
    <div class="row justify-content-center mt-4">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm p-4 rounded">
                <h4 class="card-title mb-4 text-center">Detail Arsip</h4>
                <div class="row mb-3">
                    <div class="col-4"><strong>Kode Klasifikasi:</strong></div>
                    <div class="col-8">{{ $model->klasifikasi->nama }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Nomor Berkas:</strong></div>
                    <div class="col-8">{{ $model->nomor_berkas }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Nomor Arsip:</strong></div>
                    <div class="col-8">{{ $model->nomor_arsip }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Uraian Informasi Arsip:</strong></div>
                    <div class="col-8">{{ $model->uraian_informasi }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Kurun Waktu:</strong></div>
                    <div class="col-8">{{ Carbon::parse($model->tanggal_mulai)->format('d F Y') }} -
                        {{ Carbon::parse($model->tanggal_selesai)->format('d F Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Jumlah:</strong></div>
                    <div class="col-8">{{ $model->jumlah }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Tingkat Perkembangan:</strong></div>
                    <div class="col-8">{{ $model->tingkat_perkembangan }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Keterangan Nomor Box:</strong></div>
                    <div class="col-8">{{ $model->keterangan_nomor_box }}</div>
                </div>

                <div class="mt-4">
                    <div class="fw-semibold">File</div>
                    <hr>
                </div>

                <div class="row mt-1">
                    @if ($model->file)
                        <div class="col-md-6 mb-3">
                            <div><strong>File Upload:</strong></div>
                            <a href="{{ asset($model->file) }}" class="btn btn-primary btn-sm" target="_blank">
                                Lihat File
                            </a>
                        </div>
                    @endif
                    @if ($model->url_file)
                        <div class="col-md-6">
                            <div><strong>File URL:</strong></div>
                            <a href="{{ $model->url_file }}" class="btn btn-primary btn-sm" target="_blank">
                                Lihat File
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
