<div class="sidebar" id="sidebar">
    <div class="d-flex justify-content-between align-items-center px-3">
        <div class="logo d-flex align-items-center">
            <i class="bi bi-fire-extinguisher me-2"></i>
            <span>Admin Panel</span>
        </div>
        <button class="btn-close-sidebar d-md-none" id="closeSidebar" aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <a href="{{ route('admin.apar.index') }}"
       class="{{ request()->routeIs('admin.apar.index') ? 'active' : '' }}">
        <i class="bi bi-table me-2"></i>
        <span>Data APAR</span>
    </a>

    <a href="{{ route('admin.schedule.index') }}"
       class="{{ request()->routeIs('admin.schedule.index') ? 'active' : '' }}">
        <i class="bi bi-calendar-event me-2"></i>
        <span>Schedule</span>
    </a>
</div>
