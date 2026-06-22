@extends('laporan.pdf.layout')

@section('title', 'Laporan Agenda Maintenance')

@section('judul_laporan', 'LAPORAN AGENDA PEMELIHARAAN & PENYUSUTAN ASET')

@section('periode')
    Periode Agenda: Bulan {{ $bulan }} Tahun {{ $tahun }} (Filter: {{ $jenis }})
@endsection

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Kode Aset</th>
                <th width="30%">Nama Barang</th>
                <th width="20%">Kategori</th>
                <th width="15%" class="text-center">Jadwal Servis</th>
                <th width="15%" class="text-center">Masa Susut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $b)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $b->getRawOriginal('kode_barang') ?? $b->kode_barang }}</td>
                    <td>{{ $b->nama_barang }}</td>
                    <td>{{ $b->kategori->nama_kategori }}</td>
                    <td class="text-center">
                        {{ $b->tgl_servis_berikutnya ? \Carbon\Carbon::parse($b->tgl_servis_berikutnya)->format('d/m/Y') : '-' }}
                    </td>
                    <td class="text-center">
                        {{ $b->tgl_penyusutan_habis ? \Carbon\Carbon::parse($b->tgl_penyusutan_habis)->format('d/m/Y') : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
