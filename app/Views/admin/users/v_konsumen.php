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
    <h5 class="m-0 d-flex flex-wrap">
      <button type="button" class="btn btn-warning mr-3 refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
      <?php if ($status == "tidak_aktif") { ?>
        <button type="button" class="btn btn-success mr-3" onclick="window.location = '<?= base_url('users/konsumen/aktif'); ?>'"><i class="fas fa-user"></i> Konsumen Aktif</button>
      <?php } else { ?>
        <button type="button" class="btn btn-danger mr-3" onclick="window.location = '<?= base_url('users/konsumen/tidak_aktif'); ?>'"><i class="fas fa-user-slash"></i> Konsumen Tidak Aktif</button>
      <?php } ?>
    </h5>
  </div>
  <div class="card-body">
    <table id="example2" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="width: 5%;">#</th>
          <th>Email</th>
          <th>Nama Lengkap</th>
          <th>Telp</th>
          <th class="text-center" style="width: 20%;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        foreach ($dataKonsumen as $key => $value) : ?>
          <tr>
            <td><?= $i++; ?></td>
            <td><?= $value['email']; ?></td>
            <td><?= $value['nama_lengkap']; ?></td>
            <td><a href="https://wa.me/<?= $value['telp']; ?>" target="_blank"><?= $value['telp']; ?></a></td>
            <td class="text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-success" onclick="detail('<?= $value['id_user']; ?>')"><i class="fa fa-eye"></i> Detail</button>
                <?php if (session('LoginUser')['role'] == "admin" && $value['aktifasi_akun'] == "0") { ?>
                  <button type="button" class="btn btn-sm btn-primary" onclick="aktifkan('<?= $value['id_user']; ?>')"><i class="fa fa-eye"></i> Aktifkan</button>
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

  function detail(id_user) {
    $.ajax({
      type: "post",
      url: "<?= base_url('/users/detail_konsumen'); ?>",
      data: {
        id_user
      },
      dataType: "json",
      success: function(response) {
        if (response.data) {
          $('.viewmodal').show().html(response.data);
          $('#modaldetail').modal("show");
        }

        if (response.error) Swal.fire('Error', response.error, 'error');
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });
  }

  function aktifkan(id_user) {
    window.location.href = "<?= base_url("users/aktifkan_akun/"); ?>" + id_user;
  }
</script>

<?= $this->endSection('main'); ?><?= base_url(); ?>/template_admin/