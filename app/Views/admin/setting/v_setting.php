<?= $this->extend('templates/template_admin'); ?>

<?= $this->section('main'); ?>

<!-- summernote -->
<link rel="stylesheet" href="<?= base_url(); ?>/template_admin/plugins/summernote/summernote-bs4.min.css">
<script src="<?= base_url(); ?>/template_admin/plugins/summernote/summernote-bs4.min.js"></script>

<!-- Ekko Lightbox -->
<link rel="stylesheet" href="<?= base_url(); ?>/template_admin/plugins/ekko-lightbox/ekko-lightbox.css">
<!-- Ekko Lightbox -->
<script src="<?= base_url(); ?>/template_admin/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

<div class="card card-primary card-outline">
  <div class="card-header d-flex justify-content-between flex-wrap">
    <h5 class="m-0">
      <button type="button" class="btn btn-warning refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
    </h5>
    <ul class="nav nav-pills ml-auto p-2">
      <li class="nav-item"><a class="nav-link <?= $bagianFokus == 'setting' ? 'active' : ''; ?>" href="#setting_web" data-toggle="tab">Setting Web</a></li>
      <li class="nav-item"><a class="nav-link <?= $bagianFokus == 'carousel' ? 'active' : ''; ?>" href="#carousel" data-toggle="tab">Carousel</a></li>
    </ul>
  </div>
  <div class="card-body">

    <?php if (validation_errors()) { ?>
      <div class="alert alert-danger alert-dismissible temp-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> Error!</h5>
        <?= validation_list_errors(); ?>
      </div>
    <?php } ?>

    <div class="tab-content">
      <div class="tab-pane <?= $bagianFokus == 'setting' ? 'active' : ''; ?>" id="setting_web">
        <?= form_open_multipart('setting/ubah_setting'); ?>
        <div class="form-group">
          <label for="nama_web">Nama Website</label>
          <input type="text" class="form-control" name="nama_web" value="<?= old('nama_web') ? old('nama_web') : $setting['nama_web']; ?>">
        </div>
        <div class="form-group row row-img">
          <div class="col-lg-3">
            <img src="<?= base_url('images/' . $setting['logo_web']); ?>" style="width: 100%;" class="img-thumbnail img-preview">
          </div>
          <div class="col-lg-9">
            <label for="">Logo Website</label>
            <input type="file" class="form-control prevImg" name="logo_web">
          </div>
        </div>
        <div class="form-group row row-img">
          <div class="col-lg-3">
            <img src="<?= base_url('images/' . $setting['gambar_toko']); ?>" style="width: 100%;" class="img-thumbnail img-preview">
          </div>
          <div class="col-lg-9">
            <label for="">Gambar Toko</label>
            <input type="file" class="form-control prevImg" name="gambar_toko">
          </div>
        </div>
        <!-- <div class="form-group">
          <label for="deskripsi">Deskripsi</label>
          <textarea name="deskripsi" class="form-control summernote"><?= old('deskripsi') ? old('deskripsi') : $setting['deskripsi']; ?></textarea>
        </div> -->
        <div class="form-group">
          <label for="tentang_kami">Tentang kami</label>
          <textarea name="tentang_kami" class="form-control summernote"><?= old('tentang_kami') ? old('tentang_kami') : $setting['tentang_kami']; ?></textarea>
        </div>
        <div class="form-group">
          <label for="kontak">Kontak kami</label>
          <textarea name="kontak" class="form-control summernote"><?= old('kontak') ? old('kontak') : $setting['kontak']; ?></textarea>
        </div>
        <div class="form-group">
          <label for="alamat">Alamat Toko</label>
          <textarea name="alamat" class="form-control" rows="2"><?= old('alamat') ? old('alamat') : $setting['alamat']; ?></textarea>
        </div>
        <div class="form-group">
          <label for="provinsi">Provinsi Toko</label>
          <select name="provinsi" id="provinsi" class="form-control" required>
          </select>
        </div>
        <div class="form-group">
          <label for="distrik">Kota/Kabupaten Toko</label>
          <select name="distrik" id="distrik" class="form-control" required>
          </select>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i> Simpan perubahan</button>
        </div>
        <?= form_close(); ?>
      </div>

      <div class="tab-pane <?= $bagianFokus == 'carousel' ? 'active' : ''; ?>" id="carousel">
        <?= form_open_multipart('setting/tambah_carousel', ['class' => "form_carousel"]); ?>
        <div class="row row-img">
          <div class="col-lg-4">
            <img src="<?= base_url(); ?>/images/default.jpg" style="width: 100%;" class="img-thumbnail img-preview">
          </div>
          <div class="col-lg-8">
            <div class="form-group">
              <label for="nama_gambar">Gambar Carousel</label>
              <input type="file" class="form-control prevImg" id="nama_gambar" name="nama_gambar">
            </div>
            <div class=" form-group">
              <label for="nama_carousel">Nama Carousel</label>
              <input type="text" name="nama_carousel" class="form-control" id="nama_carousel" value="<?= old('nama_carousel'); ?>">
            </div>
            <div class="form-group">
              <label for="deskripsi">Keterangan</label>
              <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control"><?= old('deskripsi'); ?></textarea>
            </div>
            <div class="form-group">
              <button class="btn btn-block btn-primary" type="submit"><i class="fa fa-save"></i> Simpan gambar</button>
            </div>
          </div>
        </div>
        <?= form_close(); ?>

        <hr>

        <?php if (!$carousel) { ?>
          <h5 class="text-bold text-center">Carousel masih kosong!</h5>
        <?php } ?>

        <!-- gambar biasa -->
        <div class="row">
          <?php foreach ($carousel as $key => $value) : ?>
            <div class="col-sm-4">
              <div class="card">
                <div class="card-body">
                  <a href="<?= base_url("images/" . $value['nama_gambar']); ?>" data-toggle="lightbox" data-gallery="gallery">
                    <img src="<?= base_url("images/" . $value['nama_gambar']); ?>" class="img-fluid w-100 mb-2" alt="white sample" />
                  </a>
                  <h6 class="text-bold"><?= $value['nama_carousel']; ?></h6>
                  <p class="text-justify mb-2"><?= $value['deskripsi']; ?></p>

                  <button type="button" class="btn btn-block btn-danger" onclick="hapus('<?= $value['id_carousel']; ?>')"><i class="fa fa-trash-alt"></i> Hapus</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function hapus(id_carousel) {
    Swal.fire({
      title: 'Hapus?',
      text: "Apakah anda yakin ingin menghapus carousel ini?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location = "<?= base_url('setting/hapus_carousel/'); ?>" + id_carousel;
      }
    })
  }

  function getProvinsi(id_provinsi_sistem) {
    $.ajax({
      url: "<?= base_url('RajaOngkir/getProvinsi'); ?>",
      dataType: "json",
      beforeSend: function() {
        $('#provinsi').html("");
      },
      success: function(response) {
        if (response.rajaongkir.results) {
          const provinsi = response.rajaongkir.results;
          // console.log(provinsi);
          let body = `<option value="">-- Pilih --</option>`;
          provinsi.forEach(prov => {
            body += `<option value="${prov.province_id}" ${prov.province_id === id_provinsi_sistem ? 'selected':''}>${prov.province}</option>`;
          });
          $('#provinsi').html(body);
          $('#provinsi').removeAttr('disabled');

          // panggil distrik
          getDistrik("<?= $setting['distrik']; ?>");
        }
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });
  }

  function getDistrik(id_distrik_sistem) {
    $.ajax({
      type: "post",
      url: "<?= base_url('RajaOngkir/getKota'); ?>",
      data: {
        id_provinsi: $('#provinsi').val()
      },
      beforeSend: function() {
        $('#distrik').html("");
      },
      dataType: "json",
      success: function(response) {
        if (response.rajaongkir.results) {
          const distrik = response.rajaongkir.results;
          // console.log(distrik);

          let body = `<option value="">-- Pilih --</option>`;
          distrik.forEach(prov => {
            body += `<option value="${prov.city_id}" ${prov.city_id === id_distrik_sistem ? 'selected':''}>${prov.type} ${prov.city_name}</option>`;
          });
          $('#distrik').html(body);

          $('#provinsi').removeAttr('disabled');
          $('#distrik').removeAttr('disabled');
        }
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });
  }

  function start() {
    $('#provinsi').attr('disabled', true);
    $('#distrik').attr('disabled', true);
  }

  $("#provinsi").change(function(e) {
    e.preventDefault();
    start();
    getDistrik("<?= $setting['distrik']; ?>");
  });

  $(document).ready(function() {
    start();
    getProvinsi("<?= $setting['provinsi']; ?>");

    // Summernote
    $('.summernote').summernote({
      height: 200,
    });

    // setting input telp
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });
  });
</script>
<?= $this->endSection('main'); ?><?= base_url(); ?>