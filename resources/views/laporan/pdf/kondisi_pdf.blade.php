@extends('laporan.pdf.layout')

@section('title', 'Laporan Kondisi Aset')
@section('judul_laporan', 'LAPORAN REKAPITULASI KONDISI ASET')

@section('periode')
    <div style="text-align: center; margin-bottom: 10px;">
        <strong>FILTER: {{ strtoupper($kondisi) }}</strong>
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
                <th width="30%">Nama Barang</th>
                <th width="20%">Ruangan</th>
                <th width="15%">Merk/Tahun</th>
                <th width="15%" class="text-center">Kondisi</th>
                <th width="15%" class="text-center">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $d)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        {{ $d->barang->nama_barang }} <br>
                        <small style="color: #555;">{{ $d->barang->kode_barang }}</small>
                    </td>
                    <td>{{ $d->ruangan->nama_ruangan }}</td>
                    <td>{{ $d->barang->merek ?? '-' }} / {{ $d->barang->tahun_perolehan }}</td>
                    <td class="text-center">{{ $d->kondisi }}</td>
                    <td class="text-center">{{ $d->jumlah }} {{ $d->barang->satuan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
