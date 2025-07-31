<div>
    <h5 class="text-primary fw-semibold mb-3">
        <i class="fas fa-tasks me-2"></i> Riwayat Jadwal Inspeksi
    </h5>

    <div class="timeline">
        @foreach($apar->aparInspections as $inspection)
            @php
                $now = now();
                $scheduleDate = \Carbon\Carbon::parse($inspection->schedule->start_date);
                $isToday = $now->isSameDay($scheduleDate);
                $isUpcoming = $scheduleDate->isFuture();
                $isPast = $scheduleDate->isPast() && !$isToday;
    
                $isFilled = !is_null($inspection->inspected_at); 
            @endphp
    
            <div class="timeline-item mb-4 
                        border-start border-4 
                        {{ $isToday ? 'border-danger bg-light' : ($isUpcoming ? 'border-secondary bg-white' : 'border-success bg-white') }} 
                        p-3 rounded shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $inspection->schedule->title }}</strong><br>
                        <small class="text-muted">Tanggal: {{ $scheduleDate->format('d M Y') }}</small>
                    </div>
    
                    @if($isToday && !$isFilled)
                        <a href="#{{-- route('admin.inspection.checklist', $inspection->id) --}}" class="btn btn-sm btn-danger">
                            Isi Checklist
                        </a>
                    @elseif($isUpcoming)
                        <span class="badge bg-secondary">Belum waktunya</span>
                    @elseif($isPast && !$isFilled)
                        <span class="badge bg-warning text-dark">Terlambat</span>
                    @elseif($isFilled)
                        <span class="badge bg-success">Sudah diisi</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
</div>

<style>
    .timeline {
        border-left: 2px solid #dee2e6;
        margin-left: 10px;
        padding-left: 15px;
    }
    .timeline-item {
        position: relative;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        top: 0.75rem;
        left: -12px;
        width: 12px;
        height: 12px;
        background-color: #6c757d;
        border-radius: 50%;
    }
    .timeline-item.border-danger::before {
        background-color: #dc3545;
    }
    .timeline-item.border-secondary::before {
        background-color: #6c757d;
    }
</style>
