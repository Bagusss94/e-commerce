<?= $this->extend('templates/template_konsumen'); ?>

<?= $this->section('main'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url(); ?>/template_admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/template_admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/template_admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<script src="<?= base_url(); ?>/template_admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/template_admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/template_admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/template_admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<div class="single-product mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <h5 class="card-header">History Transaksi</h5>
          <div class="card-body">
            <div class="col-12 table-responsive datakeranjang">
              <table class="table table-striped" id="example2">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Alamat Pengiriman</th>
                    <th>Total (Rp)</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($transaksi as $key => $value) : ?>
                    <tr>
                      <td><?= $no++; ?>.</td>
                      <td><?= $value['id_transaksi']; ?></td>
                      <td><?= $value['tanggal']; ?></td>
                      <td><?= $value['alamat']; ?></td>
                      <td class="text-right"><?= number_format($value['total_bayar'], 0, ",", "."); ?></td>
                      <td class="d-flex flex-column justify-content-center">
                        <button class="btn btn-info mb-2" title="Cek pembayaran" onclick="pembayaran('<?= $value['id_transaksi']; ?>')">
                          <i class="fa fa-info-circle"></i> Cek pembayaran
                        </button>
                        <button class="btn btn-primary mb-2" title="Detail history" onclick="detail('<?= $value['id_transaksi']; ?>')">
                          <i class="fa fa-eye"></i> Detail
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
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

  function detail(id_transaksi) {
    window.location = "<?= base_url('history/'); ?>" + id_transaksi;
  }

  function pembayaran(id_transaksi) {
    $.ajax({
      type: "post",
      url: "<?= base_url('transaksiuser/cekPembayaran'); ?>",
      data: {
        id_transaksi
      },
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.viewmodal').html(response.data).show();
          $("#modalcekpembayaran").modal("show");
        }

        if (response.error) {
          Swal.fire('Error', response.error, 'error').then(() => window.location.reload());
        }
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });
  }
</script>

<?= $this->endSection('main'); ?>