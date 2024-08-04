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

<body onload="print();">

  <?php

  $db = db_connect();

  if ($tgl_awal && $tgl_akhir && $status) {
    $keterangan = "<h4 style='text-align: center;'>Dari tanggal " . date('d-m-Y', strtotime($tgl_awal)) . " s/d " . date('d-m-Y', strtotime($tgl_akhir)) . " dengan status " . strtoupper($status) . "</h4>";
  } elseif ($tgl_awal && $tgl_akhir) {
    $keterangan = "<h4 style='text-align: center;'>Dari tanggal " . date('d-m-Y', strtotime($tgl_awal)) . " s/d " . date('d-m-Y', strtotime($tgl_akhir)) . "</h4>";
  } elseif ($status) {
    $keterangan = "<h4 style='text-align: center;'>Status " . $status . "</h4>";
  } else {
    $keterangan = "";
  }
  ?>

  <h2 style="text-align: center;">Cetak Laporan Transaksi</h2>
  <?= $keterangan; ?>

  <table style="width: 100%; font-size: 12px;" border="1" cellspacing=0>
    <thead>
      <tr>
        <th style="width: 2%;">#</th>
        <th style="width: 8%;">ID</th>
        <th style="width: 8%;">Tanggal</th>
        <th style="width: 12%;">Konsumen</th>
        <th>Detail Pembelian</th>
        <th style="width: 12%;">Total Bayar(Rp)</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $total_semua = 0;
      foreach ($transaksi as $key => $value) : ?>
        <tr>
          <td><?= $no++; ?>.</td>
          <td style="text-align: center;"><?= $value['id_transaksi']; ?></td>
          <td style="text-align: center;"><?= date("d-m-Y", strtotime($value['tanggal'])); ?></td>
          <td style="text-align: center;"><?= $value['nama_lengkap']; ?></td>
          <td>
            <div style="display: flex; justify-content: space-between;">
              <div style="flex: 1;">
                <p style="font-weight: bold;">Daftar Produk</p>
                <?php
                $detail = $db->table('detail_transaksi')
                  ->where('id_transaksi', $value['id_transaksi'])
                  ->get()->getResultArray();

                $i = 1;
                foreach ($detail as $d) :
                  $produk = $db->table('produk')->join("satuan", "produk.id_satuan = satuan.id_satuan")
                    ->get()->getRowArray();
                ?>
                  <?= $i++; ?>. <?= $produk['nama_produk']; ?>
                  <ul>
                    <li>Qty: <?= $d['jumlah']; ?></li>
                    <li>Satuan: <?= $d['satuan'] ?? "-"; ?></li>
                    <li>Harga(Rp): <?= number_format($d['harga'], 0, ",", "."); ?></li>
                    <li>Subtotal(Rp): <?= number_format($d['subtotal'], 0, ",", "."); ?></li>
                  </ul>
                <?php endforeach; ?>
              </div>
              <div style="flex: 1;">
                <p style="font-weight: bold;">Pengiriman</p>
                <ul>
                  <li>Alamat: <?= $value['alamat']; ?></li>
                  <li>Distrik: <?= $value['distrik']; ?></li>
                  <li>Provinsi: <?= $value['provinsi']; ?></li>
                  <li>Ekspedisi: <?= strtoupper($value['ekspedisi']); ?></li>
                  <li>Jenis paket: <?= $value['paket']; ?></li>
                  <li>Berat: <?= number_format($value['total_berat'], 0, ",", "."); ?></li>
                  <li>Ongkir(Rp): <?= number_format($value['ongkir'], 0, ",", "."); ?></li>
                </ul>
              </div>
            </div>
          </td>
          <td style="text-align: right;"><?= number_format($value['total_bayar'], 0, ",", "."); ?></td>
        </tr>
      <?php
        $total_semua += $value['total_bayar'];
      endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="5">Total (Rp)</th>
        <td style="text-align: right;"><?= number_format($total_semua, 0, ",", "."); ?></td>
      </tr>
    </tfoot>
  </table>
</body>

</html>