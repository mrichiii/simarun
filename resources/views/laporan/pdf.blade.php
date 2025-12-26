<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h2 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #1a1a1a;
        }

        .header p {
            font-size: 10px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #2c3e50;
            color: white;
        }

        th {
            padding: 10px 6px;
            text-align: left;
            font-weight: 600;
            border: 1px solid #34495e;
            font-size: 11px;
        }

        td {
            padding: 8px 6px;
            border: 1px solid #ddd;
            font-size: 10px;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f0f0f0;
        }

        .status-baru {
            background-color: #e8f4f8;
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: 500;
            color: #0275d8;
        }

        .status-diproses {
            background-color: #fff3cd;
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: 500;
            color: #856404;
        }

        .status-selesai {
            background-color: #d4edda;
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: 500;
            color: #155724;
        }

        .status-ditolak {
            background-color: #f8d7da;
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: 500;
            color: #721c24;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Pengaduan Ruangan</h2>
        <p>Cetak: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">User</th>
                <th style="width: 12%;">Ruangan</th>
                <th style="width: 30%;">Deskripsi</th>
                <th style="width: 12%;">Status</th>
                <th style="width: 16%;">Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <strong>{{ $item->user->name }}</strong><br>
                        {{ $item->user->email }}
                    </td>
                    <td>{{ $item->ruangan ? $item->ruangan->kode_ruangan : '-' }}</td>
                    <td>{{ Str::limit($item->deskripsi, 80) }}</td>
                    <td>
                        <span class="status-{{ strtolower($item->status) }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data laporan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total: {{ count($laporan) }} laporan | Sistem SIPBWL</p>
    </div>
</body>
</html>