<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" action="{{ route('admin.schedule.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahLabel">Tambah Agenda</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nama Agenda</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Inspeksi</label>
                <select class="form-select" name="type" required>
                    <option value="">-- Pilih Jenis Inspeksi --</option>
                    @foreach ($scheduleTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->schedule_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 row">
                <div class="col">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="start_date" required>
                </div>
                <div class="col">
                    <label class="form-label">Waktu Mulai</label>
                    <input type="time" class="form-control" name="start_time" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" name="end_date" required>
                </div>
                <div class="col">
                    <label class="form-label">Waktu Selesai</label>
                    <input type="time" class="form-control" name="end_time" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea class="form-control" name="notes" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Simpan</button>
        </div>
      </form>
    </div>
  </div>
  