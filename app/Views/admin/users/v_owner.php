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
      <a href="<?= base_url('users/tambah_owner'); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Owner</a>
    </h5>
  </div>
  <div class="card-body">
    <table id="example2" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="width: 5%;">#</th>
          <th style="width: 15%;">Foto profil</th>
          <th>Email</th>
          <th>Nama Lengkap</th>
          <th>No. Telp</th>
          <th class="text-center" style="width: 20%;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        foreach ($dataOwner as $key => $value) : ?>
          <tr>
            <td><?= $i++; ?></td>
            <td>
              <img src="<?= base_url('images/' . $value['foto_profil']); ?>" style="width: 100%;">
            </td>
            <td><?= $value['email']; ?></td>
            <td><?= $value['nama_lengkap']; ?></td>
            <td><a href="https://wa.me/<?= $value['telp']; ?>" target="_blank"><?= $value['telp']; ?></a></td>
            <td class="text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-primary" onclick="edit('<?= $value['id_user']; ?>')"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-sm btn-danger" onclick="hapus('<?= $value['id_user']; ?>', '<?= $value['email']; ?>')"><i class="fa fa-trash-alt"></i></button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

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

  function hapus(id, email) {
    Swal.fire({
      title: 'Hapus?',
      text: `Hapus admin dengan email ${email}?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location = `<?= base_url('users/hapus_owner/'); ?>${id}`;
      }
    });
  }

  function edit(id) {
    window.location = `<?= base_url('users/edit_owner/'); ?>${id}`;
  }
</script>

<?= $this->endSection('main'); ?><?= base_url(); ?>/template_admin/