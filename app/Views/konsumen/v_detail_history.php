<?= $this->extend('templates/template_konsumen'); ?>

<?= $this->section('main'); ?>

<style>
  .tracking-detail {
    margin: 10px 0;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
  }

  .tracking-detail p {
    margin: 0;
  }
</style>

<div class="single-product mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-3 text-sm">
        <div class="card">
          <h5 class="card-header font-weight-bold">Info Pengiriman</h5>
          <div class="card-body tracking">
            <!-- Tempat untuk menampilkan tracking -->
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12 mb-3 text-sm">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <h5 class="card-header font-weight-bold">Info Pembayaran</h5>
                  <div class="card-body">
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

                      <?php if ($transaksi['status_pembayaran'] == "pending") { ?>
                        <?php if ($transaksi['tipe_pembayaran'] == 'qris') { ?>
                          <li class="list-group-item"><strong>Cara Pembayaran: </strong><a href="<?= $transaksi['link_pdf']; ?>" target="_blank">Klik</a></li>
                        <?php } ?>
                        <li class="list-group-item"><strong>Batas Pembayaran: </strong><?= date('d-m-Y H:i:s', strtotime($status->expiry_time)); ?></li>
                        <li class="list-group-item">
                          <button id="pay-button" class="btn btn-success btn-block"><i class="fa fa-money"></i> Klik Pembayaran</button>
                        </li>
                      <?php } else { ?>
                        <li class="list-group-item">
                          <button class="btn btn-block btn-lg btn-success" onclick="cetak('<?= $transaksi['id_transaksi']; ?>')"><i class="fa fa-file"></i> Cetak Invoice</button>
                        </li>
                      <?php } ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <h5 class="card-header font-weight-bold">Info Tracking</h5>
                  <div class="card-body">
                    <div class="form-group">
                      <div>
                        <h5 class="font-weight-bold">Nama Pemesan : <?= $transaksi['nama_lengkap']; ?></h5>
                      </div>

                    </div>
                    <div class="form-group">
                      <h5 class="font-weight-bold">No. Telp : <?= $transaksi['telp']; ?>
                      </h5>

                    </div>
                    <div class="form-group">
                      <h5 class="font-weight-bold">Alamat Pengiriman : <?= $transaksi['alamat']; ?> </h5>

                    </div>
                    <div class="form-group">
                      <h5 class="font-weight-bold">Provinsi : <?= $transaksi['provinsi']; ?></h5>

                    </div>
                    <div class="form-group">
                      <h5 class="font-weight-bold">Distrik :<?= $transaksi['distrik']; ?></h5>
                      <p></p>
                    </div>
                    <div class="form-group">
                      <h5 class="font-weight-bold">Kode POS: <?= $transaksi['kodepos']; ?></h5>
                    </div>
                    <div class="form-group">
                      <h5 class="font-weight-bold">Ekspedisi : <?= strtoupper($transaksi['ekspedisi']); ?></h5>
                    </div>
                    <div class="form-group">
                      <h5 class="font-weight-bold">Berat Produk (gram) : <?= number_format($transaksi['total_berat'], 0, ",", "."); ?></h5>
                    </div>
                    <div class="form-group">
                      <h5 class="font-weight-bold">Jenis Paket : <?= $transaksi['paket']; ?></h5>
                    </div>
                    <div class="form-group">
                      <h5 class="font-weight-bold">Biaya Ongkir : Rp. <?= number_format($transaksi['ongkir'], 0, ",", "."); ?></h5>

                    </div>
                    <div class="form-group">
                      <h5 class="font-weight-bold">No. Resi : <?= $transaksi['noresi'] == null || $transaksi['noresi'] == "" ? "belum tersedia" : $transaksi['noresi']; ?></h5>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="card">
              <h5 class="card-header font-weight-bold">Detail Pembelian</h5>
              <div class="card-body">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga(Rp)</th>
                        <th>Subtotal(Rp)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      $total = 0;
                      foreach ($detail as $key => $value) : ?>
                        <tr>
                          <td><?= $no++; ?>.</td>
                          <td>
                            <img src="<?= $value['gambar'] ? base_url('images/' . $value['gambar']) : base_url('images/default.jpg'); ?>" alt="Gambar produk" style="width: 100px;">
                          </td>
                          <td><?= $value['nama_produk']; ?></td>
                          <td><?= $value['jumlah']; ?></td>
                          <td><?= $value['satuan'] ?? "-"; ?></td>
                          <td class="text-right"><?= number_format($value['harga'], 0, ",", "."); ?></td>
                          <td class="text-right"><?= number_format($value['subtotal'], 0, ",", "."); ?></td>
                        </tr>
                      <?php
                        $total += $value['subtotal'];
                      endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="5" class="text-center">Total(Rp)</th>
                        <td class="text-right"><?= number_format($total, 0, ",", "."); ?></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= getenv('MIDTRANS_SERVER_KEY') ?>"></script>
