@extends('pdf.template')
@php
    $tembusan = $model->tembusan;
    use Carbon\Carbon;
@endphp
@section('content')
    <style>
        .ttd {
            margin-top: 24px;
            padding-left: 64px;
        }
    </style>
    <div>Dengan Hormat,</div>
    <div style="margin-top: 12px">Bersama ini kami sampaikan bahwa:</div>
    <table>
        <tr>
            <td style="width: 90px">Nama</td>
            <td>: {{ $model->pengaju->name }}</td>
        </tr>
        <tr>
            <td style="width: 90px">NIP</td>
            <td>: {{ $model->pengaju->nip }}</td>
        </tr>
        <tr>
            <td style="width: 90px">Jabatan</td>
            <td>: {{ $model->pengaju->jabatan }}</td>
        </tr>
        <tr>
            <td style="width: 90px">Unit Kerja</td>
            <td>: {{ $model->pengaju->unit->nama }}</td>
        </tr>
    </table>
    <div style="margin-top: 8px">
        Dengan ini mengajukan permohonan izin Cuti selama
        {{ $model->lama_cuti }} hari, mulai dari
        {{ Carbon::parse($model->tanggal_mulai)->locale('id_ID')->isoFormat('D MMMM Y') }}
        sampai dengan
        {{ Carbon::parse($model->tanggal_mulai)->locale('id_ID')->isoFormat('D MMMM Y') }}. Permohonan izin ini
        diajukan
        untuk {{ $model->alasan_cuti }}.
    </div>
    <div style="margin-top: 8px">
        Atas perhatian dann kebijaksanaan yang diberikan, saya ucapkan terima kasih.
    </div>
    <table style="width: 100%">
        <tr>
            <td style="width: 100%"></td>
            <td style="width: 100%"></td>
            <td style="width: 100%">
                <div class="ttd">
                    <div>Hormat kami,</div>
                    <div>{{ $model->pengaju->name }}</div>
                    <div>{{ $model->pengaju->jabatan }}</div>
                    <div style="height: 64px">
                        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path($model->pengaju->ttd))) }}"
                            style="height: 100%">
                    </div>
                    <div>{{ $model->pengaju->name }}</div>
                    <div>{{ $model->pengaju->nip }}</div>
                </div>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="width: 100%">
                @include('pdf.tembusan')
            </td>
            <td style="width: 100%">
                <div style="float: right">
                    <img src="data:img/png;base64, {!! $qrCode !!}">
                </div>
            </td>
        </tr>
    </table>
@endsection
