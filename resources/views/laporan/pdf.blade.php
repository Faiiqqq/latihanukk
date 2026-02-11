<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        .date {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>

    <h1>LAPORAN PEMINJAMAN ALAT</h1>

    <div class="date">
        {{ $start }} s/d {{ $end }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>User</th>
                <th>Alat</th>
                <th>Jumlah</th>
                <th>Denda</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->tgl_pinjam }}</td>
                    <td>{{ $row->user->nama }}</td>
                    <td>{{ $row->alat->nama }}</td>
                    <td>{{ $row->jumlah }}</td>
                    <td>{{ $row->denda }}</td>
                    <td>{{ strtoupper($row->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
