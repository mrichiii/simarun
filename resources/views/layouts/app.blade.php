<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Manajemen Ruangan FST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root{
            --bg: #f4f4f4;
            --text: #111111;
            --muted: #666666;
            --green: #2c7113;
            --green-600: #224914;
            --yellow: #f59e0b;
            --surface: #f8faf6; /* very light green/white */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-color: var(--bg);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            color: var(--text);
        }
        body.with-sidebar {
            margin-left: 280px;
        }
        @media (max-width: 991px) {
            body.with-sidebar {
                margin-left: 0;
            }
        }
        .navbar {
            background-color: var(--bg);
            border-bottom: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            height: 70px;
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--text) !important;
            font-size: 1.3rem;
        }
        .nav-link {
            color: var(--muted) !important;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: var(--green) !important;
        }
        .container-main {
            margin-top: 2rem;
            margin-bottom: 2rem;
            margin-left: auto;
            margin-right: auto;
        }
        @media (max-width: 991px) {
            .container-main {
                margin-left: 0;
            }
        }
        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            border-radius: 8px;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--green), var(--green-600));
            border-color: var(--green-600);
            color: white;
        }
        .btn-primary:hover {
            filter: brightness(0.95);
        }
    </style>
    @yield('css')
</head>
<body @auth class="with-sidebar" @endauth>
    @include('components.navbar')
    @include('components.sidebar')

    <div class="container-main container-lg">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('js')
</body>
</html>
