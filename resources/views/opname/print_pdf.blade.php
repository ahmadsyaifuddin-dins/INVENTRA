@extends('laporan.pdf.layout')

@section('title', 'Berita Acara Stock Opname')
@section('judul_laporan', 'BERITA ACARA STOCK OPNAME')

@section('periode')
    <div style="text-align: center; margin-bottom: 20px;">
        Ruangan: {{ $opname->ruangan->nama_ruangan }} <br>
        Tanggal Cek: {{ \Carbon\Carbon::parse($opname->tanggal_opname)->format('d F Y') }}
    </div>
@endsection

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kode</th>
                <th>Jml Sistem</th>
                <th>Jml Fisik</th>
                <th>Selisih</th>
                <th>Status</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($opname->details as $index => $d)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $d->barang->nama_barang }}</td>
                    <td>{{ $d->barang->kode_barang }}</td>
                    <td class="text-center">{{ $d->jumlah_sistem }}</td>
                    <td class="text-center">{{ $d->jumlah_fisik }}</td>
                    <td class="text-center">{{ $d->jumlah_fisik - $d->jumlah_sistem }}</td>
                    <td>{{ $d->status_fisik }}</td>
                    <td>{{ $d->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <strong>Catatan Pemeriksa:</strong> <br>
        {{ $opname->catatan ?? '-' }}
    </div>
@endsection
