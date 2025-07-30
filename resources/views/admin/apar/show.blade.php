@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-lg">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h5 class="mb-1 text-danger fw-bold">
                    <i class="fas fa-fire-extinguisher"></i> Detail APAR
                </h5>
                <p class="small text-muted mb-0">
                    Informasi lengkap mengenai alat pemadam api ringan
                </p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.apar.index') }}" class="btn btn-sm btn-light border">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#editAparModal">
                    <i class="fas fa-edit me-1"></i>Edit
                </button>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="row g-4">
                <!-- Kolom kiri -->
                <div class="col-md-6">
                    <div class="bg-light p-3 rounded h-100">
                        <h6 class="text-primary fw-semibold mb-3 d-flex align-items-center">
                            <i class="fas fa-info-circle me-2"></i> Spesifikasi Umum
                        </h6>
                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item bg-transparent d-flex justify-content-between py-2 px-0">
                                <span class="text-muted">Brand</span>
                                <span class="fw-medium text-end text-break">{{ $apar->brand }}</span>
                            </li>
                            <li class="list-group-item bg-transparent d-flex justify-content-between py-2 px-0">
                                <span class="text-muted">Media</span>
                                <span class="fw-medium text-end text-break">{{ $apar->media?->media_name }}</span>
                            </li>
                            <li class="list-group-item bg-transparent d-flex justify-content-between py-2 px-0">
                                <span class="text-muted">Type</span>
                                <span class="fw-medium text-end text-break">{{ $apar->type }}</span>
                            </li>
                            <li class="list-group-item bg-transparent d-flex justify-content-between py-2 px-0">
                                <span class="text-muted">Capacity</span>
                                <span class="fw-medium text-end">{{ $apar->capacity }} kg</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Kolom kanan -->
                <div class="col-md-6">
                    <div class="bg-light p-3 rounded h-100">
                        <h6 class="text-primary fw-semibold mb-3 d-flex align-items-center">
                            <i class="fas fa-map-marker-alt me-2"></i> Lokasi & Status
                        </h6>
                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item bg-transparent d-flex justify-content-between py-2 px-0">
                                <span class="text-muted">Expired Date</span>
                                <span class="fw-medium text-end {{ $apar->is_expired ? 'text-danger' : 'text-success' }}">
                                    {{ $apar->expired_date }}
                                    @if($apar->is_expired)
                                        <i class="fas fa-exclamation-circle ms-1"></i>
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item bg-transparent d-flex justify-content-between py-2 px-0">
                                <span class="text-muted">Location</span>
                                <span class="fw-medium text-end text-break">{{ $apar->location?->location_name ?? '-' }}</span>
                            </li>
                            <li class="list-group-item bg-transparent d-flex justify-content-between py-2 px-0">
                                <span class="text-muted">Location Detail</span>
                                <span class="fw-medium text-end text-break">{{ $apar->location_detail ?? '-' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center flex-wrap">
                <div class="small text-muted">
                    <i class="fas fa-clock me-1"></i> Terakhir diperbarui: {{ $apar->updated_at->format('d M Y H:i') }}
                </div>
            
                <div class="mt-2 mt-md-0">
                    <a href="{{ route('admin.apar.qrcode', $apar->id) }}" 
                       target="_blank"
                       class="btn btn-sm btn-success d-inline-flex align-items-center">
                        <i class="fas fa-qrcode me-1"></i> Generate QR Code
                    </a>
                </div>
            </div>            
        </div>
    </div>
</div>

@include('components.edit-apar')

@include('components.inspection-checklist', ['questions' => $questions])

@endsection

