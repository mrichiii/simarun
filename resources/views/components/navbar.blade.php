<!-- Modern Navbar Component -->
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top" style="box-shadow: 0 2px 12px rgba(0,0,0,0.08); border-bottom: 1px solid #e9ecef; position: sticky; top: 0; z-index: 30; width: 100%; height: 90px; padding: 0;">
    <div class="container-fluid px-4">
        <!-- Brand -->
        <a class="navbar-brand fw-bold me-4" href="/" style="font-size: 1.4rem; color: #000 !important;">
            <i class="fas fa-building" style="margin-right: 8px; color: #2c7113;"></i>SIPBWL FST
        </a>

        <!-- Toggle Button for Mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Left Menu -->
            <ul class="navbar-nav me-auto">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link px-3" href="/admin/dashboard" style="color: #333; transition: 0.3s;">
                                <i class="fas fa-chart-line" style="margin-right: 6px; color: #000;"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle px-3" href="#" role="button" data-bs-toggle="dropdown" style="color: #333;">
                                <i class="fas fa-cog" style="margin-right: 6px; color: #f59e0b;"></i>Manajemen
                            </a>
                            <ul class="dropdown-menu border-0" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <li><a class="dropdown-item py-2" href="/gedung"><i class="fas fa-building" style="margin-right: 8px; color: #2c7113;"></i>Gedung</a></li>
                                <li><a class="dropdown-item py-2" href="/gedung"><i class="fas fa-layer-group" style="margin-right: 8px; color: #666;"></i>Lantai & Ruangan</a></li>
                                <li><a class="dropdown-item py-2" href="/gedung"><i class="fas fa-wind" style="margin-right: 8px; color: #666;"></i>Fasilitas</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2" href="{{ route('admin.mahasiswa.index') }}"><i class="fas fa-user-graduate" style="margin-right: 8px; color: #2c7113;"></i>Kelola Mahasiswa</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" href="/admin/laporan" style="color: #333; transition: 0.3s;">
                                <i class="fas fa-file-alt" style="margin-right: 6px; color: #000;"></i>Laporan
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link px-3" href="/dashboard" style="color: #333; transition: 0.3s;">
                                <i class="fas fa-home" style="margin-right: 6px; color: #000;"></i>Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" href="/booking/my-bookings" style="color: #333; transition: 0.3s;">
                                <i class="fas fa-calendar" style="margin-right: 6px; color: #2c7113;"></i>Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3" href="/laporan" style="color: #333; transition: 0.3s;">
                                <i class="fas fa-exclamation-circle" style="margin-right: 6px; color: #f59e0b;"></i>Laporan
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Menu -->
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3" href="#" role="button" data-bs-toggle="dropdown" style="color: #333; display: flex; align-items: center;">
                            <i class="fas fa-user-circle me-2" style="font-size: 1.3rem; color: #2c7113;"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            <li>
                                <a class="dropdown-item py-2" href="#">
                                    <i class="fas fa-user-edit" style="margin-right: 8px; color: #000;"></i>Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 w-100 text-start">
                                        <i class="fas fa-sign-out-alt" style="margin-right: 8px; color: #666;"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3" href="#" role="button" data-bs-toggle="dropdown" style="color: #2c7113;">
                            Login
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0" style="box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            <li><a class="dropdown-item" href="{{ route('login', ['type' => 'nim']) }}">Login Mahasiswa</a></li>
                            <li><a class="dropdown-item" href="{{ route('login', ['type' => 'email']) }}">Login Admin</a></li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar {
        transition: all 0.3s ease;
    }
    .nav-link:hover {
        color: #2c7113 !important;
    }
    .dropdown-item:hover {
        background-color: #f0f9f7;
        color: #2c7113;
    }
</style>
