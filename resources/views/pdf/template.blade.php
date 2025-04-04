<!DOCTYPE html>
@php
    use Carbon\Carbon;
@endphp

<head>
    <title>Surat</title>
    <style>
        body {
            padding-left: 26px;
            padding-right: 26px;
        }
    </style>
</head>

<body>
    @include('pdf.kop')
    <div style="text-align: right;margin-top:28px;padding-right:24px ">
        Pekanbaru,{{ Carbon::now()->isoFormat('D MMMM Y') }}</div>
    <table>
        <tr>
            <td style="width: 90px">Nomor</td>
            <td style="line-height: 1.7">: </td>
        </tr>
        <tr>
            <td style="width: 90px">Lampiran</td>
            <td style="line-height: 1.7">: </td>
        </tr>
        <tr>
            <td style="width: 90px">Perihal</td>
            <td style="line-height: 1.7;font-weight: bold">: {{ $perihal }}</td>
        </tr>
    </table>
    <div style="font-weight: bold;margin-top: 24px;margin-bottom: 16px">
        Kepada Yth,<br>
        {{ $model->ditujukan?->user?->name ?? '' }}<br>
        {{ $model->ditujukan?->nama ?? '' }}<br>
        di tempat
    </div>
    @yield('content')
</body>

</html>
