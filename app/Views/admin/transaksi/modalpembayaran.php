<div class="modal fade" id="modalpembayaran">
  <div class="modal-dialog modal-lg">
    <?= form_open(base_url('transaksi/pembayaran'), ['class' => 'formsimpan']); ?>
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pembayaran <?= $transaksi['id_transaksi']; ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-8">
            <ul class="list-group">
              <li class="list-group-item"><strong>ID Transaksi: </strong><?= $transaksi['id_transaksi']; ?></li>
              <li class="list-group-item"><strong>Tanggal Transaksi: </strong><?= date('d-m-Y H:i:s', strtotime($transaksi['tanggal'])); ?></li>
              <li class="list-group-item"><strong>Tipe Pembayaran: </strong><?= ucfirst($transaksi['tipe_pembayaran']); ?></li>
              <?php if ($transaksi['tipe_pembayaran'] == "bank_transfer") { ?>
                <li class="list-group-item"><strong>Bank: </strong><?= strtoupper($status->va_numbers[0]->bank); ?></li>
                <li class="list-group-item"><strong>VA number: </strong><?= $status->va_numbers[0]->va_number; ?></li>
              <?php } else if ($transaksi['tipe_pembayaran'] == 'qris') { ?>
                <li class="list-group-item"><strong>Pembayaran: </strong><?= ucfirst($status->payment_type); ?></li>
              <?php } else { ?>
                <li class="list-group-item"><strong>Store: </strong><?= ucfirst($status->store); ?></li>
                <li class="list-group-item"><strong>Code Pembayaran: </strong><?= $status->payment_code; ?></li>
              <?php } ?>
              <li class="list-group-item"><strong>Total Transaksi: </strong>Rp. <?= number_format($transaksi['total_bayar'], 0, ",", "."); ?></li>

              <?php
              if (
                $transaksi['status_pembayaran'] == 'cancel' || $transaksi['status_pembayaran'] == 'failure' || $transaksi['status_pembayaran'] == 'expire'
              ) {
                $class = "badge badge-danger";
              } else if ($transaksi['status_pembayaran'] == 'settlement') {
                $class = "badge badge-success";
              } else {
                $class = "badge badge-info";
              }
              ?>

              <li class="list-group-item"><strong>Status pembayaran: </strong><span class="<?= $class; ?>"><?= strtoupper($transaksi['status_pembayaran']); ?></span></li>

              <?php
              if (
                $transaksi['status_transaksi'] == 'selesai'
              ) {
                $class = "badge badge-success";
              } else if ($transaksi['status_transaksi'] == 'gagal') {
                $class = "badge badge-danger";
              } else {
                $class = "badge badge-info";
              }
              ?>

              <li class="list-group-item"><strong>Status Transaksi: </strong><span class="<?= $class; ?>"><?= strtoupper($transaksi['status_transaksi']); ?></span></li>
            </ul>
          </div>

          <div class="col-lg-4">

            <div class="form-group">
              <label for="ekspedisi">Ekspedisi</label>
              <input type="text" name="ekspedisi" class="form-control" value="<?= $transaksi['ekspedisi']; ?>" style="text-transform: lowercase;" required>
            </div>

            <div class="form-group">
              <label for="noresi">No. Resi</label>
              <input type="text" name="noresi" class="form-control" value="<?= $transaksi['noresi']; ?>">
            </div>

            <div class="form-group">
              <input type="hidden" value="<?= $transaksi['id_transaksi']; ?>" name="id_transaksi">
              <label for="status_transaksi">Status Transaksi</label>
              <select name="status_transaksi" id="status_transaksi" class="form-control">
                <option value="gagal" <?= $transaksi['status_transaksi'] == "gagal" ? "selected" : ""; ?>>Gagal</option>
                <option value="pending" <?= $transaksi['status_transaksi'] == "pending" ? "selected" : ""; ?>>Pending</option>
                <option value="dikemas" <?= $transaksi['status_transaksi'] == "dikemas" ? "selected" : ""; ?>>Dikemas</option>
                <option value="dikirim" <?= $transaksi['status_transaksi'] == "dikirim" ? "selected" : ""; ?>>Dikirim</option>
                <option value="selesai" <?= $transaksi['status_transaksi'] == "selesai" ? "selected" : ""; ?>>Selesai</option>
              </select>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="hideModal();">Tutup</button>
        <button type="submit" class="btn btn-primary btnSimpan"><i class="fa fa-save"></i> Simpan perubahan</button>
      </div>
    </div>
    <?= form_close(); ?>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
  $('.formsimpan').submit(function(e) {
    e.preventDefault();
    $.ajax({
      type: "post",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      dataType: "json",
      beforeSend: function() {
        $(".btnSimpan").html(`<i class="fa fa-spin fa-spinner"></i>`);
      },
      complete: function() {
        $(".btnSimpan").html(`<i class="fa fa-save"></i> Simpan perubahan`);
      },
      success: function(response) {
        if (response.success) {
          Swal.fire("Sukses", response.success, 'success').then(() => {
            window.location.reload();
          });
        }
        if (response.error) {
          Swal.fire("Error", response.error, 'error').then(() => {
            window.location.reload();
          });
        }
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });
  });
</script>