<style>
    .kop-surat {
        font-family: 'Times New Roman', Times, serif;
        /* line-height: 1.5; */
        text-align: center;
        margin-bottom: 20px;
    }

    .kop-surat img {
        height: 100px;
        margin-bottom: 10px;
    }

    .kop-surat h1,
    .kop-surat h2,
    .kop-surat p {
        margin: 0;
    }

    .kop-surat h1 {
        font-size: 21px;
        font-weight: 600;
    }

    .kop-surat h2 {
        font-size: 19px;
        font-weight: 600;
    }

    .kop-surat p {
        font-size: 16px;
    }

    .line {
        border-top: 3px solid black;
        margin: 10px 0;
    }
</style>
<div style="margin-top: 26px">
    <table>
        <tr>
            <td>
                <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('assets/img/logo_riau.png'))) }}"
                    width="77">
            </td>
            <td class="kop-surat" style="padding-left: 32px">
                <h1>PEMERINTAH PROVINSI RIAU</h1>
                <h2 style="margin-top: 2px">DINAS PEKERJAAN UMUM, PENATAAN RUANG,<br>
                    PERUMAHAN, KAWASAN PERMUKIMAN DAN <br>PERTANAHAN PROVINSI RIAU</h2>
                <p>Jl. SM Amin No.9A, Simpang Baru, Kec. Tampan, Kota Pekanbaru, Riau 28292<br>
                    Telepon (021) 727757879 Laman : https://puprpkpp.riau.go.id/</p>
            </td>
        </tr>
    </table>
    <div class="line"></div>
</div>
