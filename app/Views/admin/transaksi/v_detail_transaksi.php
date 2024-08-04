<?= $this->extend('templates/template_admin'); ?>

<?= $this->section('main'); ?>

<div class="card card-primary card-outline">
  <div class="card-header">
    <h5 class="m-0 d-flex justify-content-between flex-wrap">
      <a href="<?= base_url('transaksi'); ?>" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
      <button type="button" class="btn btn-info refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
    </h5>
  </div>
  <div class="card-body">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-3">
          <div class="card">
            <h5 class="card-header">
              Info Pengiriman
            </h5>
            <div class="card-body">
              <div class="form-group">
                <h6 class="font-weight-bold">Nama konsumen</h6>
                <p><?= $transaksi['nama_lengkap']; ?></p>
              </div>
              <div class="form-group">
                <h6 class="font-weight-bold">E-mail konsumen</h6>
                <p><?= $transaksi['email']; ?></p>
              </div>
              <div class="form-group">
                <h6 class="font-weight-bold">No. Telp</h6>
                <p><?= $transaksi['telp']; ?></p>
              </div>
              <div class="form-group">
                <h6 class="font-weight-bold">Alamat Pengiriman</h6>
                <p><?= $transaksi['alamat']; ?></p>
              </div>
              <div class="form-group">
                <h6 class="font-weight-bold">Provinsi</h6>
                <p><?= $transaksi['provinsi']; ?></p>
              </div>
              <div class="form-group">
                <h6 class="font-weight-bold">Distrik</h6>
                <p><?= $transaksi['distrik']; ?></p>
              </div>
              <div class="form-group">
                <h6 class="font-weight-bold">Kode POS</h6>
                <p><?= $transaksi['kodepos']; ?></p>
              </div>
              <div class="form-group">
                <h6 class="font-weight-bold">Ekspedisi</h6>
                <p><?= strtoupper($transaksi['ekspedisi']); ?></p>
              </div>
              <div class="form-group">
                <h6 class="font-weight-bold">Berat Produk (gram)</h6>
                <p><?= number_format($transaksi['total_berat'], 0, ",", "."); ?></p>
              </div>
              <div class="form-group">
                <h6 class="font-weight-bold">Jenis Paket</h6>
                <p><?= $transaksi['paket']; ?></p>
              </div>
              <div class="form-group">
                <h6 class="font-weight-bold">Biaya Ongkir</h6>
                <p>Rp. <?= number_format($transaksi['ongkir'], 0, ",", "."); ?></p>
              </div>
              <div class="form-group">
                <h6 class="font-weight-bold">No. Resi</h6>
                <?php if ($transaksi['noresi'] !== null) { ?>
                  <p><?= $transaksi['noresi']; ?></p>
                <?php } else { ?>
                  <p>No Resi belum diisi...</p>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="card">
                <h5 class="card-header">Info Pembayaran</h5>
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
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="card">
                <h5 class="card-header">Detail Pembelian</h5>
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

</div>

<?= $this->endSection('main'); ?>