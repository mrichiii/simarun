<!-- Modern Sidebar Component for Authenticated Users -->
@auth
<div class="d-none d-lg-block">
    <aside class="sidebar-wrapper" style="position: fixed; left: 0; top: 0px; height: 100%; width: 280px; background: white; border-right: 1px solid #e9ecef; overflow-y: auto; z-index: 1000;">
        <div class="sidebar-content p-4">
            @if(Auth::user()->role === 'admin')
                <!-- Admin Sidebar -->
                <div class="sidebar-section mb-4">
                    <a class="navbar-brand fw-bold me-4 d-flex align-items-center" href="/" style="font-size: 1.4rem; color: #000 !important;">
                        <img src="{{ asset('logo1.png') }}" alt="SIMARUN" style="width: 45px; height: 45px; margin-right: 12px; border-radius: 50%;">
                        SIMARUN 
                    </a>
                    <br>
                    <ul class="sidebar-menu list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-chart-line" style="width: 20px; margin-right: 12px; color: var(--green);"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('gedung.index') }}" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-building" style="width: 20px; margin-right: 12px; color: var(--yellow);"></i>
                                <span>Gedung</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.lantai.index') }}" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-layer-group" style="width: 20px; margin-right: 12px; color: var(--green);"></i>
                                <span>Lantai</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.ruangan.index') }}" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-door-open" style="width: 20px; margin-right: 12px; color: var(--yellow);"></i>
                                <span>Ruangan</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.fasilitas.index') }}" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-wind" style="width: 20px; margin-right: 12px; color: var(--green);"></i>
                                <span>Fasilitas</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="sidebar-menu list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('admin.mahasiswa.index') }}" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-user-graduate" style="width: 20px; margin-right: 12px; color: var(--yellow);"></i>
                                <span>Kelola Mahasiswa</span>
                            </a>
                        </li>
                    </ul>
                    
                    <ul class="sidebar-menu list-unstyled">
                        <li class="mb-2">
                            <a href="/admin/laporan" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-file-alt" style="width: 20px; margin-right: 12px; color: var(--green);"></i>
                                <span>Kelola Laporan</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="sidebar-menu list-unstyled mt-4">
                        <li class="mb-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="sidebar-link d-flex align-items-center px-3 py-2 rounded w-100 text-start border-0 bg-transparent" style="color: #666; text-decoration: none; transition: 0.3s; cursor: pointer;">
                                    <i class="fas fa-sign-out-alt" style="width: 20px; margin-right: 12px; color: #dc3545;"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <!-- User Sidebar -->
                <div class="sidebar-section mb-4">
                    <a class="navbar-brand fw-bold me-4 d-flex align-items-center" href="/" style="font-size: 1.4rem; color: #000 !important;">
                        <img src="{{ asset('logo1.png') }}" alt="SIMARUN" style="width: 45px; height: 45px; margin-right: 12px; border-radius: 20%;">
                        SIMARUN 
                    </a>
                    <br>
                    <ul class="sidebar-menu list-unstyled">
                        <li class="mb-2">
                            <a href="/dashboard" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-home" style="width: 20px; margin-right: 12px; color: var(--green);"></i>
                                <span>Beranda</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="sidebar-menu list-unstyled">
                        <li class="mb-2">
                            <a href="/booking/my-bookings" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-calendar-alt" style="width: 20px; margin-right: 12px; color: var(--yellow);"></i>
                                <span>Peminjaman Saya</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="/laporan" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-exclamation-circle" style="width: 20px; margin-right: 12px; color: var(--green);"></i>
                                <span>Laporan Saya</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <hr style="border-top: 1px solid #e9ecef;">
                <div class="sidebar-section mb-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-link d-flex align-items-center px-3 py-2 rounded w-100 text-start border-0 bg-transparent" style="color: #666; text-decoration: none; transition: 0.3s; cursor: pointer;">
                            <i class="fas fa-sign-out-alt" style="width: 20px; margin-right: 12px; color: #dc3545;"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </aside>
</div>

<style>
    .sidebar-link {
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .sidebar-link:hover {
        background-color: var(--surface) !important;
        color: var(--green) !important;
        transform: translateX(4px);
    }
    
    /* Responsive: Hide sidebar on mobile, adjust main content */
    @media (max-width: 991px) {
        .sidebar-wrapper {
            display: none;
        }
    }
</style>
@endauth
