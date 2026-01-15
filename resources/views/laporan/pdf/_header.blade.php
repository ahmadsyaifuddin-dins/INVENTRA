<style>
    .header-table {
        width: 100%;
        border-bottom: 3px solid #000;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }

    .logo-container {
        width: 15%;
        /* Lebar kolom logo */
        text-align: center;
        vertical-align: middle;
    }

    .text-container {
        width: 85%;
        /* Lebar kolom teks */
        text-align: center;
        vertical-align: middle;
    }

    .instansi {
        font-size: 16pt;
        font-weight: bold;
        text-transform: uppercase;
        margin: 0;
    }

    .alamat {
        font-size: 10pt;
        margin: 5px 0 0 0;
        line-height: 1.2;
    }
</style>

<table class="header-table">
    <tr>
        <td class="logo-container">
            <img src="{{ public_path('logo/logo.png') }}" alt="Logo Kejaksaan" style="width: 80px; height: auto;">
        </td>

        <td class="text-container">
            <h1 class="instansi">KEJAKSAAN NEGERI BANJARMASIN</h1>
            <p class="alamat">
                Jalan Brigadir Jenderal Hasan Basri No. 3, Kelurahan Pangeran,<br>
                Kecamatan Banjarmasin Utara, Kota Banjarmasin,<br>
                Kalimantan Selatan 70124
            </p>
        </td>
    </tr>
</table>
