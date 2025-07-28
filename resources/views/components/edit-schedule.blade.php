<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.schedule.update') }}" method="POST" id="formEditSchedule">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Agenda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Judul</label>
                        <input type="text" name="title" id="edit_title" class="form-control" placeholder="Judul agenda" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_start" class="form-label">Waktu Mulai</label>
                        <input type="datetime-local" name="start_time" id="edit_start" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_end" class="form-label">Waktu Selesai</label>
                        <input type="datetime-local" name="end_time" id="edit_end" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Inspeksi</label>
                        <select class="form-select" name="schedule_type_id" id="edit_jenis" required>
                            <option value="">-- Pilih Jenis Inspeksi --</option>
                            @foreach ($scheduleTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->schedule_name }}</option>
                            @endforeach
                        </select>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">💾 Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
