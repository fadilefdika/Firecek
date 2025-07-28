<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <form action="#{{-- route('schedule.update') --}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-content">
                <div class="modal-header"><h5>Edit Agenda</h5></div>
                <div class="modal-body">
                    <input type="text" name="title" id="edit_title" class="form-control mb-2" placeholder="Judul">
                    <input type="datetime-local" name="start_time" id="edit_start" class="form-control mb-2">
                    <input type="datetime-local" name="end_time" id="edit_end" class="form-control mb-2">
                    <select name="jenis" id="edit_jenis" class="form-control">
                        <option value="pengecekan vendor">Pengecekan Vendor</option>
                        <option value="pengecekan sendiri">Pengecekan Sendiri</option>
                        <option value="isi ulang apar">Isi Ulang APAR</option>
                        <option value="service">Service</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
