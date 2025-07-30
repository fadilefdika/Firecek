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
            
            <div class="overflow-auto p-3">
                <table class="table mb-0" id="inspections-table">
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
                </table>
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
            { data: 'lokasi', name: 'lokasi', className: 'ps-4' },
            { data: 'detail', name: 'detail' },
            { data: 'brand', name: 'brand' },
            { data: 'media', name: 'media' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'note', name: 'note', className: 'pe-4 text-muted' },
        ],
        language: {
            lengthMenu: 'Tampilkan _MENU_ entri',
            zeroRecords: 'Tidak ada data ditemukan',
            info: 'Menampilkan _START_ - _END_ dari _TOTAL_ entri',
            infoEmpty: 'Tidak ada entri tersedia',
            infoFiltered: '(disaring dari _MAX_ total entri)',
            search: 'Cari:',
            paginate: {
                next: 'Berikutnya',
                previous: 'Sebelumnya'
            }
        },
        pageLength: 10
    });
});
</script>
@endpush

