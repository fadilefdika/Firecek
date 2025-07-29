<nav class="sidebar" id="sidebar">
    {{-- Header Sidebar --}}
    <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
        <div class="logo d-flex align-items-center">
            <i class="bi bi-fire-extinguisher me-2 fs-4"></i>
            <span class="fw-bold">Admin Panel</span>
        </div>
        <button class="btn btn-sm d-md-none" id="closeSidebar" aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    {{-- Main Navigation --}}
    <ul class="nav flex-column px-2 mt-3">

        {{-- Inventory --}}
        <li class="nav-item">
            <a href="{{ route('admin.apar.index') }}"
               class="nav-link d-flex align-items-center {{ request()->routeIs('admin.apar.index') ? 'active' : '' }}">
                <i class="bi bi-table me-2"></i>
                <span>Inventory</span>
            </a>
        </li>

        {{-- Schedule --}}
        <li class="nav-item">
            <a href="{{ route('admin.schedule.index') }}"
               class="nav-link d-flex align-items-center {{ request()->routeIs('admin.schedule.index') ? 'active' : '' }}">
                <i class="bi bi-calendar-event me-2"></i>
                <span>Schedule</span>
            </a>
        </li>

        {{-- Master Data --}}
        @php
            $isMasterActive = request()->routeIs('admin.media.*', 'admin.location.*', 'admin.schedule-type.*');
        @endphp
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center justify-content-between {{ $isMasterActive ? '' : 'collapsed' }}"
               data-bs-toggle="collapse"
               href="#masterDataMenu"
               role="button"
               aria-expanded="{{ $isMasterActive ? 'true' : 'false' }}"
               aria-controls="masterDataMenu">
                <div>
                    <i class="bi bi-database me-2"></i>
                    <span>Master Data</span>
                </div>
                <i class="bi bi-chevron-down toggle-icon {{ $isMasterActive ? 'rotate-180' : '' }}"></i>
            </a>

            <div class="collapse {{ $isMasterActive ? 'show' : '' }}" id="masterDataMenu">
                <ul class="nav flex-column ps-4">
                    <li class="nav-item">
                        <a href="{{ route('admin.media.index') }}"
                           class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                            <i class="bi bi-play-btn me-2"></i> Media
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.location.index') }}"
                           class="nav-link {{ request()->routeIs('admin.location.*') ? 'active' : '' }}">
                            <i class="bi bi-geo-alt me-2"></i> Location
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.schedule-type.index') }}"
                           class="nav-link {{ request()->routeIs('admin.schedule-type.*') ? 'active' : '' }}">
                            <i class="bi bi-calendar2-range me-2"></i> Schedule Type
                        </a>
                    </li>
                </ul>
            </div>
        </li>

    </ul>
</nav>
