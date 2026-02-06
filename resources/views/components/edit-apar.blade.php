@push('styles')
  <style>
    /* Menyamakan font form dengan tema compact */
    .modal-compact .form-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .modal-compact .form-control, 
    .modal-compact .form-select {
        font-size: 0.875rem;
        border-color: #e2e8f0;
        padding: 0.5rem 0.75rem;
    }

    .modal-compact .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .modal-header-compact {
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
</style>
@endpush

{{-- Modal Edit APAR --}}
<div class="modal fade modal-compact" id="editAparModal" tabindex="-1" aria-labelledby="editAparModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form method="POST" action="{{ route('admin.apar.update', $apar->id) }}" class="modal-content border-0 shadow-lg">
            @csrf
            @method('PUT')

            <div class="modal-header modal-header-compact py-2 px-3">
                <div class="d-flex align-items-center">
                    <div class="p-2 bg-soft-primary rounded-2 me-2">
                        <i class="fas fa-edit text-primary"></i>
                    </div>
                    <h6 class="modal-title fw-bold text-dark" id="editAparModalLabel">Update Unit Information</h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Brand Name</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-tag text-muted"></i></span>
                            <input type="text" name="brand" class="form-control border-start-0" value="{{ $apar->brand }}" placeholder="e.g. Servvo" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Extinguishing Media</label>
                        <select name="media_id" class="form-select form-select-sm" required>
                            @foreach($medias as $media)
                                <option value="{{ $media->id }}" @selected($apar->media_id == $media->id)>
                                    {{ $media->media_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Model Type</label>
                        <input type="text" name="type" class="form-control form-control-sm" value="{{ $apar->type }}" placeholder="e.g. ABC Powder">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Capacity (kg)</label>
                        <div class="input-group input-group-sm">
                            <input type="number" name="capacity" class="form-control" value="{{ $apar->capacity }}" step="0.1" required>
                            <span class="input-group-text bg-light text-muted">kg</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tube Weight (kg)</label>
                        <div class="input-group input-group-sm">
                            <input type="number" name="tube_weight" class="form-control" value="{{ $apar->tube_weight }}" step="0.1" required>
                            <span class="input-group-text bg-light text-muted">kg</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Expiration Date</label>
                        <input type="date" name="expired_date" class="form-control form-control-sm" value="{{ $apar->expired_date }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Assigned Location</label>
                        <select name="location_id" class="form-select form-select-sm">
                            <option value="" disabled @selected(!$apar->location_id)>-- Select Location --</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" @selected($apar->location_id == $location->id)>
                                    {{ $location->location_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Specific Location Detail</label>
                        <textarea name="location_detail" class="form-control form-control-sm" rows="2" placeholder="e.g. Next to the main entrance door">{{ old('location_detail', $apar->location_detail) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light-50 py-2">
                <button type="button" class="btn btn-light btn-sm px-3 border" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm px-4 shadow-sm">
                    <i class="fas fa-save me-1"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>