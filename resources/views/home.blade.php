<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMARUN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .navbar { 
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            border-bottom: 1px solid #e9ecef;
            display: flex; 
            position: sticky; 
            top: 10px; 
            z-index: 1000; 
            height: 70px; 
            align-items: center; 
            padding: 0 20px; 
            margin-bottom: 30px; 
            width: 95%; 
            margin-left: auto;
            margin-right: auto;
        }
        .nav-btn:hover {
            background-color: #e6f4e12f !important;
            border-radius: 8%;
            color: #224914 !important;
        }
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            justify-content: center;
            background-image: url("{{ asset('Kampus.jpg') }}");
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, #2c711373, #22491473);
            pointer-events: none;
            z-index: 1;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(139, 195, 74, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
            animation: float 15s ease-in-out infinite reverse;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(30px, 30px) rotate(180deg); }
        }
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 60px 20px;
        }
        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 8px 20px;
            border-radius: 50px;
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 24px;
            letter-spacing: 0.5px;
        }
        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            margin-bottom: 24px;
            line-height: 1.15;
            color: white;
            letter-spacing: -2px;
        }
        .hero-subtitle {
            font-size: 1.35rem;
            margin-bottom: 40px;
            opacity: 0.9;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.95);
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }
        .btn-hero {
            padding: 16px 40px;
            font-size: 1.05rem;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            transition: all 0.3s ease;
            margin: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .btn-primary-hero {
            background: white;
            color: #2c7113;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }
        .btn-primary-hero:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
        }
        .btn-secondary-hero {
            background: #ffffff1a;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }
        .btn-secondary-hero:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            color: #2c7113;
        }
        .btn-success {
            background: linear-gradient(135deg, #2c7113, #224914);
            border-color: var(--green-600);
            color: white;
        }
        .btn-success:hover {
            filter: brightness(0.95);
        }
        .hero-visual {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            opacity: 0.85;
        }
        .room-preview {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }
        .room-preview:nth-child(1) { animation-delay: 0.1s; }
        .room-preview:nth-child(2) { animation-delay: 0.2s; }
        .room-preview:nth-child(3) { animation-delay: 0.3s; }
        .room-preview:nth-child(4) { animation-delay: 0.4s; }
        .room-preview:nth-child(5) { animation-delay: 0.5s; }
        .room-preview:nth-child(6) { animation-delay: 0.6s; }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
            from {
                opacity: 0;
                transform: translateY(20px);
            }
        }
        .room-preview:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.25);
        }
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }
        .section-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 16px;
            letter-spacing: -1px;
        }
        .section-subtitle {
            font-size: 1.15rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }
        .solution-card {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border-radius: 16px;
            padding: 40px;
            border: 2px solid #81c784;
            position: relative;
            overflow: hidden;
        }
        .solution-card::before {
            content: '✓';
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 4rem;
            color: rgba(76, 175, 80, 0.15);
            font-weight: 900;
        }
        .status-section {
            padding: 100px 0;
            border-top: 1px solid #e0e0e0;
            background: #ffffff;
        }
        .filter-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
            margin-bottom: 32px;
            border: 1px solid #f0f0f0;
        }
        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 16px;
        }
        .room-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
            border: 2px solid #e0e0e0;
            position: relative;
            overflow: hidden;
        }
        .room-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #e0e0e0;
            transition: all 0.3s ease;
        }
        .room-card.available {
            border-color: #c8e6c9;
            background: linear-gradient(135deg, #ffffff 0%, #f1f8f4 100%);
        }
        .room-card.available::before {
            background: linear-gradient(180deg, #2c7113 0%, #2e7d32 100%);
        }
        .room-card.used {
            border-color: #ffe0b2;
            background: linear-gradient(135deg, #ffffff 0%, #fff8ed 100%);
        }
        .room-card.used::before {   
            background: linear-gradient(180deg, #ffa200 0%, #d29201 100%);
        }
        .room-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        .room-code {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        .room-status {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-block;
        }
        .room-status.available {
            background: #c8e6c9;
            color: #2e7d32;
        }
        .room-status.used {
            background: #ffe0b2;
            color: #e65100;
        }
        .room-status.unavailable {
            background: #eeeeee;
            color: #616161;
        }
        .features-section {
            padding: 100px 0;
            min-height: 100vh;
            background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);
        }
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px 32px;
            text-align: center;
            transition: all 0.4s ease;
            border: 1px solid #f0f0f0;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2c7113 0%, #4caf50 100%);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        .feature-card:hover {
            box-shadow: 0 20px 40px rgba(44, 113, 19, 0.15);
        }
        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #2c7113;
        }
        .feature-card:hover .feature-icon {
            background: linear-gradient(135deg, #2c7113, #224914);
            color: white;
        }
        .feature-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: #1a1a1a;
        }
        .feature-description {
            color: #666;
            line-height: 1.7;
            font-size: 0.95rem;
        }
        .flow-section {
            padding: 100px 0;
            min-height: 80vh;
            background: linear-gradient(135deg, #1a5f2a 0%, #2c7113 100%);
            position: relative;
            overflow: hidden;
        }
        .flow-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            top: -150px;
            left: -150px;
        }
        .flow-step {
            text-align: center;
            position: relative;
        }
        .flow-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            transition: all 0.3s ease;
        }
        .flow-step:hover .flow-icon {
            transform: scale(1.15);
            background: rgba(255, 255, 255, 0.25);
        }
        .flow-label {
            font-weight: 700;
            color: white;
            font-size: 1.05rem;
        }
        .cta-section {
            padding: 100px 0;
            min-height: 95vh;
            background: linear-gradient(135deg, #f8fffe 0%, #e8f5e9 100%);
            text-align: center;
            position: relative;
        }
        .cta-card {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 24px;
            padding: 60px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: #1a1a1a;
            letter-spacing: -1px;
        }
        .cta-description {
            font-size: 1.15rem;
            color: #666;
            margin-bottom: 40px;
        }
        .btn-cta {
            padding: 18px 48px;
            font-size: 1.1rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1a5f2a 0%, #2c7113 100%);
            color: white;
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(44, 113, 19, 0.3);
        }
        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(44, 113, 19, 0.4);
        }
        .footer {
            background: #1a1a1a;
            color: white;
            padding: 60px 0 30px;
        }
        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: center;
            margin-bottom: 20px;
        }
        .footer-brand img {
            width: 44px;
            height: 44px;
            border-radius: 8px;
        }
        .footer-title {
            font-weight: 900;
            font-size: 1.5rem;
        }
        .footer-desc {
            color: #999;
            font-size: 0.95rem;
            margin-bottom: 30px;
        }
        .footer-bottom {
            border-top: 1px solid #333;
            padding-top: 20px;
            margin-top: 30px;
            color: #777;
            font-size: 0.9rem;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .legend-dot {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            flex-shrink: 0;
        }
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.1rem;
            }
            .section-title {
                font-size: 2rem;
            }
            .room-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
            .flow-icon {
                width: 70px;
                height: 70px;
                font-size: 1.5rem;
            }
            .cta-card {
                padding: 40px 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation (Preserved) -->
    <nav class="navbar navbar-expand navbar-light" style="justify-content: center;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/" style="color: #000 !important; font-weight:700;">
                <img src="{{ asset('logo1.png') }}" alt="SIMARUN" style="width: 44px; height: 44px; margin-right: 10px; vertical-align: middle; border-radius: 8px;">
                <span class="navbar-brand-text fw-bold"
                    style="vertical-align: middle; font-weight: 800; color: #2c7113; font-size: 1.8rem;">SIMARUN
                </span>

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto align-items-lg-center gap-5">
                    <li class="nav-item"><a class="nav-link nav-btn" href="#home" style="color:#0a0a0a;">Home</a></li>
                    <li class="nav-item"><a class="nav-link nav-btn" href="#features" style="color:#0a0a0a;">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link nav-btn" href="#status" style="color:#0a0a0a;">Status</a></li>
                    <li class="nav-item"><a class="nav-link nav-btn" href="#flow" style="color:#0a0a0a;">Alur</a></li>
                    <li class="nav-item"><a class="nav-link nav-btn" href="#cta" style="color:#0a0a0a;">Masuk</a></li>
                </ul>
                <ul class="navbar-nav align-items-lg-center" style="align-items: center;">
                    <li class="nav-item">
                        @auth
                            <a href="/dashboard" class="btn btn-outline-success btn-sm">Dashboard</a>
                        @else
                            <a href="{{ route('login', ['type' => 'email']) }}" class="btn btn-primary btn-sm" style="font-weight:700; background: linear-gradient(135deg, #2c7113, #224914); border-color: #224914; color: white;">Masuk Admin</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="hero-content" style="top: -20px;">
                <div class="hero-badge">
                    <i class="fas fa-star me-2"></i>Sistem Informasi Manajemen Ruangan
                </div>
                <h1 class="hero-title">Kelola Ruangan<br/>dengan Lebih Cerdas</h1>
                <p class="hero-subtitle">Platform modern untuk manajemen dan peminjaman ruangan akademik di Universitas Islam Negeri Sumatera Utara. Mudah, cepat, dan terintegrasi.</p>
                
                <div class="d-flex justify-content-center flex-wrap">
                    <a href="#status" class="btn btn-hero btn-primary-hero">
                        <i class="fas fa-search me-2"></i>Status Ruangan
                    </a>
                    @auth
                        <a href="/dashboard" class="btn btn-hero btn-secondary-hero">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login', ['type' => 'nim']) }}" class="btn btn-hero btn-secondary-hero">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk Sistem
                        </a>
                    @endauth
                </div>

                <div class="hero-visual">
                    <div class="room-preview">Ruang 101</div>
                    <div class="room-preview">Ruang 102</div>
                    <div class="room-preview">Ruang 201</div>
                    <div class="room-preview">Ruang 202</div>
                    <div class="room-preview">Ruang 301</div>
                    <div class="room-preview">Ruang 302</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Fitur Unggulan</h2>
                <p class="section-subtitle">Solusi lengkap untuk manajemen ruangan modern</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="feature-title">Pencarian Cerdas</h3>
                        <p class="feature-description">Temukan ruangan berdasarkan gedung, lantai, dan fasilitas dengan filter yang powerful</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="feature-title">Booking Otomatis</h3>
                        <p class="feature-description">Sistem peminjaman terintegrasi dengan deteksi konflik jadwal secara otomatis</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h3 class="feature-title">Laporan Terintegrasi</h3>
                        <p class="feature-description">Laporkan masalah dengan foto dan tracking status real-time untuk tindak lanjut</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Status Section -->
    <section id="status" class="status-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Status Ruangan Real-time</h2>
                <p class="section-subtitle">Pantau ketersediaan ruangan tanpa perlu login</p>
            </div>

            <div class="filter-card">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h5 style="font-weight:700; margin-bottom:8px; color:#1a1a1a;">Filter Ruangan</h5>
                        <p style="margin:0; color:#666; font-size:0.9rem;">Pilih gedung dan lantai untuk melihat detail</p>
                    </div>
                    <form id="filterForm" method="GET" action="/" class="d-flex flex-wrap gap-2">
                        <select id="filterGedung" name="gedung" class="form-select">
                            @foreach($gedungs ?? [] as $g)
                                <option value="{{ $g->kode_gedung }}" {{ (isset($kodeGedung) && $kodeGedung === $g->kode_gedung) ? 'selected' : '' }}>
                                    {{ $g->nama_gedung }} ({{ $g->kode_gedung }})
                                </option>
                            @endforeach
                        </select>
                        <select id="filterLantai" name="lantai" class="form-select">
                            @foreach($lantais ?? [] as $l)
                                <option value="{{ $l->nomor_lantai }}" {{ (isset($lantaiNomor) && (int)$lantaiNomor === (int)$l->nomor_lantai) ? 'selected' : '' }}>
                                    Lantai {{ $l->nomor_lantai }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-success w-100" style="font-weight:700;">
                            <i class="fas fa-filter me-2"></i>Terapkan
                        </button>
                    </form>
                </div>

                <div class="d-flex flex-wrap gap-4 mt-4">
                    <div class="legend-item">
                        <div class="legend-dot" style="background:#2c7113;"></div>
                        <span style="font-size:0.9rem; color:#555;">Tersedia</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background:#d29201;"></div>
                        <span style="font-size:0.9rem; color:#555;">Terpakai</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background:#0a0a0a;"></div>
                        <span style="font-size:0.9rem; color:#555;">Tidak Tersedia</span>
                    </div>
                </div>
            </div>

            <div class="room-grid">
                @foreach($rooms ?? collect() as $r)
                    @php
                        $status = $r->status ?? ($r['status'] ?? 'unavailable');
                        $statusClass = ($status === 'tersedia' || $status === 'available') ? 'available' : (($status === 'terpakai' || $status === 'used') ? 'used' : 'used');
                        $label = ($status === 'tersedia' || $status === 'available') ? 'Tersedia' : (($status === 'terpakai' || $status === 'used') ? 'Terpakai' : 'Tidak Tersedia');
                        $code = $r->kode_ruangan ?? ($r['code'] ?? '—');
                    @endphp
                    <div class="room-card {{ $statusClass }}">
                        <div class="room-code">{{ $code }}</div>
                        <span class="room-status {{ $statusClass }}">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Flow Section -->
    <section id="flow" class="flow-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" style="color:white;">Alur Penggunaan Sistem</h2>
                <p class="section-subtitle" style="color:rgba(255,255,255,0.9);">Lima langkah mudah untuk memesan ruangan</p>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-2">
                    <div class="flow-step">
                        <div class="flow-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="flow-label">Login NIM</div>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="flow-step">
                        <div class="flow-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="flow-label">Lihat Status</div>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="flow-step">
                        <div class="flow-icon">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <div class="flow-label">Pilih Ruangan</div>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="flow-step">
                        <div class="flow-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="flow-label">Tentukan Waktu</div>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="flow-step">
                        <div class="flow-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="flow-label">Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="cta" class="cta-section">
        <div class="container">
            <div class="cta-card-lg-10">
                <h2 class="cta-title">Siap Menggunakan SIMARUN?</h2>
                <p class="cta-description">Mulai kelola dan pesan ruangan dengan sistem yang lebih efisien dan transparan</p>
                @auth
                    <a href="/dashboard" class="btn btn-cta">
                        <i class="fas fa-tachometer-alt me-2"></i>Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login', ['type' => 'nim']) }}" class="btn btn-cta">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk Sekarang
                    </a>
                @endauth
            </div>
        </div>
        <div class="row justify-content-center" style="margin-top: 3rem;">
            <div class="col-lg-10">
                <div class="solution-card">
                    <h3 style="font-weight:800; color:#2c7113; margin-bottom:16px;">
                        <i class="fas fa-lightbulb me-2"></i>Solusi Kami
                    </h3>
                    <p style="color:#1a1a1a; font-size:1.05rem; margin:0; line-height:1.7;">
                        SIMARUN menyediakan platform terpusat, transparan, dan mudah diakses untuk memantau, memesan, dan mengelola ruangan akademik secara efisien. Dengan sistem otomatis yang mencegah konflik jadwal dan pelaporan yang terintegrasi, kami memastikan pengelolaan ruangan yang optimal.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <div class="footer-brand">
                <img src="{{ asset('logo2.png') }}" alt="SIMARUN">
                <div class="footer-title">SIMARUN</div>
            </div>
            <p class="footer-desc">Sistem Informasi Manajemen Ruangan<br/>Sistem Informasi - Fakultas Sains dan Teknologi - Universitas Islam Negeri Sumatera Utara</p>
            
            <div class="footer-bottom">
                <p style="margin:0;">© 2025 SIMARUN. Sistem Informasi Manajemen Ruangan.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enable Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>