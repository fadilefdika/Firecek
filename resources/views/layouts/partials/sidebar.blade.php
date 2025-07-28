<div class="sidebar" id="sidebar">
    <div class="d-flex justify-content-between align-items-center px-3">
        <div class="logo d-flex align-items-center">
            <i class="bi bi-fire-extinguisher"></i>Admin Panel
        </div>
        <button class="btn-close-sidebar d-md-none" id="closeSidebar" aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <a href="{{ route('admin.apar.index') }}" class="{{ request()->routeIs('admin.apar.index') ? 'active' : '' }}">
        <i class="bi bi-table"></i> Data APAR
    </a>
</div>
