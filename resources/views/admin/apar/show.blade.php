@extends('layouts.app')

@push('styles')
<style>
    .info-card {
        border: 1px solid #c9cdd1;
        background: #fff;
        border-radius: 12px;
        padding: 12px 15px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .info-label {
        font-size: 0.65rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }
    .info-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
    }
    .status-banner-compact {
        border-radius: 10px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .btn-qr-soft {
        background-color: rgba(13, 110, 253, 0.05); /* Warna primary sangat transparan */
        border: 1px solid rgba(13, 110, 253, 0.2);
        color: #0d6efd;
        font-weight: 600;
        font-size: 0.75rem;
        height: 30px; /* Samakan dengan tombol Back/Edit sebelumnya */
        padding: 0 12px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-qr-soft:hover {
        background-color: #0d6efd;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(13, 110, 253, 0.15);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3 px-lg-5 compact-page">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        
        <div class="card-header bg-white py-3 px-4 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="badge bg-light text-dark border mb-1" style="font-family: monospace;">#{{ $apar->apar_code ?? $apar->id }}</div>
                    <h5 class="fw-bold mb-0 text-dark">Unit Information</h5>
                </div>
                <div class="d-flex gap-2">
                    <button
                        type="button"
                        class="btn btn-light btn-sm border px-3 d-flex align-items-center"
                        onclick="window.location.href='{{ route('admin.apar.index') }}'">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </button>

                    <button
                        type="button"
                        class="btn btn-primary btn-sm px-3 d-flex align-items-center"
                        data-bs-toggle="modal"
                        data-bs-target="#editAparModal">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="status-banner-compact mb-4 {{ $apar->is_expired ? 'bg-soft-danger border border-danger' : 'bg-soft-success border border-success' }}">
                <div class="fs-3 {{ $apar->is_expired ? 'text-danger' : 'text-success' }}">
                    <i class="fas {{ $apar->is_expired ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                </div>
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div>
                        <h6 class="mb-0 fw-bold {{ $apar->is_expired ? 'text-danger' : 'text-success' }}">
                            {{ $apar->is_expired ? 'EXPIRED - NEEDS REFILL' : 'READY TO USE' }}
                        </h6>
                        <small class="text-muted">Last inspection: {{ $apar->updated_at->format('d M Y') }}</small>
                    </div>
                    <button class="btn btn-sm d-inline-flex align-items-center btn-qr-soft shadow-sm" 
                            onclick="window.location.href='{{ route('admin.apar.qrcode', $apar->id) }}'">
                        <i class="fas fa-qrcode me-2"></i>
                        <span>View QR Code</span>
                    </button>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6 col-md-4">
                    <div class="info-card">
                        <span class="info-label">Brand / Merk</span>
                        <span class="info-value">{{ $apar->brand }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="info-card">
                        <span class="info-label">Capacity</span>
                        <span class="info-value">{{ $apar->capacity }} <small class="text-muted">kg</small></span>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="info-card">
                        <span class="info-label">Gross Weight</span>
                        <span class="info-value">{{ $apar->gross_weight }} <small class="text-muted">kg</small></span>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="info-card">
                        <span class="info-label">Media Type</span>
                        <span class="info-value">{{ $apar->media?->media_name ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="info-card">
                        <span class="info-label">Unit Type</span>
                        <span class="info-value">{{ $apar->type ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="info-card">
                        <span class="info-label">Expired Date</span>
                        <span class="info-value {{ $apar->is_expired ? 'text-danger' : 'text-success' }}">
                            {{ \Carbon\Carbon::parse($apar->expired_date)->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-light p-3 rounded-3 border mb-4">
                <h6 class="fw-bold mb-3"><i class="fas fa-map-marker-alt text-danger"></i>Unit Placement</h6>
                <div class="row align-items-center">
                    <div class="col-md-6 border-end">
                        <small class="text-muted d-block">Main Location</small>
                        <span class="fw-bold" style="font-size: 0.85rem;">{{ $apar->location?->location_name ?? 'Unassigned' }}</span>
                    </div>
                    <div class="col-md-6 ps-md-4 mt-2 mt-md-0">
                        <small class="text-muted d-block">Specific Detail</small>
                        <span class="fw-medium" style="font-size: 0.75rem">{{ $apar->location_detail ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-top">
                <h6 class="fw-bold text-dark mb-4 text-uppercase small" style="letter-spacing: 1px;">
                    <i class="fas fa-history me-2 text-primary"></i>Inspection Timeline
                </h6>
                
                @if($apar->aparInspections->isNotEmpty())
                    @include('components.inspection-checklist')
                @else
                    <div class="text-center py-4 bg-light rounded-3 border border-dashed">
                        <p class="text-muted small mb-0">No past activity recorded.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('components.edit-apar')
@endsection