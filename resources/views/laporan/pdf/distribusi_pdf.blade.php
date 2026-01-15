@extends('laporan.pdf.layout')

@section('title', 'Laporan Distribusi Ruangan')
@section('judul_laporan', 'KARTU INVENTARIS RUANGAN (KIR)')

@section('periode')
    <div style="text-align: center; margin-bottom: 10px;">
        <strong>LOKASI: {{ strtoupper($namaRuangan) }}</strong>
    </div>
    @if ($startDate && $endDate)
        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d
        {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
    @endif
@endsection

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Kode Barang</th>
                <th width="25%">Nama Barang</th>
                <th width="15%">Merek</th>
                <th width="10%">Tahun</th>
                <th width="10%" class="text-center">Jumlah</th>
                <th width="10%">Satuan</th>
                <th width="10%">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $d)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $d->barang->kode_barang }}</td>
                    <td>{{ $d->barang->nama_barang }}</td>
                    <td>{{ $d->barang->merek ?? '-' }}</td>
                    <td class="text-center">{{ $d->barang->tahun_perolehan }}</td>
                    <td class="text-center">{{ $d->jumlah }}</td>
                    <td>{{ $d->barang->satuan }}</td>
                    <td>{{ $d->kondisi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
