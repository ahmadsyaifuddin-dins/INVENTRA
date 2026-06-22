@extends('laporan.pdf.layout')

@section('title', 'Laporan Hasil Audit Opname')

@section('judul_laporan', 'LAPORAN HASIL AUDIT STOK OPNAME FISIK')

@section('periode')
    @if ($startDate && $endDate)
        Periode Audit: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d
        {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
    @else
        Periode Audit: Semua Riwayat Pemeriksaan
    @endif
@endsection

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%" class="text-center">Tanggal Audit</th>
                <th width="25%">Nama Barang (Kode)</th>
                <th width="10%" class="text-center">Sistem</th>
                <th width="10%" class="text-center">Fisik</th>
                <th width="10%" class="text-center">Selisih</th>
                <th width="25%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $a)
                @php
                    $sistem = $a->jumlah_sistem ?? 0;
                    $fisik = $a->jumlah_fisik ?? 0;
                    $selisih = $fisik - $sistem;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($a->created_at)->format('d/m/Y') }}</td>
                    <td>
                        @if ($a->barang)
                            <strong>{{ $a->barang->nama_barang }}</strong><br>
                            <span style="font-size: 10px; color: #555;">{{ $a->barang->kode_barang }}</span>
                        @else
                            <strong style="color: red; font-style: italic;">Aset Telah Dihapus</strong>
                        @endif
                    </td>
                    <td class="text-center">{{ $sistem }}</td>
                    <td class="text-center">{{ $fisik }}</td>
                    <td class="text-center">
                        @if ($selisih == 0)
                            0
                        @else
                            {{ $selisih }}
                        @endif
                    </td>
                    <td>{{ $a->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
