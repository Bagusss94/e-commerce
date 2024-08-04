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
    <h3 class="card-title">FAQS (Admin)</h3>
    <a href="<?= base_url('faqs/form'); ?>" class="btn btn-primary float-right">Tambah FAQ</a>
  </div>
  <div class="card-body">
    <table id="example2" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Question</th>
          <th>Answer</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($faqs as $faq) : ?>
          <tr>
            <td><?= $faq['question']; ?></td>
            <td><?= $faq['answer']; ?></td>
            <td>
              <a href="<?= base_url('faqs/form/' . $faq['id']); ?>" class="btn btn-warning">Edit</a>
              <button onclick="hapus(<?= $faq['id']; ?>)" class="btn btn-danger">Delete</button>
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

  function hapus(id) {
    Swal.fire({
      title: 'Hapus?',
      text: `Hapus FAQ ini?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location = `<?= base_url('faqs/delete/'); ?>${id}`;
      }
    });
  }
</script>

<?= $this->endSection(); ?>