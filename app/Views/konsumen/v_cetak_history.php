<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>

  <style>
    * {
      font-family: Arial, Helvetica, sans-serif;
    }
  </style>
</head>

<body onload="print()">

  <div style="display: flex; justify-content: space-between;">
    <h1><?= $setting['nama_web']; ?></h1>
    <div>
      <h3>INVOICE</h3>
      <p><?= $transaksi['id_transaksi']; ?></p>
    </div>
  </div>

  <hr style="border: 2px double black;">

  <div style="display: flex; flex-wrap: wrap; justify-content: space-between; font-size: 12px;">
    <div style="flex: 1;">
      <h3>Info Penjual</h3>
      <table style="width: 100%;">
        <tr>
          <th style="text-align: left; width: 30%;">
            Nama Toko
          </th>
          <td>:</td>
          <td><?= $setting['nama_web']; ?></td>
        </tr>
        <tr>
          <th style="text-align: left; width: 30%;">
            Alamat Toko
          </th>
          <td>:</td>
          <td><?= $setting['alamat']; ?></td>
        </tr>
        <tr>
          <th style="text-align: left; width: 30%;">
            Kontak Toko
          </th>
          <td>:</td>
          <td><?= $setting['kontak']; ?></td>
        </tr>
      </table>
    </div>

    <div style="flex: 1;">
      <h3>Info Pembayaran</h3>
      <table style="width: 100%;">
        <tr>
          <th style="text-align: left; width: 30%;">
            ID Transaksi
          </th>
          <td>: <?= $transaksi['id_transaksi']; ?></td>
        </tr>
        <tr>
          <th style="text-align: left; width: 30%;">
            Tanggal
          </th>
          <td>: <?= $transaksi['nama_lengkap']; ?></td>
        </tr>
        <tr>
          <th style="text-align: left; width: 30%;">
            Tipe Pembayaran
          </th>
          <td>: <?= date('d M Y H:i:s', strtotime($transaksi['tanggal'])); ?></td>
        </tr>
        <?php if ($transaksi['tipe_pembayaran'] == "bank_transfer") { ?>
          <tr>
            <th style="text-align: left; width: 30%;">
              Bank
            </th>
            <td>: <?= strtoupper($status->va_numbers[0]->bank); ?></td>
          </tr>
          <tr>
            <th style="text-align: left; width: 30%;">
              VA Number
            </th>
            <td>: <?= $status->va_numbers[0]->va_number; ?></td>
          </tr>
        <?php } else if ($transaksi['tipe_pembayaran'] == 'qris') { ?>
          <tr>
            <th style="text-align: left; width: 30%;">
              Tipe Pembayaran
            </th>
            <td>: <?= ucfirst($status->payment_type); ?></td>
          </tr>
        <?php } else { ?>
          <tr>
            <th style="text-align: left; width: 30%;">
              Store
            </th>
            <td>: <?= ucfirst($status->store); ?></td>
          </tr>
          <tr>
            <th style="text-align: left; width: 30%;">
              Code Pembayaran
            </th>
            <td>: <?= $status->payment_code; ?></td>
          </tr>
        <?php } ?>
        <tr>
          <th style="text-align: left; width: 30%;">
            Total Transaksi
          <td>: Rp. <?= number_format($transaksi['total_bayar'], 0, ",", "."); ?></td>
        </tr>
        <tr>
          <th style="text-align: left; width: 30%;">
            Status Pembayaran
          <td>: <?= strtoupper($transaksi['status_pembayaran']); ?></td>
        </tr>
        <tr>
          <th style="text-align: left; width: 30%;">
            Status Transaksi
          <td>: <?= strtoupper($transaksi['status_transaksi']); ?></td>
        </tr>
      </table>
    </div>
    <div style="flex: 1;">
      <h3>Info Tracking</h3>
      <table style="width: 100%;">
        <tr>
          <th style="text-align: left; width: 30%;">
            Nama Konsumen
          </th>
          <td>: <?= $transaksi['nama_lengkap']; ?></td>
        </tr>
        <tr>
          <th style="text-align: left; width: 30%;">
            Provinsi
          </th>
          <td>: <?= $transaksi['provinsi']; ?></td>
        </tr>
        <tr>
          <th style="text-align: left; width: 30%;">
            Distrik
          </th>
          <td>: <?= $transaksi['distrik']; ?></td>
        </tr>
        <tr>
          <th style="text-align: left; width: 30%;">
            Kodepos
          </th>
          <td>: <?= $transaksi['kodepos']; ?></td>
        </tr>
        <tr>
          <th style="text-align: left; width: 30%;">
            Alamat Pengiriman
          </th>
          <td>: <?= $transaksi['alamat']; ?></td>
        </tr>
        <tr>
          <th style="text-align: left; width: 30%;">
            Ekspedisi
          </th>
          <td>: <?= strtoupper($transaksi['ekspedisi']); ?></td>
        </tr>
        <tr>
          <th style="text-align: left; width: 30%;">
            Berat Produk(gram)
          </th>
          <td>: <?= number_format($transaksi['total_berat'], 0, ",", "."); ?></td>
        </tr>
        <tr>
          <th style="text-align: left; width: 30%;">
            Jenis Paket
          </th>
          <td>: <?= $transaksi['paket']; ?></td>
        </tr>
      </table>
    </div>
  </div>
  <div style="font-size: 12px;">
    <h3>Detail Pembelian</h3>
    <table style="width: 100%;" border="1" cellspacing="0" cellpadding="5">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama Produk</th>
          <th>Jumlah</th>
          <th>Satuan</th>
          <th>Harga</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $total = 0;
        foreach ($detail as $key => $value) : ?>
          <tr>
            <td style="text-align: center;"><?= $no++; ?></td>
            <td><?= $value['nama_produk']; ?></td>
            <td style="text-align: center;"><?= $value['jumlah']; ?></td>
            <td style="text-align: center;"><?= $value['satuan'] ?? "-"; ?></td>
            <td style="text-align: right;">Rp. <?= number_format($value['harga'], 0, ",", "."); ?></td>
            <td style="text-align: right;">Rp. <?= number_format($value['subtotal'], 0, ",", "."); ?></td>
          </tr>
        <?php
          $total += $value['subtotal'];
        endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="5">Total</th>
          <td style="text-align: right;">Rp. <?= number_format($total, 0, ",", "."); ?></td>
        </tr>
        <tr>
          <th colspan="5">Ongkir</th>
          <td style="text-align: right;">Rp. <?= number_format($transaksi['ongkir'], 0, ",", "."); ?></td>
        </tr>
        <tr>
          <th colspan="5">Total Bayar</th>
          <td style="text-align: right;">Rp. <?= number_format($transaksi['total_bayar'], 0, ",", "."); ?></td>
        </tr>
      </tfoot>
    </table>
  </div>
</body>

</html>