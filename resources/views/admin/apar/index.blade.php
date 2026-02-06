@extends('layouts.app')

@push('styles')
<style>
    #apar-table_wrapper {
        font-size: 0.9rem;
    }

    #apar-table thead th {
        font-size: 0.875rem;
        background-color: #fff;
        font-weight: 600;
    }

    #apar-table tbody td {
        font-size: 0.85rem;
        vertical-align: middle;
    }

    .dataTables_length label,
    .dataTables_filter label {
        font-size: 0.85rem;
        font-weight: 500;
    }
    .dataTables_filter input {
        padding: 0.3rem 0.6rem;
        border-radius: 0.375rem;
        border: 1px solid #ccc;
    }

    .dataTables_length select {
        -webkit-appearance: none; /* untuk Safari/Chrome */
        -moz-appearance: none;    /* untuk Firefox */
        appearance: none;         /* untuk standar */
        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%204%205'%3E%3Cpath%20fill='black'%20d='M2%205L0%203h4L2%205z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        background-size: 10px;
        padding-right: 1.5rem;
    }


    .dataTables_paginate,
    .dataTables_info {
        font-size: 0.85rem;
    }

    /* Table striping enhancement */
    .table-striped > tbody > tr:nth-of-type(odd) {
        --bs-table-accent-bg: #fdf2f2;
    }

    /* Button hover effect */
    .btn-apar {
        background-color: #d32f2f;
        color: white;
        transition: 0.3s ease;
    }

    .btn-apar:hover {
        background-color: #b71c1c;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 text-danger fw-semibold">APAR Dashboard</h5>
                <small class="text-muted">Fire extinguisher inventory management system</small>
            </div>
            <button class="btn btn-apar btn-sm rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-apar">
                Add Data
            </button>
        </div>
        
        <div class="card-body pb-3 px-3">
            <div class="table-responsive">
                <table id="apar-table" class="table table-striped table-hover align-middle nowrap w-100">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Brand</th>
                            <th>Media</th>
                            <th>Type</th>
                            <th>Capacity (kg)</th>
                            <th>Gross Weight (kg)</th>
                            <th>Expired Date</th>
                            <th>Location </th>
                            <th>Location Detail</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@include('components.add-modal')  

@push('scripts')

<script>
$(function () {
    $('#apar-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.apar.data") }}',
        columns: [
            { 
                data: null, 
                name: 'no', 
                orderable: false, 
                searchable: false, 
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'brand', name: 'brand' },
            { data: 'media_id', name: 'media_id' },  // use alias from addColumn
            { data: 'type', name: 'type' },
            { 
                data: 'capacity', 
                name: 'capacity',
                render: function (data) {
                    if (data === null || data === '') return '-';
                    const num = parseFloat(data);
                    return num % 1 === 0 ? Math.floor(num) : num.toLocaleString('id-ID');
                }
            },
            { 
                data: 'gross_weight', 
                name: 'gross_weight',
                orderable: false,   // WAJIB: Karena ini hasil matematis, bukan kolom DB
                searchable: false,   // WAJIB
                render: function (data) {
                    if (data === null || data === '') return '-';
                    return parseFloat(data).toLocaleString('id-ID');
                }
            },
            { data: 'expired_date', name: 'expired_date' },
            { data: 'location_id', name: 'location_id' }, // use alias from addColumn
            { data: 'location_detail', name: 'location_detail' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        responsive: true
    });
});
</script>

<script>
    $('#addAparBtn').on('click', function () {
        const form = $('#form-apar');
        form.trigger('reset');
        form.attr('action', '{{ route("admin.apar.store") }}');
        $('#methodField').val('POST');

        // Reset all dropdowns
        form.find('select').val('').trigger('change');

        // Change display
        $('#modal-apar-label').text('Add APAR Data');
        $('#modal-apar button[type="submit"]').text('Save');

        $('#modal-apar').modal('show');
    });
</script>


<script>
    $('#modal-apar').on('show.bs.modal', function () {
    const form = $('#form-apar');
    const mode = form.data('mode');

    if (mode === 'create') {
        form.trigger('reset');
        form.find('input[name="_method"]').remove();
        form.find('select').each(function () {
        $(this).val('').trigger('change');
        $(this).find('option[selected]').prop('selected', true);
        });
    }
    });
</script>

@endpush
