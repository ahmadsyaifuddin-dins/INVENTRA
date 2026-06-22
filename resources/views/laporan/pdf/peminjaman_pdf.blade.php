@extends('laporan.pdf.layout')

@section('title', 'Laporan Peminjaman Aktif')

@section('judul_laporan', 'LAPORAN PEMINJAMAN AKTIF & KETERLAMBATAN')

@section('periode')
    Filter Status: {{ $statusFilter }}
@endsection

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="20%">Peminjam</th>
                <th width="30%">Nama Aset (Kode)</th>
                <th width="15%" class="text-center">Batas Kembali</th>
                <th width="15%" class="text-center">Selisih Waktu</th>
                <th width="15%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $p)
                @php
                    $tKembali = \Carbon\Carbon::parse($p->tanggal_kembali)->startOfDay();
                    $selisih = now()->startOfDay()->diffInDays($tKembali, false);

                    if ($selisih < 0) {
                        $teksSelisih = 'Telat ' . abs($selisih) . ' Hari';
                    } elseif ($selisih == 0) {
                        $teksSelisih = 'Hari Ini';
                    } else {
                        $teksSelisih = $selisih . ' Hari Lagi';
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->user->nama_lengkap }}</td>
                    <td>
                        <strong>{{ $p->barang->nama_barang }}</strong><br>
                        <span style="font-size: 10px; color: #555;">{{ $p->barang->kode_barang }}</span>
                    </td>
                    <td class="text-center">{{ $tKembali->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $teksSelisih }}</td>
                    <td class="text-center">{{ $p->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
