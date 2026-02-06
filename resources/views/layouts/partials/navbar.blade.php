<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container-fluid px-0">
        {{-- Sidebar toggle --}}
        <button class="hamburger me-3 d-md-none" id="toggleSidebar">
            <i class="bi bi-list"></i>
        </button>

        {{-- Breadcrumb Navigation --}}
        <nav aria-label="breadcrumb" class="flex-grow-1">
            <ol class="breadcrumb mb-0 ps-0">
                @php
                    $routeName = Route::currentRouteName();
                    $breadcrumbs = [];
                    
                    // Map routes to breadcrumb items
                    if (str_contains($routeName, 'admin.apar')) {
                        if ($routeName === 'admin.apar.show') {
                            // For detail page: Inventory / Brand
                            $breadcrumbs[] = ['name' => 'Inventory', 'url' => route('admin.apar.index'), 'active' => false];
                            $breadcrumbs[] = ['name' => $apar->apar_code ?? 'Detail', 'url' => '#', 'active' => true];
                        } else {
                            // For list page
                            $breadcrumbs[] = ['name' => 'Inventory', 'url' => route('admin.apar.index'), 'active' => true];
                        }
                    }
                    elseif (str_contains($routeName, 'admin.schedule')) {
                        if ($routeName === 'admin.schedule.show') {
                            // For detail page: Schedule / ID
                            $breadcrumbs[] = ['name' => 'Schedule', 'url' => route('admin.schedule.index'), 'active' => false];
                            $breadcrumbs[] = ['name' => 'Schedule #' . ($schedule->id ?? ''), 'url' => '#', 'active' => true];
                        } else {
                            // For list page
                            $breadcrumbs[] = ['name' => 'Schedule', 'url' => route('admin.schedule.index'), 'active' => true];
                        }
                    }
                    elseif (str_contains($routeName, 'admin.media')) {
                        if ($routeName === 'admin.media.show') {
                            $breadcrumbs[] = ['name' => 'Master Data', 'url' => '#', 'active' => false];
                            $breadcrumbs[] = ['name' => 'Media', 'url' => route('admin.media.index'), 'active' => false];
                            $breadcrumbs[] = ['name' => $media->media_name ?? 'Detail', 'url' => '#', 'active' => true];
                        } else {
                            $breadcrumbs[] = ['name' => 'Master Data', 'url' => '#', 'active' => false];
                            $breadcrumbs[] = ['name' => 'Media', 'url' => route('admin.media.index'), 'active' => true];
                        }
                    }
                    elseif (str_contains($routeName, 'admin.location')) {
                        if ($routeName === 'admin.location.show') {
                            $breadcrumbs[] = ['name' => 'Master Data', 'url' => '#', 'active' => false];
                            $breadcrumbs[] = ['name' => 'Location', 'url' => route('admin.location.index'), 'active' => false];
                            $breadcrumbs[] = ['name' => $location->location_name ?? 'Detail', 'url' => '#', 'active' => true];
                        } else {
                            $breadcrumbs[] = ['name' => 'Master Data', 'url' => '#', 'active' => false];
                            $breadcrumbs[] = ['name' => 'Location', 'url' => route('admin.location.index'), 'active' => true];
                        }
                    }
                    elseif (str_contains($routeName, 'admin.schedule-type')) {
                        if ($routeName === 'admin.schedule-type.show') {
                            $breadcrumbs[] = ['name' => 'Master Data', 'url' => '#', 'active' => false];
                            $breadcrumbs[] = ['name' => 'Schedule Type', 'url' => route('admin.schedule-type.index'), 'active' => false];
                            $breadcrumbs[] = ['name' => $scheduleType->type_name ?? 'Detail', 'url' => '#', 'active' => true];
                        } else {
                            $breadcrumbs[] = ['name' => 'Master Data', 'url' => '#', 'active' => false];
                            $breadcrumbs[] = ['name' => 'Schedule Type', 'url' => route('admin.schedule-type.index'), 'active' => true];
                        }
                    }
                @endphp
                
                @foreach ($breadcrumbs as $breadcrumb)
                    <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active' : '' }}">
                        @if (!$breadcrumb['active'])
                            <a href="{{ $breadcrumb['url'] }}" class="text-decoration-none">
                                {{ $breadcrumb['name'] }}
                            </a>
                        @else
                            {{ $breadcrumb['name'] }}
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>

        {{-- Spacer --}}
        <div class="ms-auto d-flex align-items-center">
            {{-- Dropdown User --}}
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
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

<style>
    .breadcrumb {
        font-size: 0.875rem;
        background-color: transparent;
        padding: 0.5rem 0;
    }

    .breadcrumb-item {
        color: #64748b;
    }

    .breadcrumb-item a {
        color: #64748b;
        transition: color 0.2s ease;
    }

    .breadcrumb-item a:hover {
        color: #E11D48;
    }

    .breadcrumb-item.active {
        color: #0f172a;
        font-weight: 600;
    }

    .breadcrumb-item i {
        margin-right: 0.4rem;
    }

    .navbar-custom {
        background-color: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 1.5rem;
    }
</style>