<script>
  $("#pay-button").click(function(e) {
    e.preventDefault();
    // SnapToken acquired from previous step
    snap.pay('<?= $transaksi['snapToken']; ?>', {
      // Optional
      onSuccess: function(result) {
        // console.log(result);
        console.log('cek success');
        window.location = "<?= base_url('history/' . $transaksi['id_transaksi']); ?>";
        /* You may add your own js here, this is just example */
      },
      // Optional
      onPending: function(result) {
        // console.log(result);
        console.log('cek pending');
        window.location = "<?= base_url('history/' . $transaksi['id_transaksi']); ?>";
        /* You may add your own js here, this is just example */
      },
      // Optional
      onError: function(result) {
        // console.log(result);
        console.log('cek error');
        window.location = "<?= base_url('history/' . $transaksi['id_transaksi']); ?>";
        /* You may add your own js here, this is just example */
      },
      onClose: function() {
        /* You may add your own js here, this is just example */
        // document.getElementById('result-json').innerHTML += 'Customer closed the popup without finishing the payment\n';
      }
    });
  });

  function cetak(id_transaksi) {
    window.open("<?= base_url('cetak-history/'); ?>" + id_transaksi, "_blank");
  }

  $(document).ready(function() {
    var apiKey = '<?= getenv('API_TRACKING') ?>';
    var awb = `<?= $transaksi['noresi'] ?>` // Anda bisa mengganti ini dengan nilai dinamis
    var courier = `<?= $transaksi['ekspedisi'] ?>` // Anda bisa mengganti ini dengan nilai dinamis

    var url = `https://api.binderbyte.com/v1/track?api_key=${apiKey}&courier=${courier}&awb=${awb}`;

    if (awb != "" && courier != "") {
      $.ajax({
        url: url,
        method: 'GET',
        success: function(response) {
          console.log(response); // Tambahkan ini untuk memeriksa data yang diterima
          if (response.status === 200) {
            var data = response.data;
            var history = data.history;

            var trackingHTML = `
            <div class="tracking-detail">
              <p><strong>Status:</strong> ${data.summary.status}</p>
              <p><strong>Service:</strong> ${data.summary.service}</p>
              <p><strong>Awb:</strong> ${data.summary.awb}</p>
              <p><strong>Date:</strong> ${data.summary.date}</p>
              <p><strong>Origin:</strong> ${data.detail.origin}</p>
              <p><strong>Destination:</strong> ${data.detail.destination}</p>
            </div>
          `;

            history.forEach(function(item) {
              trackingHTML += `
              <div class="tracking-detail">
                <p><strong>Date:</strong> ${item.date}</p>
                <p><strong>Location:</strong> ${item.location}</p>
                <p><strong>Description:</strong> ${item.desc}</p>
              </div>
            `;
            });

            $('.tracking').html(trackingHTML);
          } else {
            $('.tracking').html('<p>Error fetching tracking details. Please try again later.</p>');
          }
        },
        error: function() {
          $('.tracking').html('<p>Error connecting to the server. Please try again later.</p>');
        }
      });
    } else {
      $(".tracking").html("");
    }
  });
</script>

<?= $this->endSection('main'); ?>