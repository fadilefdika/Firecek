@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="bg-white rounded-3 p-4 shadow-sm">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1 fw-semibold">Detail Agenda Pemeriksaan</h4>
                <p class="text-muted small mb-0">Rincian jadwal dan status pemeriksaan APAR</p>
            </div>
            <a href="{{-- route('admin.schedule.edit', $schedule->id) --}}" class="btn btn-sm btn-light border">
                <i class="fas fa-edit me-1"></i> Edit Agenda
            </a>
        </div>

        {{-- Schedule Details --}}
        <div class="mb-4 p-3 bg-light rounded-2">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-start mb-2">
                        <i class="fas fa-heading text-muted mt-1 me-2" style="width: 20px;"></i>
                        <div>
                            <small class="text-muted d-block">Judul</small>
                            <div class="fw-medium">{{ $schedule->title }}</div>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start mb-2">
                        <i class="fas fa-tag text-muted mt-1 me-2" style="width: 20px;"></i>
                        <div>
                            <small class="text-muted d-block">Jenis</small>
                            <div class="fw-medium">{{ $schedule->typeRelation->schedule_name }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="d-flex align-items-start mb-2">
                        <i class="fas fa-clock text-muted mt-1 me-2" style="width: 20px;"></i>
                        <div>
                            <small class="text-muted d-block">Mulai</small>
                            <div class="fw-medium">
                                {{ \Carbon\Carbon::parse($schedule->start_date.' '.$schedule->start_time)->translatedFormat('l, d F Y H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-start">
                        <i class="fas fa-clock text-muted mt-1 me-2" style="width: 20px;"></i>
                        <div>
                            <small class="text-muted d-block">Selesai</small>
                            <div class="fw-medium">
                                {{ \Carbon\Carbon::parse($schedule->end_date.' '.$schedule->end_time)->translatedFormat('l, d F Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Inspection Status --}}
        <div class="border rounded-2 overflow-hidden">
            <div class="p-3 border-bottom bg-light">
                <h6 class="mb-0 fw-semibold d-flex align-items-center">
                    <i class="fas fa-clipboard-list me-2 text-primary"></i>
                    Status Pemeriksaan APAR
                </h6>
            </div>
            
            <div class="overflow-auto">
                <table class="table mb-0">
                    <thead>
                        <tr class="text-muted small">
                            <th class="border-0 ps-4">Lokasi</th>
                            <th class="border-0">Detail</th>
                            <th class="border-0">Brand</th>
                            <th class="border-0">Media</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 pe-4">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($schedule->aparInspections as $inspection)
                            <tr class="border-top">
                                <td class="ps-4">{{ $inspection->apar->location->location_name }}</td>
                                <td>{{ $inspection->apar->location_detail }}</td>
                                <td>{{ $inspection->apar->brand }}</td>
                                <td>{{ $inspection->apar->media->media_name }}</td>
                                <td>
                                    @if ($inspection->is_checked)
                                        <span class="badge bg-success bg-opacity-10 text-success">✓ Selesai</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning">Belum</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-muted">{{ $inspection->note ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr class="border-top">
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox me-2"></i> Belum ada data inspeksi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
