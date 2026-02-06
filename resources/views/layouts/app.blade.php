<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EMS.</title>
    {{-- <link rel="icon" type="image/png" href="{{ asset('assets/images/ams.png') }}?v={{ time() }}"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <!-- Favicon -->
    {{-- <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/ams.png') }}"> --}}

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        :root {
            --primary-red: #e63946;
            --light-red: #ffebee;
            --dark-red: #c62828;
            --clean-white: #ffffff;
            --bg-gray: #f8f9fa;
            --text-dark: #212529;
            --text-light: #6c757d;
        }

        body {
            background-color: var(--bg-gray);
            font-family: 'Plus Jakarta Sans', sans-serif;
            /* font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; */
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 200px;
            background-color: var(--clean-white);
            color: var(--text-dark);
            padding-top: 0.5rem;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            z-index: 1050;
            transition: transform 0.3s ease;
            border-right: 1px solid rgba(0,0,0,0.05);
            font-size: 13px; /* Ukuran font keseluruhan sidebar */
        }

        .sidebar .logo {
            font-size: 13px;
            font-weight: 600;
            padding: 0.75rem 1rem;
            color: var(--primary-red);
            text-align: left;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
        }

        .sidebar .logo i {
            font-size: 1.2rem;
            margin-right: 0.5rem;
        }

        .sidebar a {
            color: var(--text-light);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            transition: all 0.2s;
            margin: 0.25rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 11px;
            white-space: nowrap; /* Hindari wrapping */
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar .active {
            background-color: var(--primary-red);
            color: var(--clean-white) !important;
        }

        .sidebar a i {
            margin-right: 0.5rem;
            font-size: 11px;
        }

        /* Navbar - Clean White */
        .navbar-custom {
            margin-left: 200px;
            background-color: var(--clean-white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            z-index: 1000;
            position: sticky;
            top: 0;
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        /* Content */
        .main-content {
            margin-left: 200px;
            transition: margin-left 0.3s;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.03);
            transition: transform 0.2s, box-shadow 0.2s;
        }


        .card-header {
            background-color: var(--clean-white);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-weight: 600;
            padding: 1rem 1.5rem;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--dark-red);
            border-color: var(--dark-red);
        }

        .btn-outline-primary {
            color: var(--primary-red);
            border-color: var(--primary-red);
            border-radius: 8px;
            font-weight: 500;
        }


        /* Hamburger Menu for Mobile */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .navbar-custom {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }
        }

        .hamburger {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-dark);
            padding: 0.5rem;
            border-radius: 8px;
        }

        .hamburger:hover {
            background-color: var(--light-red);
            color: var(--primary-red);
        }

        /* Form elements */
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(0,0,0,0.1);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-red);
            box-shadow: 0 0 0 0.25rem rgba(230, 57, 70, 0.25);
        }

        .btn-close-sidebar {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-light);
            margin-right: 0.5rem;
            margin-top: 0.75rem;
        }

        .btn-close-sidebar:hover {
            color: var(--primary-red);
            background-color: rgba(230, 57, 70, 0.1);
            border-radius: 8px;
        }

    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
@include('layouts.partials.sidebar')

<!-- Navbar -->
@include('layouts.partials.navbar')


<!-- Main Content -->
<div class="main-content" id="main-content">
    @yield('content')
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $('#toggleSidebar').on('click', function () {
        $('#sidebar').addClass('show');
    });

    $('#closeSidebar').on('click', function () {
        $('#sidebar').removeClass('show');
    });
</script>

<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @elseif (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: true
        });
    @endif
</script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>