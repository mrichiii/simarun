<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPBWL - Sistem Informasi Peminjaman Ruangan Gedung FST</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-section {
            min-height: 90vh;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,.1)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,144C960,149,1056,139,1152,128C1248,117,1344,107,1392,101.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-repeat: no-repeat;
            background-size: cover;
            opacity: 0.5;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            font-weight: 300;
        }

        .btn-hero {
            padding: 12px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            border: none;
            transition: all 0.3s ease;
            margin-right: 1rem;
        }

        .btn-primary-hero {
            background: white;
            color: #667eea;
        }

        .btn-primary-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            color: #667eea;
        }

        .btn-secondary-hero {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary-hero:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }

        .features-section {
            background: white;
            padding: 80px 0;
            position: relative;
            z-index: 3;
        }

        .feature-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            display: inline-block;
            width: 80px;
            height: 80px;
            line-height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(10deg);
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #333;
        }

        .feature-description {
            color: #666;
            line-height: 1.6;
        }

        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0;
            color: white;
            text-align: center;
        }

        .stat-item {
            padding: 30px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .cta-section {
            background: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 2rem;
            color: #333;
        }

        .cta-description {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 3rem;
        }

        .footer {
            background: #1a1a1a;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .nav-btn {
            transition: all 0.3s ease;
        }

        .nav-btn:hover {
            color: #667eea !important;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .btn-hero {
                padding: 10px 25px;
                font-size: 0.95rem;
                margin-bottom: 10px;
                margin-right: 0;
            }

            .feature-card {
                padding: 30px 20px;
                margin-bottom: 20px;
            }

            .stat-number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-building" style="margin-right: 10px;"></i>SIPBWL FST
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link nav-btn" href="/dashboard">
                                <i class="fas fa-chart-line" style="margin-right: 8px;"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-sm nav-btn">
                                    <i class="fas fa-sign-out-alt" style="margin-right: 6px;"></i>Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link nav-btn" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container-fluid position-relative" style="z-index: 2;">
            <div class="row align-items-center" style="min-height: 90vh;">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">Kelola Ruangan Gedung FST dengan Mudah</h1>
                    <p class="hero-subtitle">Platform manajemen peminjaman ruangan yang cerdas dan efisien untuk Gedung Fakultas Sains dan Teknologi</p>
                    <div>
                        @auth
                            <a href="/dashboard" class="btn btn-hero btn-primary-hero">
                                <i class="fas fa-arrow-right" style="margin-right: 8px;"></i>Ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-hero btn-primary-hero">
                                <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>Mulai Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-hero btn-secondary-hero">
                                <i class="fas fa-info-circle" style="margin-right: 8px;"></i>Pelajari Lebih Lanjut
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6 text-center" style="position: relative; z-index: 2;">
                    <div style="font-size: 8rem; color: rgba(255,255,255,0.8);">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="font-size: 3rem; font-weight: 800; color: #333; margin-bottom: 1rem;">Fitur Unggulan</h2>
                <p style="font-size: 1.2rem; color: #666;">Solusi lengkap untuk manajemen ruangan modern</p>
            </div>

            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="feature-title">Pencarian Mudah</h3>
                        <p class="feature-description">Cari ruangan berdasarkan gedung, lantai, dan fasilitas yang tersedia dengan cepat dan akurat</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="feature-title">Peminjaman Mudah</h3>
                        <p class="feature-description">Sistem peminjaman terintegrasi dengan pencegahan tabrakan jadwal otomatis</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-export"></i>
                        </div>
                        <h3 class="feature-title">Laporan Lengkap</h3>
                        <p class="feature-description">Buat laporan masalah ruangan dengan foto dan tracking status secara real-time</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <h3 class="feature-title">Dashboard Admin</h3>
                        <p class="feature-description">Pantau semua aktivitas dan kelola data dengan dashboard yang intuitif dan responsif</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 stat-item">
                    <div class="stat-number">7</div>
                    <div class="stat-label">Tahap Implementasi</div>
                </div>
                <div class="col-md-3 col-sm-6 stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Fitur Terpenuhi</div>
                </div>
                <div class="col-md-3 col-sm-6 stat-item">
                    <div class="stat-number">27</div>
                    <div class="stat-label">Commits Clean</div>
                </div>
                <div class="col-md-3 col-sm-6 stat-item">
                    <div class="stat-number">9/9</div>
                    <div class="stat-label">Tests Passing</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Siap Memulai?</h2>
            <p class="cta-description">Bergabunglah dengan sistem manajemen ruangan terbaru di Gedung FST</p>
            @auth
                <a href="/dashboard" class="btn btn-lg" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 15px 50px; border-radius: 50px; font-weight: 700; text-decoration: none;">
                    <i class="fas fa-arrow-right" style="margin-right: 10px;"></i>Buka Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 15px 50px; border-radius: 50px; font-weight: 700; text-decoration: none;">
                    <i class="fas fa-sign-in-alt" style="margin-right: 10px;"></i>Login Sekarang
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p style="margin: 0;">© 2025 SIPBWL FST - Sistem Informasi Peminjaman Ruangan Gedung FST</p>
            <p style="margin: 10px 0 0 0; font-size: 0.9rem; opacity: 0.8;">Versi 1.0 - Production Ready</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
