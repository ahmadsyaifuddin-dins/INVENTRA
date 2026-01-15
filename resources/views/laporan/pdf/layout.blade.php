<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Laporan Inventaris')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
        }

        /* Style Tabel Data Standar */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
            font-size: 10pt;
        }

        .data-table th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center !important;
        }

        .text-right {
            text-align: right !important;
        }

        /* Judul Laporan */
        .report-title {
            text-align: center;
            margin: 20px 0;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .report-periode {
            text-align: center;
            margin-top: -15px;
            margin-bottom: 20px;
            font-size: 11pt;
        }
    </style>
</head>

<body>

    @include('laporan.pdf._header')

    <div class="report-title">@yield('judul_laporan')</div>

    @hasSection('periode')
        <div class="report-periode">@yield('periode')</div>
    @endif

    @yield('content')

    @include('laporan.pdf._signature')

</body>

</html>
