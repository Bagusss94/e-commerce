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
      <a href="" class="btn btn-primary" id="tambah-satuan"><i class="fas fa-plus"></i> Tambah Satuan</a>
    </h5>
  </div>
  <div class="card-body">
    <table id="example2" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="width: 5%;">#</th>
          <th>Satuan</th>
          <th class="text-center" style="width: 20%;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        $db = db_connect();
        foreach ($dataSatuan as $key => $value) :
          $foreign = $db->table('produk')->where('id_satuan', $value['id_satuan'])->get()->getNumRows();
        ?>
          <tr>
            <td><?= $i++; ?></td>
            <td><?= $value['satuan']; ?></td>
            <td class="text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-primary" onclick="edit('<?= $value['id_satuan']; ?>')"><i class="fa fa-edit"></i></button>
                <?php if ($foreign == 0) : ?>
                  <button type="button" class="btn btn-sm btn-danger" onclick="hapus('<?= $value['id_satuan']; ?>', '<?= $value['satuan']; ?>')"><i class="fa fa-trash-alt"></i></button>
                <?php endif; ?>
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

  function hapus(id, satuan) {
    Swal.fire({
      title: 'Hapus?',
      text: `Hapus satuan ${satuan}?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location = `<?= base_url('satuan/hapus/'); ?>${id}`;
      }
    });
  }

  function edit(id) {
    $.ajax({
      url: "<?= base_url("satuan/modalForm/"); ?>" + id,
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.viewmodal').show().html(response.data);
          $('#modalFormSatuan').modal("show");
        }

        if (response.error) Swal.fire('Error', response.error, 'error');
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });
  }

  $('#tambah-satuan').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= base_url("satuan/modalForm") ?>",
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.viewmodal').show().html(response.data);
          $('#modalFormSatuan').modal("show");
        }

        if (response.error) Swal.fire('Error', response.error, 'error');
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });
  });
</script>

<?= $this->endSection('main'); ?><?= base_url(); ?>/template_admin/