<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" action="{{ route('admin.schedule.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahLabel">Add Agenda</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Agenda Name</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Inspection Type</label>
                <select class="form-select" name="type" required>
                    <option value="">-- Select Inspection Type --</option>
                    @foreach ($scheduleTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->schedule_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 row">
                <div class="col">
                    <label class="form-label">Start Date</label>
                    <input type="date" class="form-control" name="start_date" required>
                </div>
                <div class="col">
                    <label class="form-label">Start Time</label>
                    <input type="time" class="form-control" name="start_time" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col">
                    <label class="form-label">End Date</label>
                    <input type="date" class="form-control" name="end_date" required>
                </div>
                <div class="col">
                    <label class="form-label">End Time</label>
                    <input type="time" class="form-control" name="end_time" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea class="form-control" name="notes" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Save</button>
        </div>
      </form>
    </div>
  </div>
  