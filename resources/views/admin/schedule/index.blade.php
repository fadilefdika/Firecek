@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        
        <div class="card-header bg-white py-3 px-3 border-bottom-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-0 text-dark" style="font-size: 1rem;">
                        <i class="fas fa-calendar-alt text-danger me-2"></i>Inspection Agenda
                    </h5>
                </div>
                <button class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold" 
                        style="font-size: 0.7rem; border-width: 1.5px;" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalTambah">
                    <i class="fas fa-plus me-1"></i> Add Agenda
                </button>
            </div>
        </div>

        <div class="card-body p-2 pt-0">
            <div id="calendar"></div>
        </div>
    </div>
</div>
@include('components.add-schedule')
@include('components.edit-schedule')
@endsection

@push('styles')
<style>
    /* Reset & Font */
    body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
    
    /* Kalender Ringkas */
    .fc { font-size: 11px; } /* Ukuran font lebih kecil */
    .fc .fc-toolbar-title { font-size: 0.9rem !important; font-weight: 700; color: #1e293b; }
    .fc .fc-button { padding: 2px 6px !important; font-size: 0.7rem !important; }
    
    /* Event Styling */
    .fc-daygrid-event {
        background-color: #dc3545 !important;
        border: none !important;
        border-radius: 4px !important;
        padding: 1px 4px !important;
        margin-top: 1px !important;
    }

    /* Grid Line agar lebih halus */
    .fc-theme-standard td, .fc-theme-standard th { border-color: #f1f5f9 !important; }
    
    /* Header table kalender (Mon, Tue, etc) */
    .fc-col-header-cell-cushion { color: #64748b; text-decoration: none !important; font-weight: 600; }
    .fc-event {
        cursor: pointer !important;
    }

    /* Opsional: Memberikan efek sedikit lebih terang saat di-hover agar lebih informatif */
    .fc-event:hover {
        filter: brightness(90%);
        transition: 0.2s;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'standard',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth' // Hanya tampilkan bulan dan list agar compact
            },
            
            // Format Waktu 24 Jam
            eventTimeFormat: { 
                hour: '2-digit', minute: '2-digit', hour12: false 
            },

            // Kustomisasi Judul (HH:mm | Title)
            eventContent: function(arg) {
                let timeText = arg.timeText; 
                let titleText = arg.event.title; 
                
                let container = document.createElement('div');
                container.classList.add('d-flex', 'align-items-center');
                container.style.overflow = 'hidden';
                container.style.whiteSpace = 'nowrap';
                // --- TAMBAHKAN BARIS INI ---
                container.style.color = '#ffffff'; 
                
                container.innerHTML = `
                    <span style="font-weight: 800; font-family: monospace;">${timeText}</span>
                    <span style="margin: 0 4px; opacity: 0.7;">|</span>
                    <span style="text-overflow: ellipsis; overflow: hidden;">${titleText}</span>
                `;
                
                return { domNodes: [container] };
            },

            events: @json($schedules),
            height: "auto",
            eventClick: function(info) {
                window.location.href = `/admin/schedule/${info.event.id}`;
            }
        });

        calendar.render();
    });
</script>
@endpush