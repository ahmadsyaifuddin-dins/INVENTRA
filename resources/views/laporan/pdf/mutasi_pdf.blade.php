@extends('laporan.pdf.layout')

@section('title', 'Laporan Riwayat Mutasi')
@section('judul_laporan', 'LAPORAN RIWAYAT MUTASI / TRANSAKSI ASET')

@section('periode')
    @if ($startDate && $endDate)
        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d
        {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
    @else
        Periode: Semua Riwayat
    @endif
@endsection

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Tanggal</th>
                <th width="30%">Barang</th>
                <th width="25%">Lokasi Penempatan</th>
                <th width="10%" class="text-center">Jumlah</th>
                <th width="15%" class="text-center">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $m)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $m->created_at->format('d/m/Y') }}</td>
                    <td>
                        {{ $m->barang->nama_barang }} <br>
                        <small>{{ $m->barang->kode_barang }}</small>
                    </td>
                    <td>{{ $m->ruangan->nama_ruangan }}</td>
                    <td class="text-center">{{ $m->jumlah }}</td>
                    <td class="text-center">{{ $m->kondisi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
