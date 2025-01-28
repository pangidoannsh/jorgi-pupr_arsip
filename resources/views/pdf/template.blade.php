<!DOCTYPE html>

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
    <div style="text-align: right;margin-top:28px;padding-right:24px ">Pekanbaru, Oktober 2024</div>
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
        [Bapak/Ibu]<br>
        [Jabatan]<br>
        di
    </div>
    @yield('content')
</body>

</html>
