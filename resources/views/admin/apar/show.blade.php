@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 text-danger fw-bold">Detail APAR</h5>
                <small class="text-muted">Informasi lengkap mengenai alat pemadam api ringan</small>
            </div>
            <a href="{{ route('admin.apar.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
        </div>

        <div class="card-body">
            <div class="row">
                {{-- Kolom kiri --}}
                <div class="col-md-6 mb-3">
                    <h6 class="text-secondary fw-bold border-bottom pb-1">Spesifikasi Umum</h6>
                    <dl class="row mb-0">
                        <dt class="col-sm-5 text-muted small">Brand</dt>
                        <dd class="col-sm-7 text-dark small mb-2">{{ $apar->brand }}</dd>

                        <dt class="col-sm-5 text-muted small">Media</dt>
                        <dd class="col-sm-7 text-dark small mb-2">{{ $apar->media?->media_name }}</dd>

                        <dt class="col-sm-5 text-muted small">Type</dt>
                        <dd class="col-sm-7 text-dark small mb-2">{{ $apar->type }}</dd>

                        <dt class="col-sm-5 text-muted small">Capacity</dt>
                        <dd class="col-sm-7 text-dark small mb-2">{{ $apar->capacity }} kg</dd>
                    </dl>
                </div>

                {{-- Kolom kanan --}}
                <div class="col-md-6 mb-3">
                    <h6 class="text-secondary fw-bold border-bottom pb-1">Lokasi & Status</h6>
                    <dl class="row mb-0">
                        <dt class="col-sm-5 text-muted small">Expired Date</dt>
                        <dd class="col-sm-7 text-dark small mb-2">{{ $apar->expired_date }}</dd>

                        <dt class="col-sm-5 text-muted small">Location</dt>
                        <dd class="col-sm-7 text-dark small mb-2">{{ $apar->location?->location_name ?? '-' }}</dd>

                        <dt class="col-sm-5 text-muted small">Location Detail</dt>
                        <dd class="col-sm-7 text-dark small mb-2">{{ $apar->location_detail ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
