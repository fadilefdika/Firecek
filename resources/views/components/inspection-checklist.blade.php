<div class="bg-white rounded-3 p-4 shadow-sm mb-4 mx-2">
    <div class="d-flex align-items-center mb-3">
        <div class="bg-danger bg-opacity-10 p-2 rounded-circle me-3">
            <i class="fas fa-clipboard-check text-danger fs-5"></i>
        </div>
        <div>
            <h5 class="text-dark fw-semibold mb-0">Riwayat Inspeksi APAR</h5>
        </div>
    </div>

    <div class="timeline ps-3">
        @foreach($apar->aparInspections as $inspection)
            @php
                $now = now();
                $scheduleDate = \Carbon\Carbon::parse($inspection->schedule->start_date);
                $isToday = $now->isSameDay($scheduleDate);
                $isUpcoming = $scheduleDate->isFuture();
                $isPast = $scheduleDate->isPast() && !$isToday;
                $isFilled = !is_null($inspection->inspected_at);
                
                // Status configuration
                $statusConfig = [
                    'color' => $isToday ? 'danger' : 
                              ($isUpcoming ? 'secondary' : 
                              ($isPast && !$isFilled ? 'warning' : 'success')),
                    'icon' => $isToday ? 'exclamation-circle' : 
                            ($isUpcoming ? 'clock' : 
                            ($isPast && !$isFilled ? 'exclamation-triangle' : 'check-circle')),
                    'text' => $isToday ? 'Hari Ini' : 
                             ($isUpcoming ? 'Akan Datang' : 
                             ($isPast && !$isFilled ? 'Terlambat' : 'Selesai'))
                ];
            @endphp

            <div class="timeline-item mb-4 position-relative">
                <div class="timeline-badge bg-{{ $statusConfig['color'] }}"></div>
                
                <div class="card border-0 shadow-xs">
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-2 mb-md-0">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <span class="badge bg-{{ $statusConfig['color'] }}-soft text-{{ $statusConfig['color'] }} rounded-pill py-1 px-2 small">
                                            <i class="fas fa-{{ $statusConfig['icon'] }} me-1"></i> {{ $statusConfig['text'] }}
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">{{ $inspection->schedule->title }}</h6>
                                        <div class="text-muted small">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            {{ $scheduleDate->translatedFormat('d M Y') }}
                                            @if($isFilled)
                                                <span class="ms-2 text-success">
                                                    <i class="far fa-check-circle me-1"></i>
                                                    {{ $inspection->inspected_at->translatedFormat('d M Y H:i') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 text-md-end">
                                @if($isToday && !$isFilled)
                                    <a href="{{ route('admin.apar.checklist', ['id' => $inspection->apar_id, 'inspection_schedule_id' => $inspection->inspection_schedule_id]) }}" 
                                       class="btn btn-sm btn-danger rounded-pill px-3 py-1">
                                        <i class="fas fa-pen me-1"></i> Isi Sekarang
                                    </a>
                                @elseif(!$isFilled && !$isUpcoming)
                                    <span class="badge bg-warning-soft text-warning py-2 px-3">
                                        <i class="fas fa-exclamation-triangle me-1"></i> Perlu Tindakan
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .timeline {
        position: relative;
        border-left: 2px dashed #e9ecef;
        margin-left: 12px;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 16px;
    }
    
    .timeline-badge {
        position: absolute;
        left: -20px;
        top: 24px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 3px solid white;
        z-index: 2;
        box-shadow: 0 0 0 2px var(--bs-border-color);
    }
    
    .shadow-xs {
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    
    .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.08);
    }
    
    .bg-secondary-soft {
        background-color: rgba(108, 117, 125, 0.08);
    }
    
    .bg-warning-soft {
        background-color: rgba(255, 193, 7, 0.08);
    }
    
    .bg-success-soft {
        background-color: rgba(25, 135, 84, 0.08);
    }
    
    .card-body {
        padding: 1rem;
    }
    
    @media (max-width: 768px) {
        .timeline {
            margin-left: 8px;
        }
        
        .timeline-badge {
            left: -16px;
            top: 20px;
            width: 12px;
            height: 12px;
        }
    }
</style>