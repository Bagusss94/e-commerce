<?= $this->extend('templates/template_konsumen'); ?>

<?= $this->section('main'); ?>

<!-- Smart Phone start  -->
<section id="smartphone">
  <div class="container">
    <div class="smartphone-header">
      <div class="row">
        <div class="d-flex justify-content-between align-items-center mt-4" style="width: 100%;">
          <div class="col-md-6 ml-3">
            <h1>Produk</h1>
          </div>
          <div class="form-group has-search mr-5">
            <?= form_open("", ['method' => 'GET']); ?>
            <div class="fa fa-search form-control-feedback"></div>
            <input type="text" class="form-control" name="cari" placeholder="Search" value="<?= $cari ? $cari : ""; ?>">
            <?= form_close(); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex flex-wrap justify-content-center ml-4">
      <?php if ($produk) : ?>
        <?php
        $db = db_connect();
        foreach ($produk as $key => $value) :
          // mengambil detail gambar berdasarkan id produk
          $gambar = $db->table('gambar_produk')->getWhere([
            'id_produk' => $value['id_produk'],
            'status' => 1
          ])->getRowArray();
        ?>
          <div class="col-md-4 mb-4">
            <div class="card text-center" style="width: 18rem;border:none;">
              <div class="shadow pt-3 bg-white rounded">
                <img src="<?= $gambar ? base_url('images/' . $gambar['gambar']) : base_url("images/defaultt.jpg"); ?>" class="card-img-top p-2" alt="Gambar produk <?= $value['nama_produk']; ?>">
                <div class="card-body">

                  <a href="<?= base_url('detail-produk/' . $value['id_produk']); ?>" class="text-decoration-none text-dark">
                    <h5 class="card-title"><b><?= $value['nama_produk']; ?></b></h5>

                    <?php if ($value['stok'] < 1) { ?>
                      <span class="badge badge-danger mb-2">Produk habis</span>
                    <?php } else { ?>
                      <h6>
                        <strong>Stok: <?= $value['stok']; ?></strong>
                      </h6>
                    <?php } ?>

                    <p><b>Rp. <?= number_format($value['harga_produk'], 0, ",", "."); ?></b></p>
                  </a>
                  <?php if ($value['stok'] >= 1) : ?>
                    <a style="pointer-events: <?= $value['stok'] < 1 ? 'none' : 'all'; ?>;" href="<?= base_url('tambah-keranjang/' . $value['id_produk']); ?>" id="buy-now" class="btn smartphone-btn <?= $value['stok'] < 1 ? 'disabled' : ''; ?>">Tambah Keranjang
                      <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z" />
                        <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z" />
                      </svg>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <h4 class="text-danger"><b>Produk kosong...</b></h4>
      <?php endif; ?>
    </div>
  </div>

  <?= $page_count > 1 ? $pager_links : ""; ?>

</section>
<!-- End  -->

<?= $this->endSection('main'); ?>