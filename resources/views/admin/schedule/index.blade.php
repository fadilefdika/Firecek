@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="bg-white shadow-sm rounded-4 p-4 mb-4 border">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">📅 Agenda Inspeksi</h4>
            <button class="btn btn-outline-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
                + Tambah Agenda
            </button>
        </div>

        <div class="border rounded-4 overflow-hidden bg-light-subtle">
            <div id="calendar" class="bg-white p-3 rounded-4 shadow-sm"></div>
        </div>
    </div>
</div>

@include('components.add-schedule')
@include('components.edit-schedule')
@endsection

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .fc {
        font-size: 14px;
    }

    .fc-toolbar-title {
        font-size: 1.5rem;
        font-weight: 600;
    }

    .fc-daygrid-event {
        background-color: #dc3545 !important;
        border: none;
        color: #fff;
        padding: 4px 6px;
        border-radius: 6px;
        font-size: 0.75rem;
        transition: background 0.2s ease;
    }

    .fc-daygrid-event:hover {
        background-color: #c82333 !important;
        cursor: pointer;
    }

    .btn-outline-danger {
        transition: 0.2s ease;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
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
                right: 'dayGridMonth,timeGridWeek'
            },
            events: @json($schedules),
            height: "auto",
            eventClick: function(info) {
                const event = info.event;
                $('#modalEdit').modal('show');

                // Isi form
                $('#edit_id').val(event.id);
                $('#edit_title').val(event.title);

                // Format datetime-local: potong sampai menit
                const start = event.startStr ? event.startStr.slice(0, 16) : '';
                const end = event.endStr ? event.endStr.slice(0, 16) : '';
                $('#edit_start').val(start);
                $('#edit_end').val(end);

                $('#edit_jenis').val(event.extendedProps.jenis);
            }
        });

        calendar.render();
    });
</script>

@endpush
