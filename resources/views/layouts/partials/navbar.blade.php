<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container-fluid px-0">
        {{-- Sidebar toggle --}}
        <button class="hamburger me-3 d-md-none" id="toggleSidebar">
            <i class="bi bi-list"></i>
        </button>

        {{-- Breadcrumb or Title --}}
        <span class="navbar-text fw-semibold text-dark">
            @yield('breadcrumb', 'Dashboard')
        </span>

        {{-- Spacer --}}
        <div class="ms-auto d-flex align-items-center">
            {{-- Dropdown User --}}
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    {{-- @php
                        dd(Auth::user());
                    @endphp --}}
                    <span class="fw-semibold">{{ Auth::guard('admin')->user()->username ?? 'User' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
