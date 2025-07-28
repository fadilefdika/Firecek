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
                            <th>Created At</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal -->
<div class="modal fade" id="modal-apar" tabindex="-1" aria-labelledby="modal-apar-label" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-3">
        <div class="modal-header border-0 bg-white px-4 pt-4">
          <h6 class="modal-title fw-semibold text-gray-800" id="modal-apar-label">Tambah Data APAR</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="form-apar" class="needs-validation" novalidate>
          <div class="modal-body px-4 pb-2">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label small fw-medium text-muted">Brand</label>
                <input type="text" class="form-control form-control-sm rounded-2" name="brand" required>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-medium text-muted">Media ID</label>
                <input type="number" class="form-control form-control-sm rounded-2" name="media_id" required>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-medium text-muted">Type</label>
                <input type="text" class="form-control form-control-sm rounded-2" name="type">
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-medium text-muted">Capacity (kg)</label>
                <input type="number" step="0.01" class="form-control form-control-sm rounded-2" name="capacity">
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-medium text-muted">Expired Date</label>
                <input type="date" class="form-control form-control-sm rounded-2" name="expired_date">
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-medium text-muted">Location ID</label>
                <input type="number" class="form-control form-control-sm rounded-2" name="location_id" required>
              </div>
              <div class="col-12">
                <label class="form-label small fw-medium text-muted">Location Detail</label>
                <textarea class="form-control form-control-sm rounded-2" name="location_detail" rows="2"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer px-4 pb-4 border-0 justify-content-between">
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">
              Batal
            </button>
            <button type="submit" class="btn btn-sm text-white rounded-pill px-4 shadow-sm" style="background-color: #d32f2f;">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  




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
            { data: 'media_id', name: 'media_id' },
            { data: 'type', name: 'type' },
            { data: 'capacity', name: 'capacity' },
            { data: 'expired_date', name: 'expired_date' },
            { data: 'location_id', name: 'location_id' },
            { data: 'location_detail', name: 'location_detail' },
            { data: 'created_at', name: 'created_at' }
        ],
        responsive: true
    });
});
</script>
<script>
    $('#form-apar').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: '{{ route("admin.apar.store") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#modal-apar').modal('hide');
                $('#form-apar')[0].reset();
                $('#apar-table').DataTable().ajax.reload();
            },
            error: function(xhr) {
                alert('Gagal menyimpan data');
            }
        });
    });
</script>

@endpush
