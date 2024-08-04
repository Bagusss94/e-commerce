<!-- Modal -->
<div class="modal fade" id="modalcekpembayaran" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><strong>Transaksi <?= $transaksi['id_transaksi']; ?></strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item"><strong>Tanggal: </strong><?= date('d-m-Y H:i:s', strtotime($transaksi['tanggal'])); ?></li>
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

          <?php if ($transaksi['status_pembayaran'] == "pending") { ?>
            <li class="list-group-item"><strong>Cara Pembayaran: </strong><a href="<?= $transaksi['link_pdf']; ?>" target="_blank">Klik</a></li>
            <li class="list-group-item">
              <button class="btn btn-block btn-primary" id="bayar"><i class="fa fa-money"></i> Pembayaran</button>
            </li>
          <?php } ?>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="hideModal()">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= getenv("MIDTRANS_SERVER_KEY"); ?>"></script>

<script>
  document.getElementById('bayar').onclick = function() {
    // SnapToken acquired from previous step
    snap.pay('<?= $transaksi['snapToken']; ?>', {
      // Optional
      onSuccess: function(result) {
        /* You may add your own js here, this is just example */
        window.location.reload();
      },
      // Optional
      onPending: function(result) {
        /* You may add your own js here, this is just example */
        window.location.reload();
      },
      // Optional
      onError: function(result) {
        /* You may add your own js here, this is just example */
        window.location.reload();
      },
      // Optional
      onClose: function() {
        /* You may add your own js here, this is just example */
        window.location = "<?= base_url('history'); ?>";
      },
    });
  };
</script>