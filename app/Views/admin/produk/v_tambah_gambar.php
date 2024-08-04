<?= $this->extend('templates/template_admin'); ?>

<?= $this->section('main'); ?>

<!-- Ekko Lightbox -->
<link rel="stylesheet" href="<?= base_url(); ?>/template_admin/plugins/ekko-lightbox/ekko-lightbox.css">
<!-- Ekko Lightbox -->
<script src="<?= base_url(); ?>/template_admin/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

<div class="card card-primary card-outline">
  <div class="card-header">
    <h5 class="m-0 d-flex justify-content-between flex-wrap">
      <a href="<?= base_url('produk'); ?>" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
      <button type="button" class="btn btn-info refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
    </h5>
  </div>
  <div class="card-body">

    <h3>Detail Produk <?= $dataProduk['nama_produk']; ?></h3>
    <ul class="list-group">
      <li class="list-group-item"><b>Harga:</b> Rp <?= number_format($dataProduk['harga_produk'], 0, ",", "."); ?></li>
      <li class="list-group-item"><b>Kategori:</b> <?= $dataProduk['kategori'] ?? "-"; ?></li>
      <li class="list-group-item"><b>Stok:</b> <?= $dataProduk['stok']; ?></li>
      <li class="list-group-item"><b>Satuan:</b> <?= $dataProduk['satuan'] ?? "-"; ?></li>
      <li class="list-group-item"><b>Berat:</b> <?= number_format($dataProduk['berat'], 0, ",", "."); ?> gram</li>
      <li class="list-group-item"><b>Deskripsi:</b><br> <?= $dataProduk['deskripsi_produk']; ?></li>
    </ul>

    <?php if (session('LoginUser')['role'] == "admin") { ?>
      <hr>

      <h3>Tambah Gambar</h3>

      <?php if (validation_errors()) { ?>
        <div class="alert alert-danger alert-dismissible" id="errors">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-ban"></i> Error!</h5>
          <?= validation_list_errors(); ?>
        </div>
      <?php } ?>

      <?= form_open_multipart(""); ?>
      <div class="row row-img">
        <div class="col-lg-3">
          <img src="<?= base_url(); ?>/images/defaultt.jpg" style="width: 100%;" class="img-thumbnail img-preview">
        </div>
        <div class="col-lg-9">
          <div class="input-group mb-3">
            <input type="hidden" name="id_produk" value="<?= $dataProduk['id_produk']; ?>">
            <input type="file" class="form-control prevImg" name="gambar">
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Simpan gambar</button>
            </div>
          </div>
        </div>
      </div>
      <?= form_close(); ?>
    <?php } ?>

    <hr>

    <h3>Daftar Gambar</h3>

    <div class="d-flex justify-content-center flex-wrap">
      <!-- gambar cover -->
      <?php if ($coverGambar) { ?>
        <div class="col-sm-3">
          <div class="card">
            <div class="card-body">
              <a href="<?= base_url("images/" . $coverGambar['gambar']); ?>" data-toggle="lightbox" data-gallery="gallery">
                <img src="<?= base_url("images/" . $coverGambar['gambar']); ?>" class="img-fluid w-100 mb-2" alt="white sample" />
              </a>
              <?php if (session('LoginUser')['role'] == 'admin') { ?>
                <button type="button" class="btn btn-block btn-success"><i class="fas fa-star"></i> Cover produk</button>

                <button type="button" class="btn btn-block btn-danger" onclick="hapus('<?= $coverGambar['id_gambar']; ?>')"><i class="fa fa-trash-alt"></i> Hapus</button>
              <?php } ?>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if ($coverGambar || $dataGambar) { ?>
        <!-- gambar biasa -->
        <?php foreach ($dataGambar as $key => $value) : ?>
          <div class="col-sm-3">
            <div class="card">
              <div class="card-body">
                <a href="<?= base_url("images/" . $value['gambar']); ?>" data-toggle="lightbox" data-gallery="gallery">
                  <img src="<?= base_url("images/" . $value['gambar']); ?>" class="img-fluid w-100 mb-2" alt="white sample" />
                </a>
                <?php if (session('LoginUser')['role'] == 'admin') { ?>
                  <button type="button" class="btn btn-block btn-info" onclick="jadikan_cover('<?= $value['id_produk']; ?>','<?= $value['id_gambar']; ?>')"><i class="far fa-star"></i> Jadikan cover</button>

                  <button type="button" class="btn btn-block btn-danger" onclick="hapus('<?= $value['id_gambar']; ?>')"><i class="fa fa-trash-alt"></i> Hapus</button>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
    </div>
  <?php } else { ?>
    <h5 class="text-center text-bold">Gambar masih kosong!</h5>
  <?php } ?>
  </div>
</div>

<script>
  $(function() {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });
  });

  function hapus(id_gambar) {
    Swal.fire({
      title: 'Hapus Gambar',
      text: "Apakah anda yakin menghapus gambar ini?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'batal',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "<?= base_url('produk/hapus_gambar'); ?>",
          data: {
            id_gambar
          },
          dataType: "json",
          success: function(response) {
            if (response.error) Swal.fire('Error', response.error, 'error').then(() => window.location.reload());
            if (response.success) Swal.fire('Success', response.success, 'success').then(() => window.location.reload());
          },
          error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
          }
        });
      }
    });
  }

  function jadikan_cover(id_produk, id_gambar) {
    $.ajax({
      type: "post",
      url: "<?= base_url('produk/jadikan_cover'); ?>",
      data: {
        id_produk,
        id_gambar
      },
      dataType: "json",
      success: function(response) {
        if (response.error) Swal.fire('Error', response.error, 'error').then(() => window.location.reload());
        if (response.success) Swal.fire('Success', response.success, 'success').then(() => window.location.reload());
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });
  }
</script>

<?= $this->endSection('main'); ?><?= base_url(); ?>/template_admin/