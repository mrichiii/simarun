@extends('layouts.app')

@section('title', 'Data Gedung')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Data Gedung</h1>
        <a href="{{ route('gedung.create') }}" class="btn btn-primary">+ Tambah Gedung</a>
    </div>

    @if ($gedung->isEmpty())
        <div class="card p-4 text-center text-muted">
            <p>Belum ada data gedung. <a href="{{ route('gedung.create') }}">Tambah gedung sekarang</a></p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Kode Gedung</th>
                        <th>Nama Gedung</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gedung as $item)
                        <tr>
                            <td><strong>{{ $item->kode_gedung }}</strong></td>
                            <td>{{ $item->nama_gedung }}</td>
                            <td>{{ $item->lokasi ?? '-' }}</td>
                            <td>
                                <a href="{{ route('gedung.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('gedung.destroy', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
