@extends('layouts.app')

@section('content')
@php
    $isEdit = isset($entity) && $entity->exists && !($isCopy ?? false);
    $isCopy = $isCopy ?? false;
    $isCreate = !$isEdit && !$isCopy;

    $formAction = ($isEdit) ? route('admin.entities.update', $entity->id) : route('admin.entities.store');
    $title = $isCreate ? 'Tambah Entity' : ($isCopy ? 'Copy Entity' : 'Edit Entity');
    $color = $isCreate ? 'primary' : ($isCopy ? 'info text-white' : 'warning');
@endphp

<div class="container mt-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-{{ $color }} py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-person-badge me-2"></i>{{ $title }}</h5>
            @if($isEdit)
                <a href="{{ route('admin.entities.download-qr', $entity->id) }}" class="btn btn-sm btn-light">
                    <i class="bi bi-qr-code"></i> Download QR
                </a>
            @endif
        </div>
        <div class="card-body p-4">
            <form action="{{ $formAction }}" method="POST">
                @csrf
                @if($isEdit) @method('PUT') @endif
                
                <h6 class="text-dark fw-bold mb-3 border-bottom pb-2">Identitas Utama</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">NPK</label>
                        <input type="text" name="npk" id="npk" class="form-control" value="{{ old('npk', $entity->npk ?? '') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Kode (System)</label>
                        <input type="text" class="form-control bg-light" value="{{ $isCreate || $isCopy ? 'AUTO GENERATE' : $entity->code }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="AKTIF" {{ (old('status', $entity->status ?? '') == 'AKTIF') ? 'selected' : '' }}>AKTIF</option>
                            <option value="NON-AKTIF" {{ (old('status', $entity->status ?? '') == 'NON-AKTIF') ? 'selected' : '' }}>NON-AKTIF</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">No. Loker</label>
                        <input type="text" name="no_loker" class="form-control" value="{{ old('no_loker', $entity->no_loker ?? '') }}">
                    </div>
                    {{-- <div class="col-md-12">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="employee_name" class="form-control" value="{{ old('employee_name', $entity->employee_name ?? '') }}" required>
                    </div> --}}
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Cari Karyawan (Awork API)</label>
                        <select id="employee_search" name="npk" class="form-control" required>
                            @if(isset($entity))
                                <option value="{{ $entity->npk }}" selected>{{ $entity->employee_name }} ({{ $entity->npk }})</option>
                            @endif
                        </select>
                        <input type="hidden" name="employee_name" id="employee_name" value="{{ $entity->employee_name ?? '' }}">
                    </div>
                </div>

                <h6 class="text-dark fw-bold mb-3 border-bottom pb-2">Departemen & Line</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Dept ID</label>
                        <input type="number" name="dept_id" id="dept_id" class="form-control" value="{{ old('dept_id', $entity->dept_id ?? '') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Nama Dept</label>
                        <input type="text" name="dept_name" id="dept_name" class="form-control" value="{{ old('dept_name', $entity->dept_name ?? '') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Line ID</label>
                        <input type="number" name="line_id" id="line_id" class="form-control" value="{{ old('line_id', $entity->line_id ?? '') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Nama Line</label>
                        <input type="text" name="line_name" id="line_name" class="form-control" value="{{ old('line_name', $entity->line_name ?? '') }}">
                    </div>
                </div>

                {{-- <h6 class="text-dark fw-bold mb-3 border-bottom pb-2">Sistem & Link</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Link QR Profile</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-link-45deg"></i></span>
                            <input type="text" name="entity_link_qr" class="form-control bg-light" 
                                   value="{{ $isCreate || $isCopy ? 'Will be generated after save' : $entity->entity_link_qr }}" readonly>
                        </div>
                    </div>
                </div> --}}

                <h6 class="text-dark fw-bold mb-3 border-bottom pb-2">Detail Item</h6>
                <div id="item-wrapper">
                    @php $loopItems = (isset($entity) && $entity->items->count() > 0) ? $entity->items : [null]; @endphp
                    @foreach($loopItems as $index => $pivotItem)
                    <div class="row g-2 mb-2 align-items-end item-row">
                        <div class="col-md-5">
                            <select name="items[{{ $index }}][item_id]" class="form-select select2" required>
                                <option value="" disabled {{ !$pivotItem ? 'selected' : '' }}>Pilih Item...</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ ($pivotItem && $item->id == $pivotItem->id) ? 'selected' : '' }}>
                                        {{ $item->item_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="items[{{ $index }}][size]" class="form-control" placeholder="Size" value="{{ $pivotItem->pivot->size ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="items[{{ $index }}][notes]" class="form-control" placeholder="Notes" value="{{ $pivotItem->pivot->notes ?? '' }}">
                        </div>
                        <div class="col-md-1 text-end">
                            <button type="button" class="btn btn-outline-danger border-0 remove-item"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-item-btn" class="btn btn-sm btn-outline-secondary mt-2">+ Baris Baru</button>

                <div class="mt-5 text-end border-top pt-3">
                    <a href="{{ route('admin.entities.index') }}" class="btn btn-light px-4 border">Batal</a>
                    <button type="submit" class="btn btn-{{ $isCreate ? 'primary' : ($isCopy ? 'info text-white' : 'warning') }} px-5 shadow-sm fw-bold">
                        {{ $isCreate ? 'Simpan' : ($isCopy ? 'Copy Data' : 'Update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
    $(document).ready(function() {
        let rowIdx = {{ (isset($entity) ? $entity->items->count() : 1) }};

        $('#add-item-btn').click(function() {
            let html = `
                <div class="row g-2 mb-2 align-items-end item-row">
                    <div class="col-md-5">
                        <select name="items[${rowIdx}][item_id]" class="form-select select-item" required>
                            <option value="" disabled selected>Pilih Item...</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="items[${rowIdx}][size]" class="form-control" placeholder="Size">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="items[${rowIdx}][notes]" class="form-control" placeholder="Catatan">
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-outline-danger border-0 remove-item">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>`;
            $('#item-wrapper').append(html);
            rowIdx++;
        });

        $(document).on('click', '.remove-item', function() {
            if ($('.item-row').length > 1) {
                $(this).closest('.item-row').remove();
            } else {
                $(this).closest('.item-row').find('input').val('');
                $(this).closest('.item-row').find('select').val('');
            }
        });
    });
</script>

<script>
$(document).ready(function() {
    console.log("Inisialisasi Select2...");

    $('#employee_search').select2({
        placeholder: 'Cari Nama atau NPK...',
        minimumInputLength: 3, 
        allowClear: true,
        theme: 'bootstrap-5',
        ajax: {
            url: "{{ route('admin.proxy.awork') }}",
            dataType: 'json',
            delay: 500,
            headers: {
                "Authorization": "Bearer a7e8b04c6f234b2fae7c8d916ec9f1aa",
                "Accept": "application/json"
            },
            data: function (params) {
                console.log("Mengirim request untuk kata kunci:", params.term);
                return {
                    search: params.term
                };
            },
            processResults: function (data) {
                console.log("Data diterima dari API:", data);
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            id: item.npk,
                            text: item.fullname + ' (' + item.npk + ')',
                            full_data: item
                        }
                    })
                };
            },
            error: function (xhr, status, error) {
                console.error("Gagal fetch API:", error);
                console.error("Detail Error:", xhr.responseText);
            },
            cache: true
        }
    });

    $('#employee_search').on('select2:select', function (e) {
        var data = e.params.data.full_data;
        
        $('#employee_name').val(data.fullname);
        $('#dept_id').val(data.department_id);
        $('#dept_name').val(data.department);
        $('#line_id').val(data.line_id);
        $('#line_name').val(data.line);
        $('#npk').val(data.npk);

    });
});
</script>
@endsection