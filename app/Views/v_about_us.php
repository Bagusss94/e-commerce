<?= $this->extend('templates/template_konsumen'); ?>

<?= $this->section('main'); ?>

<!-- Main Content -->
<div class="container">
  <div class="row">

    <div class="col-md-12">
      <div class="card border-0">
        <div class="card-body">
          <h2 class="card-header text-center" style="background-color: white; font-weight:bold;">Tentang Kami</h2>

          <center>
            <img src="<?= base_url('images/' . $setting['gambar_toko']); ?>" alt="Toko" style="width: 80%; height: 100%; margin-top: 20px; margin-bottom: 20px;">
          </center>

          <p class="text-justify mt-3">
            <?= $setting['tentang_kami']; ?>
          </p>

          <div>
            <h5 style="background-color: white; font-weight:bold;">Alamat</h5>
            <p class="text-left mt-3">
              <?= $setting['alamat']; ?>
            </p>
          </div>

          <div>
            <h5 style="background-color: white; font-weight:bold;">Contact Us</h5>
            <p class="text-left mt-3">
              <?= $setting['kontak']; ?>
            </p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection('main'); ?>