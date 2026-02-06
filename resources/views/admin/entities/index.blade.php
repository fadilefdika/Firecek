@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .card {
            border-radius: 15px;
            overflow: hidden;
        }

        .table thead {
            background-color: #f8f9fa;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
            font-size: 0.95rem;
        }

        .qr-container {
            transition: transform 0.2s;
            cursor: pointer;
        }

        .qr-container:hover {
            transform: scale(1.1);
        }

        .badge-status {
            padding: 0.5em 0.8em;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-action {
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-action:hover {
            filter: brightness(90%);
            transform: translateY(-1px);
        }
    </style>

    <div class="container-fluid py-4">
        <div class="card p-4 shadow-lg">
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h2 class="fw-bold text-dark mb-0">Alokasi ESD</h2>
                    <p class="text-secondary mb-0">Manajemen inventaris ESD Karyawan</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('admin.entities.create') }}" class="btn btn-primary px-4 py-2 shadow-sm fw-bold">
                        <i class="bi bi-person-plus-fill me-2"></i>Tambah Data
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-lg">
                <div class="card-body p-0">
                    <div class="table-responsive p-4">
                        <table id="entityTable" class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    {{-- <th class="border-0">ID</th> --}}
                                    <th class="border-0">Karyawan</th>
                                    <th class="border-0 text-center">QR Code</th>
                                    <th class="border-0">Departemen</th>
                                    <th class="border-0 text-center">Status</th>
                                    <th class="border-0 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entities as $entity)
                                    <tr>
                                        {{-- <td class="text-secondary fw-bold">#{{ $entity->id }}</td> --}}
                                        <td class="text-muted fw-medium">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-soft bg-primary-soft rounded-circle me-3">
                                                    <i class="bi bi-person-circle fs-3 text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $entity->employee_name }}</div>
                                                    <div class="small text-muted">NPK: {{ $entity->npk }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="qr-wrapper shadow-sm btn-view-qr" style="cursor: pointer;"
                                                data-qr-code="{{ $entity->id }}" data-name="{{ $entity->employee_name }}"
                                                data-npk="{{ $entity->npk }}">
                                                {!! QrCode::size(45)->generate(url('/preview/' . $entity->id)) !!}
                                            </div>
                                            <div class="mt-1">
                                                <a href="{{ route('admin.entities.download-qr', $entity->id) }}"
                                                    class="text-primary fw-bold"
                                                    style="font-size: 0.65rem; text-decoration: none;">
                                                    <i class="bi bi-download"></i> UNDUH
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-dark fw-medium">{{ $entity->dept_name ?? '-' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge {{ $entity->status == 'AKTIF' ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger' }} badge-status">
                                                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem"></i>
                                                {{ $entity->status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm border rounded">
                                                <a href="{{ route('admin.entities.copy', $entity->id) }}"
                                                    class="btn btn-white btn-sm" title="Duplikasi">
                                                    <i class="bi bi-files text-info"></i>
                                                </a>
                                                <a href="{{ route('admin.entities.edit', $entity->id) }}"
                                                    class="btn btn-white btn-sm" title="Edit">
                                                    <i class="bi bi-pencil-square text-warning"></i>
                                                </a>
                                                <form action="{{ route('admin.entities.destroy', $entity->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Hapus data karyawan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-white btn-sm border-0">
                                                        <i class="bi bi-trash3 text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="qrViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow text-center p-4">
                <div class="mb-3" id="qrContainerLarge">
                </div>
                <h5 class="fw-bold mb-1" id="qrNameTitle"></h5>
                <p class="text-muted small mb-3" id="qrNpkSubtitle"></p>
                <button type="button" class="btn btn-light w-100 border" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    {{-- <script>
        $(document).ready(function() {
            $('#entityTable').DataTable({
                "pageLength": 10,
                "language": {
                    "search": "Cari Karyawan:",
                    "paginate": {
                        "next": "»",
                        "previous": "«"
                    }
                }
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('#entityTable').DataTable();

            $('.btn-view-qr').on('click', function() {
                const qrLink = $(this).data('qr-code');
                const name = $(this).data('name');
                const npk = $(this).data('npk');

                $('#qrNameTitle').text(name);
                $('#qrNpkSubtitle').text(npk);

                $('#qrContainerLarge').html('');

                new QRCode(document.getElementById("qrContainerLarge"), {
                    text: qrLink,
                    width: 200,
                    height: 200
                });

                $('#qrViewModal').modal('show');
            });
        });
    </script>
@endsection
