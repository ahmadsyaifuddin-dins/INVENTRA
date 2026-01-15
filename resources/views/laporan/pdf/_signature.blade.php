<style>
    .signature-container {
        width: 100%;
        margin-top: 50px;
    }

    /* Menggunakan tabel untuk memposisikan TTD di kanan tanpa float */
    .signature-table {
        width: 100%;
    }

    .ttd-column {
        width: 60%;
        /* Kolom kosong di kiri */
    }

    .ttd-box {
        width: 40%;
        /* Area TTD di kanan */
        text-align: center;
    }

    .tgl {
        margin-bottom: 10px;
    }

    .jabatan {
        font-weight: bold;
        margin-bottom: 60px;
        /* Jarak untuk tanda tangan basah */
    }

    .nama {
        font-weight: bold;
        text-decoration: underline;
    }

    .nip {
        margin-top: 2px;
    }
</style>

<div class="signature-container">
    <table class="signature-table">
        <tr>
            <td class="ttd-column"></td>
            <td class="ttd-box">
                <div class="tgl">
                    Banjarmasin, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}
                </div>
                <div class="jabatan">
                    Mengetahui,<br>
                    Kepala Sub Bagian Pembinaan
                </div>
                <div class="nama">
                    {{ $nama_pimpinan ?? 'NAMA PIMPINAN DISINI' }}
                </div>
                <div class="nip">
                    NIP. {{ $nip_pimpinan ?? '19xxxxxxxx xxx x xxx' }}
                </div>
            </td>
        </tr>
    </table>
</div>
