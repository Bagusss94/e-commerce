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
      <?php if (session('LoginUser')['role'] == "admin") { ?>
        <a href="<?= base_url('produk/tambah'); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Produk</a>
      <?php } ?>
    </h5>
  </div>
  <div class="card-body">
    <table id="example2" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="width: 5%;">#</th>
          <th style="width: 40%;">Produk</th>
          <th>Harga (Rp)</th>
          <th>Berat (gram)</th>
          <th>Stok</th>
          <th>Satuan</th>
          <th>Kategori</th>
          <th class="text-center" style="width: 20%;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        $db = db_connect();
        foreach ($dataProduk as $key => $value) : ?>
          <tr>
            <td><?= $i++; ?></td>
            <td><?= $value['nama_produk']; ?></td>
            <td class="text-right"><?= number_format($value['harga_produk'], 0, ",", "."); ?></td>
            <td class="text-right"><?= number_format($value['berat'], 0, ",", "."); ?></td>
            <td class="text-right"><?= $value['stok']; ?></td>
            <td><?= $value['satuan'] == null ? "-" : $value['satuan']; ?></td>
            <td><?= $value['kategori'] == null ? "-" : $value['kategori']; ?></td>
            <td class="text-center">
              <div class="btn-group">
                <button type="button" class="btn btn-sm btn-info" onclick="tambah_gambar('<?= $value['id_produk']; ?>')"><i class="fa fa-image"></i></button>
                <button type="button" class="btn btn-sm btn-primary" onclick="edit('<?= $value['id_produk']; ?>')"><i class="fa fa-edit"></i></button>
                <?php
                $cekForeignTransaksi = $db->table('detail_transaksi')->where('id_produk', $value['id_produk'])
                  ->get()->getNumRows();
                $cekForeignKeranjang = $db->table('keranjang')->where('id_produk', $value['id_produk'])
                  ->get()->getNumRows();
                // jika tidak ada foreign sama sekali dari 2 tabel tersebut
                if ($cekForeignTransaksi == 0 && $cekForeignKeranjang == 0) : ?>
                  <button type="button" class="btn btn-sm btn-danger" onclick="hapus('<?= $value['id_produk']; ?>', '<?= $value['nama_produk']; ?>')"><i class="fa fa-trash-alt"></i></button>
                <?php endif; ?>
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

  function hapus(id, nama_produk) {
    Swal.fire({
      title: 'Hapus?',
      text: `Hapus produk ${nama_produk}?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location = `<?= base_url('produk/hapus/'); ?>${id}`;
      }
    });
  }

  function edit(id) {
    window.location = `<?= base_url('produk/edit/'); ?>${id}`;
  }

  function tambah_gambar(id) {
    window.location = `<?= base_url('produk/tambah_gambar/'); ?>${id}`;
  }

  function detail_produk(id) {
    window.location = `<?= base_url('produk/detail_produk/'); ?>${id}`;
  }
</script>

<?= $this->endSection('main'); ?><?= base_url(); ?>