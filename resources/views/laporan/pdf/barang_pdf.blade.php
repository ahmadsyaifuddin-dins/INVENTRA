@extends('laporan.pdf.layout')

@section('title', 'Laporan Data Barang')

@section('judul_laporan', 'LAPORAN DATA INDUK BARANG')

@section('periode')
    @if ($startDate && $endDate)
        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d
        {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
    @else
        Periode: Semua Data
    @endif
@endsection

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Kode Barang</th>
                <th width="30%">Nama Barang</th>
                <th width="20%">Kategori</th>
                <th width="15%">Merek</th>
                <th width="15%" class="text-center">Tahun</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $index => $b)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $b->kode_barang }}</td>
                    <td>{{ $b->nama_barang }}</td>
                    <td>{{ $b->kategori->nama_kategori }}</td>
                    <td>{{ $b->merek ?? '-' }}</td>
                    <td class="text-center">{{ $b->tahun_perolehan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
