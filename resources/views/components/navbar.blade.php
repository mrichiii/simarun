<!-- Modern Navbar Component -->
<nav class="navbar navbar-expand-lg navbar-light bg-sticky-top" style="border-bottom: 1px solid #e9ecef; position: sticky; top: 0; z-index: 30; width: 100%; height: 90px; padding: 0;">
    <div class="container-fluid px-4">
        <!-- Brand dengan Logo -->


        <!-- Toggle Button for Mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Right Menu -->
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3" href="#" role="button" data-bs-toggle="dropdown" style="color: #333; display: flex; align-items: center;">
                            <i class="fas fa-user-circle me-2" style="font-size: 1.3rem; color: #2c7113;"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0">
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit" style="margin-right: 8px; color: #000;"></i>Edit Profil
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
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
