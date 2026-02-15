<div class="row g-2 mb-2 align-items-center item-row">
    <div class="col-md-5">
        <select name="items[{{ $index }}][item_id]" class="form-select form-select-sm" required>
            <option value="" disabled {{ !$pivotItem ? 'selected' : '' }}>Pilih Item...</option>
            @foreach($items as $item)
                <option value="{{ $item->id }}" {{ ($pivotItem && $item->id == $pivotItem->id) ? 'selected' : '' }}>
                    {{ $item->item_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <input type="text" name="items[{{ $index }}][size]" class="form-control form-control-sm" placeholder="Size" value="{{ $pivotItem->pivot->size ?? '' }}">
    </div>
    <div class="col-md-4">
        <input type="text" name="items[{{ $index }}][notes]" class="form-control form-control-sm" placeholder="Keterangan / Notes" value="{{ $pivotItem->pivot->notes ?? '' }}">
    </div>
    <div class="col-md-1 text-end">
        <button type="button" class="btn btn-link text-danger remove-item p-0" title="Hapus Baris">
            <i class="bi bi-dash-circle-fill fs-6"></i>
        </button>
    </div>
</div>