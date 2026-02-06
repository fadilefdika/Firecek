@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Master Data - Media</h5>
                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" 
                            style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#modalMedia">
                        <i class="fas fa-plus me-1"></i> Add
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="media-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Name</th>
                                <th style="width: 20%">Action</th>
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
<div class="modal fade" id="modalMedia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm"> <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h6 class="fw-bold mb-0">Add Media</h6>
                <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.media.store') }}" method="POST">
                @csrf
                <div class="modal-body py-3">
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted">Media Name</label>
                        <input type="text" name="media_name" class="form-control form-control-sm border-2"
                               placeholder="e.g. Monthly Inspection" required autofocus>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-sm btn-light fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary fw-bold px-3">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEditMedia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h6 class="fw-bold mb-0">Edit Media</h6>
                <button type="button" class="btn-close small" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-edit-type" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body py-3">
                    <input type="hidden" id="edit-id">
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted">Media Name</label>
                        <input type="text" id="edit-name" name="media_name" class="form-control form-control-sm border-2" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-sm btn-light fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary fw-bold px-3">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function () {
        // 1. Inisialisasi DataTables
        const table = $('#media-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.media.data') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'ps-3' },
                { data: 'media_name', name: 'media_name' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end pe-3' }
            ]
        });

        // 2. Logika ADD (Sudah Anda miliki, ditambahkan reset form)
        $('#form-add-type').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    $('#modalMedia').modal('hide');
                    $('#form-add-type')[0].reset(); // Reset form agar bersih saat dibuka lagi
                    table.ajax.reload(); 
                    toastr.success('New schedule type added!'); 
                },
                error: function(err) {
                    toastr.error('Failed to add data. Please check your input.');
                }
            });
        });

        // 3. Logika EDIT (Trigger Modal & Populate Data)
        $('body').on('click', '.edit-type', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');
            
            // Masukkan data ke input modal edit
            $('#edit-id').val(id);
            $('#edit-name').val(name);
            
            // Set URL action form edit secara dinamis
            $('#form-edit-type').attr('action', `/admin/media/${id}`);
            $('#modalEditMedia').modal('show');
        });

        // 4. Logika UPDATE (Submit Modal Edit via AJAX)
        $('#form-edit-type').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST', // Laravel akan membaca ini sebagai PUT karena @method('PUT') di blade
                data: $(this).serialize(),
                success: function (res) {
                    $('#modalEditMedia').modal('hide');
                    table.ajax.reload();
                    toastr.info('Schedule type updated successfully.');
                }
            });
        });

        // 5. Logika DELETE (Konfirmasi SweetAlert2)
        $('body').on('click', '.delete-type', function () {
            const id = $(this).data('id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "Related inspection data might be affected!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545', // Warna merah sesuai tema APAR Anda
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/media/${id}`,
                        method: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function (res) {
                            table.ajax.reload();
                            toastr.warning('Data has been deleted.');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush