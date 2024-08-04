<?= $this->extend('templates/template_admin'); ?>

<?= $this->section('main'); ?>

<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url(); ?>/template_admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/template_admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/template_admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<script src="<?= base_url(); ?>/template_admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/template_admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/template_admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/template_admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<div class="card card-primary card-outline">
  <div class="card-header">
    <h5 class="m-0 d-flex justify-content-between flex-wrap">
      <button type="button" class="btn btn-warning refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
    </h5>
  </div>
  <div class="card-body">

    <form action="" method="get">
      <div class="row">
        <div class="col-md-3 form-group">
          <label for="tanggal_mulai">Tanggal Mulai</label>
          <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="<?= $tanggal_awal; ?>" autofocus>
        </div>
        <div class="col-md-3 form-group">
          <label for="tanggal_selesai">Tanggal Selesai</label>
          <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="<?= $tanggal_akhir; ?>" class="form-control">
        </div>
        <div class="col-md-2 form-group">
          <label for="status_transaksi">Status Transaksi</label>
          <select name="status_transaksi" id="status_transaksi" class="form-control">
            <option value="">-- Tampilkan semua --</option>
            <option value="pending" <?= $status == "pending" ? "selected" : ""; ?>>Pending</option>
            <option value="dikemas" <?= $status == "dikemas" ? "selected" : ""; ?>>Dikemas</option>
            <option value="dikirim" <?= $status == "dikirim" ? "selected" : ""; ?>>Dikirim</option>
            <option value="selesai" <?= $status == "selesai" ? "selected" : ""; ?>>Selesai</option>
            <option value="gagal" <?= $status == "gagal" ? "selected" : ""; ?>>Gagal</option>
          </select>
        </div>
        <div class="col-md-2 form-group">
          <label>#</label>
          <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-search"></i> Tampilkan</button>
        </div>
        <div class="col-md-2 form-group">
          <label>#</label>
          <button type="button" onclick="cetakLaporan();" class="btn btn-block btn-success"><i class="fa fa-file"></i> Cetak Laporan</button>
        </div>
      </div>
    </form>

    <table id="example2" class="table table-bordered table-striped table-sm text-sm">
      <thead>
        <tr>
          <th style="width: 5%;">#</th>
          <th>ID Transaksi</th>
          <th>Tanggal</th>
          <th style="width: 15%;">Status Transaksi</th>
          <th>Total Bayar (Rp)</th>
          <th class="text-center" style="width: 18%;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        foreach ($transaksi as $key => $value) : ?>
          <tr>
            <td><?= $i++; ?></td>
            <td><?= $value['id_transaksi']; ?></td>
            <td><?= date('d-m-Y H:i:s', strtotime($value['tanggal'])); ?></td>

            <?php

            if ($value['status_transaksi'] === "gagal") {
              $class = "badge badge-danger";
            } elseif ($value['status_transaksi'] === "selesai") {
              $class = "badge badge-success";
            } else {
              $class = "badge badge-info";
            }

            ?>

            <td class="text-center"><span class="<?= $class; ?>"><?= strtoupper($value['status_transaksi']); ?></span></td>
            <td class="text-right"><?= number_format($value['total_bayar'], 0, ",", "."); ?></td>
            <td class="text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-info" title="Detail Transaksi" onclick="detail('<?= $value['id_transaksi']; ?>')"><i class="fa fa-eye"></i><?= session('LoginUser')['role'] == 'admin' ? '' : ' Detail'; ?></button>

                <button type="button" class="btn btn-sm btn-success" title="Cetak Transaksi" onclick="cetak('<?= $value['id_user']; ?>','<?= $value['id_transaksi']; ?>')"><i class="fa fa-print"></i><?= session('LoginUser')['role'] == 'admin' ? '' : ' Cetak'; ?></button>

                <?php if (session('LoginUser')['role'] == 'admin') { ?>
                  <button type="button" class="btn btn-sm btn-primary" title="Pembayaran" onclick="pembayaran('<?= $value['id_transaksi']; ?>')"><i class="fa fa-money-bill"></i></button>
                <?php } ?>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
  $(function() {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  function detail(id) {
    window.location = `<?= base_url('transaksi/detail/'); ?>${id}`;
  }

  function cetak(id_user, id_transaksi) {
    window.open(`<?= base_url('transaksi/cetak-invoice/'); ?>${id_transaksi}/${id_user}`, "_blank");
  }

  function cetakLaporan() {
    const tgl_mulai = $("#tanggal_mulai").val();
    const tgl_akhir = $("#tanggal_selesai").val();
    const status = $("#status_transaksi").val();
    if (tgl_mulai && tgl_akhir && status) {
      window.open(`<?= base_url('transaksi/cetak-laporan?tgl_awal='); ?>${tgl_mulai}&tgl_akhir=${tgl_akhir}&status=${status}`, "_blank");
    } else if (tgl_mulai && tgl_akhir) {
      window.open(`<?= base_url('transaksi/cetak-laporan?tgl_awal='); ?>${tgl_mulai}&tgl_akhir=${tgl_akhir}`, "_blank");
    } else if (status) {
      window.open(`<?= base_url('transaksi/cetak-laporan?status='); ?>${status}`, "_blank");
    } else {
      window.open(`<?= base_url('transaksi/cetak-laporan'); ?>`, "_blank");
    }
  }

  function pembayaran(id_transaksi) {
    $.ajax({
      type: "post",
      url: "<?= base_url('transaksi/modalpembayaran'); ?>",
      data: {
        id_transaksi
      },
      dataType: "json",
      success: function(response) {
        // console.log(response);
        if (response.data) {
          $('.viewmodal').html(response.data).show();
          $('#modalpembayaran').modal('show');
        }
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });
  }
</script>

<?= $this->endSection('main'); ?><?= base_url(); ?>/template_admin/