{{-- Modal Edit --}}
<div class="modal fade" id="editAparModal" tabindex="-1" aria-labelledby="editAparModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form method="POST" action="{{ route('admin.apar.update', $apar->id) }}">
        @csrf
        @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editAparModalLabel">Edit Data APAR</h5>
            
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
              <div class="row g-3">
                  <div class="col-md-6">
                <label class="form-label">Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ $apar->brand }}">
              </div>
              <div class="col-md-6">
                <label class="form-label">Media</label>
                <select name="media_id" class="form-select">
                  @foreach($medias as $media)
                    <option value="{{ $media->id }}" @if($apar->media_id == $media->id) selected @endif>{{ $media->media_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Type</label>
                <input type="text" name="type" class="form-control" value="{{ $apar->type }}">
              </div>
              <div class="col-md-6">
                <label class="form-label">Capacity (kg)</label>
                <input type="number" name="capacity" class="form-control" value="{{ $apar->capacity }}">
              </div>
              <div class="col-md-6">
                <label class="form-label">Expired Date</label>
                <input type="date" name="expired_date" class="form-control" value="{{ $apar->expired_date }}">
              </div>
              <div class="col-md-6">
                  <label class="form-label">Location</label>
                  <select name="location_id" class="form-select">
                    <option value="" disabled {{ $apar->location_id ? '' : 'selected' }}>-- Pilih Lokasi --</option>
                    @foreach($locations as $location)
                      <option value="{{ $location->id }}" 
                        {{ (int) $apar->location_id === $location->id ? 'selected' : '' }}>
                        {{ $location->location_name }}
                      </option>
                    @endforeach
                  </select>
                </div>
                
                <div class="col-md-12">
                  <label class="form-label">Location Detail</label>
                  <textarea name="location_detail" class="form-control" rows="3" placeholder="Isi detail lokasi jika ada...">{{ old('location_detail', $apar->location_detail ?? '') }}</textarea>
                </div>
                
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </div>
      </form>
    </div>
  </div>