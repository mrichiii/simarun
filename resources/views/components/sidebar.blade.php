<!-- Modern Sidebar Component for Authenticated Users -->
@auth
<div class="d-none d-lg-block">
    <aside class="sidebar-wrapper" style="position: fixed; left: 0; top: 70px; height: calc(100vh - 70px); width: 280px; background: white; border-right: 1px solid #e9ecef; overflow-y: auto; z-index: 999;">
        <div class="sidebar-content p-4">
            @if(Auth::user()->role === 'admin')
                <!-- Admin Sidebar -->
                <div class="sidebar-section mb-4">
                    <h6 class="sidebar-title text-uppercase fw-bold mb-3" style="font-size: 0.75rem; color: #999; letter-spacing: 0.5px;">
                        <i class="fas fa-crown" style="margin-right: 6px; color: #ffc107;"></i>Admin
                    </h6>
                    <ul class="sidebar-menu list-unstyled">
                        <li class="mb-2">
                            <a href="/admin/dashboard" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-chart-line" style="width: 20px; margin-right: 12px; color: #1a73e8;"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="/gedung" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-building" style="width: 20px; margin-right: 12px; color: #ea4335;"></i>
                                <span>Gedung</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="/gedung" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-layer-group" style="width: 20px; margin-right: 12px; color: #34a853;"></i>
                                <span>Lantai & Ruangan</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="/gedung" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-wind" style="width: 20px; margin-right: 12px; color: #fbbc04;"></i>
                                <span>Fasilitas</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <hr style="border-top: 1px solid #e9ecef;">

                <div class="sidebar-section mb-4">
                    <h6 class="sidebar-title text-uppercase fw-bold mb-3" style="font-size: 0.75rem; color: #999; letter-spacing: 0.5px;">
                        <i class="fas fa-folder" style="margin-right: 6px; color: #4285f4;"></i>Laporan
                    </h6>
                    <ul class="sidebar-menu list-unstyled">
                        <li class="mb-2">
                            <a href="/admin/laporan" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-file-alt" style="width: 20px; margin-right: 12px; color: #ea4335;"></i>
                                <span>Kelola Laporan</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="/admin/laporan/export" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-download" style="width: 20px; margin-right: 12px; color: #34a853;"></i>
                                <span>Export PDF</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @else
                <!-- User Sidebar -->
                <div class="sidebar-section mb-4">
                    <h6 class="sidebar-title text-uppercase fw-bold mb-3" style="font-size: 0.75rem; color: #999; letter-spacing: 0.5px;">
                        <i class="fas fa-user" style="margin-right: 6px; color: #4285f4;"></i>User
                    </h6>
                    <ul class="sidebar-menu list-unstyled">
                        <li class="mb-2">
                            <a href="/dashboard" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-home" style="width: 20px; margin-right: 12px; color: #1a73e8;"></i>
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="/dashboard" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-search" style="width: 20px; margin-right: 12px; color: #4285f4;"></i>
                                <span>Cari Ruangan</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <hr style="border-top: 1px solid #e9ecef;">

                <div class="sidebar-section mb-4">
                    <h6 class="sidebar-title text-uppercase fw-bold mb-3" style="font-size: 0.75rem; color: #999; letter-spacing: 0.5px;">
                        <i class="fas fa-tasks" style="margin-right: 6px; color: #34a853;"></i>Aktivitas
                    </h6>
                    <ul class="sidebar-menu list-unstyled">
                        <li class="mb-2">
                            <a href="/booking/my-bookings" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-calendar-alt" style="width: 20px; margin-right: 12px; color: #fbbc04;"></i>
                                <span>Peminjaman Saya</span>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="/laporan" class="sidebar-link d-flex align-items-center px-3 py-2 rounded" style="color: #666; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-exclamation-circle" style="width: 20px; margin-right: 12px; color: #ea4335;"></i>
                                <span>Laporan Saya</span>
                            </a>
                        </li>
                    </ul>
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
        background-color: #f0f4ff !important;
        color: #1a73e8 !important;
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
