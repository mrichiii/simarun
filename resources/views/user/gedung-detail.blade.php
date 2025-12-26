@extends('layouts.app')

@section('title', $gedung->nama_gedung)

@section('css')
<style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 0.75rem;
        margin-top: 1.5rem;
    }
    .grid-item {
        aspect-ratio: 1;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 700;
        font-size: 0.9rem;
        text-align: center;
        padding: 0.5rem;
        color: white;
        text-decoration: none;
        border: 2px solid transparent;
    }
    .grid-item:hover {
        transform: scale(1.08);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
    .grid-item.tersedia {
        background: linear-gradient(135deg,#2c7113,#224914);
    }
    .grid-item.tidak_tersedia {
        background: linear-gradient(135deg,#ffa200,#d29201);
        color: #0a0a0a;
    }
    .grid-item.tidak_dapat_dipakai {
        background: linear-gradient(135deg,#383737,#0a0a0a);
    }
    .lantai-section {
        margin-bottom: 3rem;
        background-color: #f9f9f9;
        padding: 1.5rem;
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">← Kembali ke Dashboard</a>
    </div>

    <h1 class="mb-1">{{ $gedung->nama_gedung }}</h1>
    <p class="text-muted mb-4">{{ $gedung->kode_gedung }} • {{ $gedung->lokasi ?? 'Lokasi tidak tersedia' }}</p>

    @if ($lantai->isEmpty())
        <div class="alert alert-info">Belum ada lantai di gedung ini</div>
    @else
        @foreach ($lantai as $l)
            <div class="lantai-section" style="border-block: 1px solid #9aa0a6;">
                <h4 class="mb-3">Lantai {{ $l->nomor_lantai }} {{ $l->nama_lantai ? '- ' . $l->nama_lantai : '' }}</h4>

                @if ($l->ruangan->isEmpty())
                    <p class="text-muted">Belum ada ruangan di lantai ini</p>
                @else
                    <div class="grid-container">
                        @foreach ($l->ruangan as $r)
                            <a href="{{ route('user.ruangan-detail', $r->id) }}" class="grid-item {{ $r->status }}">
                                <div>
                                    <div style="font-size: 0.8rem;">{{ $r->kode_ruangan }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="row mt-4 pt-2" style="border-top: 1px solid #9aa0a6;">
                        <div class="col-md-3">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 16px; height: 16px; background-color: #2c7113; border-radius: 3px;"></div>
                                <span style="font-size: 0.85rem;">Tersedia</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 16px; height: 16px; background-color: #d29201; border-radius: 3px;"></div>
                                <span style="font-size: 0.85rem;">Terpakai</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 16px; height: 16px; background-color: #0a0a0a; border-radius: 3px;"></div>
                                <span style="font-size: 0.85rem;">Tidak Dapat Dipakai</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    @endif
</div>
@endsection
