<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Pengaduan Ruangan - FST</h2>
        <p>{{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Ruangan</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->user->name }} ({{ $item->user->email }})</td>
                    <td>{{ $item->ruangan ? $item->ruangan->kode_ruangan : '-' }}</td>
                    <td>{{ Str::limit($item->deskripsi, 120) }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>