<div class="mx-2 mb-4 px-3">
    <div class="timeline-container">
        @foreach($apar->aparInspections as $inspection)
            @php
                $now = now();
                $scheduleDate = \Carbon\Carbon::parse($inspection->schedule->start_date);
                $isToday = $now->isSameDay($scheduleDate);
                $isUpcoming = $scheduleDate->isFuture();
                $isPast = $scheduleDate->isPast() && !$isToday;
                $isFilled = !is_null($inspection->inspected_at);

                $statusColor = $isToday ? 'danger' 
                             : ($isUpcoming ? 'secondary' 
                             : ($isPast && !$isFilled ? 'warning' : 'success'));
                
                $statusText = $isToday ? 'Today' 
                             : ($isUpcoming ? 'Upcoming' 
                             : ($isPast && !$isFilled ? 'Overdue' : 'Completed'));
            @endphp

            <div class="timeline-item item-{{ $statusColor }}">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">
                        {{ $inspection->schedule->title }}
                    </h6>
                    <span class="text-muted small fw-medium">
                        {{ $scheduleDate->translatedFormat('d M, Y') }}
                    </span>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="small">
                        <span class="badge bg-soft-{{ $statusColor }} rounded-pill px-2 py-1 me-2" style="font-size: 0.7rem;">
                            {{ strtoupper($statusText) }}
                        </span>
                        
                        @if($isFilled)
                            <span class="text-success small">
                                <i class="far fa-check-circle me-1"></i>
                                Completed: {{ $inspection->inspected_at->translatedFormat('d M, H:i') }}
                            </span>
                        @else
                            <span class="text-muted small">No inspection yet</span>
                        @endif
                    </div>

                    @if($isToday && !$isFilled)
                        <a href="{{ route('admin.apar.checklist', ['id' => $inspection->apar_id, 'inspection_schedule_id' => $inspection->inspection_schedule_id]) }}"
                           class="btn btn-sm btn-danger py-0 px-3 fw-bold shadow-sm" style="font-size: 0.75rem; height: 24px; line-height: 24px;">
                            Inspect Now
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    /* Container utama timeline */
    .timeline-container {
        list-style-type: none;
        position: relative;
        padding-left: 0;
    }

    /* Garis Vertikal */
    .timeline-container:before {
        content: ' ';
        background: #d4d9df;
        display: inline-block;
        position: absolute;
        left: 9px; /* Menyesuaikan posisi garis */
        width: 2px;
        height: 100%;
        z-index: 1;
    }

    .timeline-item {
        margin: 25px 0;
        padding-left: 35px; /* Jarak teks dari garis */
        position: relative;
    }

    /* Titik Bulat (Dot) */
    .timeline-item:before {
        content: ' ';
        background: white;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #cbd5e0; /* Default color */
        left: 0;
        width: 20px;
        height: 20px;
        z-index: 2;
        top: 0;
    }

    /* Varian Warna Dot Berdasarkan Status */
    .item-danger:before { border-color: #dc3545; }
    .item-success:before { border-color: #198754; }
    .item-warning:before { border-color: #ffc107; }
    .item-secondary:before { border-color: #6c757d; }

    /* Utility untuk Badge Soft */
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); color: #198754; }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); color: #997404; }
    .bg-soft-secondary { background-color: rgba(108, 117, 125, 0.1); color: #6c757d; }
</style>