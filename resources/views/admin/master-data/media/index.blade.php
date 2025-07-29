@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Master Data - Media</h5>
                    <a href="{{ route('admin.media.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-lg"></i> Tambah Media
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="media-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Nama</th>
                                <th style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- DataTables will populate --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#media-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.media.data') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'media_name', name: 'media_name' }, // ganti dari 'nama' jadi 'media_name'
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>

@endpush
