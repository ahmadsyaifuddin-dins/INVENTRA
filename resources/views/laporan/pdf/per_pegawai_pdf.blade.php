@extends('laporan.pdf.layout')

@section('title', 'Laporan Statistik Pegawai')

@section('judul_laporan', 'LAPORAN STATISTIK KEPATUHAN PEMINJAMAN PEGAWAI')

@section('periode')
    Periode: Rekapitulasi Total Keseluruhan Data
@endsection

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="30%">Nama Pegawai</th>
                <th width="20%">Username</th>
                <th width="15%" class="text-center">Total Pinjam</th>
                <th width="15%" class="text-center">Tepat Waktu</th>
                <th width="15%" class="text-center">Pernah Telat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->username }}</td>
                    <td class="text-center">{{ $p->total_pinjam }} Kali</td>
                    <td class="text-center">{{ $p->total_selesai }} Kali</td>
                    <td class="text-center">{{ $p->total_telat }} Kali</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
