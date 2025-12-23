<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Manajemen Ruangan FST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #f5f7fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            color: #333;
            padding-top: 70px;
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
            background-color: white;
            border-bottom: 1px solid #e0e0e0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            height: 70px;
        }
        .navbar-brand {
            font-weight: 700;
            color: #1a73e8 !important;
            font-size: 1.3rem;
        }
        .nav-link {
            color: #666 !important;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #1a73e8 !important;
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
            background-color: #1a73e8;
            border-color: #1a73e8;
        }
        .btn-primary:hover {
            background-color: #1557c0;
            border-color: #1557c0;
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
