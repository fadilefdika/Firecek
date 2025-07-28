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

    .dataTables_length select,
    .dataTables_filter input {
        padding: 0.3rem 0.6rem;
        border-radius: 0.375rem;
        border: 1px solid #ccc;
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
                <h5 class="mb-0 text-danger fw-semibold">Dashboard APAR</h5>
                <small class="text-muted">Manajemen data alat pemadam api ringan</small>
            </div>
            <button class="btn btn-apar btn-sm rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-apar">
                Tambah Data
            </button>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="apar-table" class="table table-striped table-hover align-middle nowrap w-100">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Brand</th>
                            <th>Media</th>
                            <th>Type</th>
                            <th>Capacity (kg)</th>
                            <th>Expired Date</th>
                            <th>Location ID</th>
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

@include('components.info-modal')


@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function () {
    $('#apar-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.apar.data") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'brand', name: 'brand' },
            { data: 'media_id', name: 'media_id' },  // gunakan alias dari addColumn
            { data: 'type', name: 'type' },
            { data: 'capacity', name: 'capacity' },
            { data: 'expired_date', name: 'expired_date' },
            { data: 'location_id', name: 'location_id' }, // gunakan alias dari addColumn
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

        // Reset semua dropdown
        form.find('select').val('').trigger('change');

        // Ubah tampilan
        $('#modal-apar-label').text('Tambah Data APAR');
        $('#modal-apar button[type="submit"]').text('Simpan');

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

<script>
    let currentAparId = null;
    
    $(document).on('click', '.btn-detail', function () {
        const id = $(this).data('id');
        currentAparId = id;
    
        let url = `{{ route('admin.apar.show', ':id') }}`.replace(':id', id);

        $.ajax({
            url: url,
            type: 'GET',
            success: function (res) {
                $('#modalBrand').text(res.brand);
                $('#modalMedia').text(res.media);
                $('#modalType').text(res.type);
                $('#modalCapacity').text(res.capacity);
                $('#modalWarranty').text(res.warranty ?? '-');
                $('#modalExpired').text(res.expired_date);
                $('#modalLocation').text(res.location || 'Belum diatur');

                $('#infoModal').modal('show');
            },
            error: function () {
                $('#modalInfoContent').html('<p class="text-danger">Gagal memuat data.</p>');
                $('#infoModal').modal('show');
            }
        });
    });

</script>

<script>
    $(document).on('click', '#editAparBtn', function () {
        const id = currentAparId;
        const form = $('#form-apar');

        $.ajax({
            url: `{{ route('admin.apar.edit', ':id') }}`.replace(':id', id),
            type: 'GET',
            success: function (data) {
            // Isi form
            form.find('[name="brand"]').val(data.brand);
            form.find('[name="type"]').val(data.type);
            form.find('[name="capacity"]').val(data.capacity);
            form.find('[name="expired_date"]').val(data.expired_date);
            form.find('[name="location_detail"]').val(data.location_detail);

            form.find('[name="media_id"]').val(data.media_id);
            form.find('[name="location_id"]').val(data.location_id);

            // Set method dan action
            form.attr('action', `/admin/apar/${id}`);
            $('#methodField').val('PUT');

            // Ubah tampilan
            $('#modal-apar-label').text('Edit Data APAR');
            $('#modal-apar button[type="submit"]').text('Update');

            $('#infoModal').modal('hide');
            setTimeout(() => {
                $('#modal-apar').modal('show');
            }, 300);
            },
            error: function () {
            alert('Gagal memuat data untuk diedit.');
            }
        });
    });
</script>

  

  
@endpush
