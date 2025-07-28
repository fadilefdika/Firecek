@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header text-white" style="background-color: #d32f2f;">
            <h5 class="mb-0">Dashboard APAR</h5>
        </div>
        <div class="card-body table-responsive">
            <table id="apar-table" class="table table-striped table-bordered w-100">
                <thead>
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
@endsection

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
@endpush
