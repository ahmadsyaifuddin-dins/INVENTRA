@extends('laporan.pdf.layout')

@section('title', 'Laporan Aset per Kategori')
@section('judul_laporan', 'LAPORAN ASET PER KATEGORI')

@section('periode')
    <div style="text-align: center; margin-bottom: 10px;">
        <strong>KATEGORI: {{ strtoupper($namaKategori) }}</strong>
    </div>
    @if ($startDate && $endDate)
        Periode Input: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d
        {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
    @endif
@endsection

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="20%">Kategori</th>
                <th width="35%">Nama Barang / Kode</th>
                <th width="20%">Merek</th>
                <th width="10%" class="text-center">Tahun</th>
                <th width="10%">Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $b)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $b->kategori->nama_kategori }}</td>
                    <td>
                        {{ $b->nama_barang }} <br>
                        <small>{{ $b->kode_barang }}</small>
                    </td>
                    <td>{{ $b->merek ?? '-' }}</td>
                    <td class="text-center">{{ $b->tahun_perolehan }}</td>
                    <td>{{ $b->satuan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
