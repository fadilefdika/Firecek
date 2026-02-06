@push('styles')
<style>
    :root {
        --primary-ams: #E11D48; /* Konsisten dengan Login */
        --primary-hover: #BE123C;
        --sidebar-bg: #ffffff;
        --text-sidebar: #475569;
        --text-active: #0f172a;
    }

    .sidebar {
        background-color: var(--sidebar-bg);
        border-right: 1px solid #e2e8f0;
        height: 100vh;
        width: 260px; /* Lebar standar industri */
        transition: all 0.3s;
    }

    .sidebar-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Logo Diperkecil sesuai permintaan */
    .sidebar .sidebar-logo {
        margin: 0 !important;     /* Hilangkan margin 1rem (orange) */
        padding: 15px 0 !important; /* Gunakan padding atas-bawah saja */
        width: 100% !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        background: transparent !important; /* Hindari background hover jika ada */
    }

    .sidebar-logo img {
        height: 10px !important; /* Sesuaikan ukuran besar yang Anda inginkan */
        width: auto;
        max-width: 75%; /* Mencegah gambar menyentuh pinggir sidebar */
    }

    .sidebar-logo span {
        font-weight: 800;
        color: #0f172a;
        font-size: 1.1rem;
        letter-spacing: -1px;
    }

    .sidebar-logo span b {
        color: var(--primary-ams);
    }

    /* Navigation Links */
    .nav-custom {
        padding: 12px;
    }

    .nav-custom .nav-link {
        color: var(--text-sidebar);
        font-size: 0.875rem; /* Font lebih snappy */
        font-weight: 500;
        padding: 10px 12px;
        border-radius: 8px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 4px;
    }

    .nav-custom .nav-link i {
        font-size: 1.1rem;
        color: #94a3b8;
    }

    .nav-custom .nav-link:hover {
        background-color: #f8fafc;
        color: var(--primary-ams);
    }

    .nav-custom .nav-link:hover i {
        color: var(--primary-ams);
    }

    /* Active State Rose-Red */
    .nav-custom .nav-link.active {
        background-color: #fef2f2;
        color: var(--primary-ams) !important;
        font-weight: 600;
    }

    .nav-custom .nav-link.active i {
        color: var(--primary-ams);
    }

    /* Dropdown / Collapse */
    .nav-dropdown-item {
        padding-left: 42px !important;
        font-size: 0.85rem !important;
        color: #64748b !important;
    }

    .nav-dropdown-item.active {
        color: var(--primary-ams) !important;
        font-weight: 600 !important;
    }

    .toggle-icon {
        font-size: 0.75rem !important;
        transition: transform 0.2s;
    }

    .rotate-180 {
        transform: rotate(180deg);
    }
</style>
@endpush

<nav class="sidebar" id="sidebar">
    <div class="sidebar-header d-flex justify-content-center align-items-center">
        <a href="{{ route('admin.apar.index') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/ams.png') }}" alt="Logo" class="img-fluid">
        </a>
        <button class="btn btn-sm d-md-none" id="closeSidebar">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="nav-custom">
        <ul class="nav flex-column">
            {{-- Inventory --}}
            <li class="nav-item">
                <a href="{{ route('admin.entities.index') }}"
                   class="nav-link {{ request()->routeIs('admin.apar.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    <span>ESD</span>
                </a>
            </li>

            {{-- Schedule --}}
            <li class="nav-item">
                <a href="{{ route('admin.schedule.index') }}"
                   class="nav-link {{ request()->routeIs('admin.schedule.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i>
                    <span>Schedule</span>
                </a>
            </li>

            {{-- Master Data Group --}}
            @php
                $isMasterActive = request()->routeIs('admin.media.*', 'admin.location.*', 'admin.schedule-type.*');
            @endphp
            <li class="nav-item">
                <a class="nav-link justify-content-between {{ $isMasterActive ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse"
                   href="#masterDataMenu"
                   role="button"
                   aria-expanded="{{ $isMasterActive ? 'true' : 'false' }}">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-folder2-open"></i>
                        <span>Master Data</span>
                    </div>
                    <i class="bi bi-chevron-down toggle-icon {{ $isMasterActive ? 'rotate-180' : '' }}"></i>
                </a>

                <div class="collapse {{ $isMasterActive ? 'show' : '' }}" id="masterDataMenu">
                    <ul class="nav flex-column">
                        <li>
                            <a href="{{ route('admin.media.index') }}"
                               class="nav-link nav-dropdown-item {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                               Media
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.location.index') }}"
                               class="nav-link nav-dropdown-item {{ request()->routeIs('admin.location.*') ? 'active' : '' }}">
                               Location
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.schedule-type.index') }}"
                               class="nav-link nav-dropdown-item {{ request()->routeIs('admin.schedule-type.*') ? 'active' : '' }}">
                               Schedule Type
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>