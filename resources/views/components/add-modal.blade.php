<!-- Modal -->
<div class="modal fade" id="modal-apar" tabindex="-1" aria-labelledby="modal-apar-label" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-3">
        <div class="modal-header border-0 bg-white px-4 pt-4">
          <h6 class="modal-title fw-semibold text-gray-800" id="modal-apar-label">Tambah Data APAR</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="form-apar" method="POST" data-mode="create">
            @csrf
            @method('POST')
          <div class=" px-4 pb-2">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label small fw-medium text-muted">Brand<span class="text-danger"> *</span></label>
                <input type="text" class="form-control form-control-sm rounded-2" name="brand" required>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-medium text-muted">Media<span class="text-danger"> *</span></label>
                <select name="media_id" class="form-select form-select-sm rounded-2" required>
                  <option value="" disabled selected>-- Select Media --</option>
                  @foreach ($media as $item)
                    <option value="{{ $item->id }}">{{ $item->media_name }}</option>
                  @endforeach
                </select>
              </div>              
              <div class="col-md-6">
                <label class="form-label small fw-medium text-muted">Type<span class="text-danger"> *</span></label>
                <input type="text" class="form-control form-control-sm rounded-2" name="type">
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-medium text-muted">Capacity (kg)<span class="text-danger"> *</span></label>
                <input type="number" step="0.01" class="form-control form-control-sm rounded-2" name="capacity">
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-medium text-muted">Expired Date<span class="text-danger"> *</span></label>
                <input type="date" class="form-control form-control-sm rounded-2" name="expired_date">
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-medium text-muted">Location</label>
                <select name="location_id" class="form-select form-select-sm rounded-2">
                  <option value="" disabled selected>-- Select Location --</option>
                    @foreach ($location as $item)
                        <option value="{{ $item->id }}">{{ $item->location_name }}</option>
                    @endforeach
                </select>
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