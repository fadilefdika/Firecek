@extends('layouts.app')

@push('styles')
<style>
    .compact-detail { font-size: 0.85rem; }
    .compact-detail h5 { font-size: 1.1rem; }
    .compact-detail .card-header { padding: 0.75rem 1.25rem; }
    
    /* Indikator Label Kecil */
    .label-sub { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; color: #94a3b8; }
    .value-main { font-weight: 600; color: #1e293b; }

    /* Table Precision */
    #inspections-table { font-size: 0.8rem; }
    #inspections-table thead th { background-color: #f8fafc; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 0.5px; }
    
    .btn-compact { font-size: 0.75rem; padding: 0.4rem 0.8rem; border-radius: 6px; }
    .icon-box { width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; background: #f1f5f9; border-radius: 6px; }
</style>
@endpush

@section('content')
<div class="container py-3 compact-detail">
    {{-- Breadcrumb / Back Button --}}
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <button type="button" class="btn btn-white btn-compact border shadow-sm d-flex align-items-center" 
                onclick="window.location.href='{{ route('admin.schedule.index') }}'">
            <i class="fas fa-arrow-left me-2 text-muted"></i> Back to Agenda
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        
        {{-- Main Header --}}
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3 bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Inspection Agenda Details</h5>
                        <p class="text-muted small mb-0">Agenda ID: #SCH-{{ str_pad($schedule->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
                <a href="{{-- route('admin.schedule.edit', $schedule->id) --}}" class="btn btn-white btn-compact border shadow-sm">
                    <i class="fas fa-edit me-1 text-primary"></i> Edit
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            {{-- Info Banner --}}
            <div class="p-3 border-bottom bg-opacity-50">
                <div class="row g-3">
                    <div class="col-md-3 border-end">
                        <small class="label-sub d-block mb-1">Agenda Title</small>
                        <div class="value-main">{{ $schedule->title }}</div>
                    </div>
                    <div class="col-md-2 border-end text-center">
                        <small class="label-sub d-block mb-1">Type</small>
                        <span class="badge bg-soft-primary text-primary px-2 py-1 rounded-pill" style="font-size: 0.7rem;">
                            {{ $schedule->typeRelation->schedule_name }}
                        </span>
                    </div>
                    <div class="col-md-3 border-end">
                        <small class="label-sub d-block mb-1"><i class="far fa-clock me-1"></i> Start Time</small>
                        <div class="value-main text-dark">{{ \Carbon\Carbon::parse($schedule->start_date.' '.$schedule->start_time)->translatedFormat('d M Y, H:i') }}</div>
                    </div>
                    <div class="col-md-3">
                        <small class="label-sub d-block mb-1"><i class="far fa-clock me-1"></i> End Time</small>
                        <div class="value-main text-dark">{{ \Carbon\Carbon::parse($schedule->end_date.' '.$schedule->end_time)->translatedFormat('d M Y, H:i') }}</div>
                    </div>
                </div>
            </div>

            {{-- Table Section --}}
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-layer-group me-2 text-muted"></i>APAR Unit List</h6>
                    {{-- <div class="text-muted small">Real-time status of assigned units</div> --}}
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle border rounded-3 overflow-hidden" id="inspections-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="ps-3">Location</th>
                                <th>Location Detail</th>
                                <th>Unit Brand</th>
                                <th>Media</th>
                                <th class="text-center">Status</th>
                                <th class="pe-3">Officer Notes</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
$(document).ready(function () {
    $('#inspections-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.schedule.inspections", $schedule->id) }}',
        columns: [
            { data: 'lokasi', name: 'lokasi', className: 'ps-3 fw-semibold' },
            { data: 'detail', name: 'detail' },
            { data: 'brand', name: 'brand' },
            { data: 'media', name: 'media' },
            { data: 'status', name: 'status', className: 'text-center', orderable: false, searchable: false },
            { data: 'note', name: 'note', className: 'pe-3 text-muted italic' },
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search units...",
            lengthMenu: "_MENU_",
            info: "Showing _START_ to _END_ of _TOTAL_ units",
            paginate: {
                next: '<i class="fas fa-chevron-right"></i>',
                previous: '<i class="fas fa-chevron-left"></i>'
            }
        },
        pageLength: 10,
        dom: '<"d-flex justify-content-between align-items-center mb-3"f>rt<"d-flex justify-content-between align-items-center mt-3"ip>'
    });
});
</script>
@endpush

