
<!-- Modal Show Info -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 shadow-lg">
        <div class="modal-header border-0">
          <h5 class="modal-title fw-bold" id="infoModalLabel">Informasi APAR</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="px-4 pb-3" id="modalInfoContent">
          <table class="table table-borderless">
            <tbody>
              <tr><td>Merek</td><td>:</td><td id="modalBrand">-</td></tr>
              <tr><td>Media</td><td>:</td><td id="modalMedia">-</td></tr>
              <tr><td>Tipe</td><td>:</td><td id="modalType">-</td></tr>
              <tr><td>Kapasitas</td><td>:</td><td id="modalCapacity">-</td></tr>
              <tr><td>Garansi</td><td>:</td><td id="modalWarranty">-</td></tr>
              <tr><td>Expired</td><td>:</td><td id="modalExpired">-</td></tr>
              <tr><td>Lokasi</td><td>:</td><td id="modalLocation">-</td></tr>
            </tbody>
          </table>
          <div class="text-center mt-3">
            <div class="alert alert-success py-2 mb-3" role="alert">
              ✅ QR terverifikasi
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" id="editAparBtn" data-bs-toggle="modal" data-bs-target="#modal-apar">
                    Edit Informasi APAR
                </button>
              <div class="d-flex justify-content-center gap-2 mt-2">
                <button class="btn btn-outline-primary">Atur Lokasi</button>
                <button class="btn btn-outline-secondary">Cek APAR</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>