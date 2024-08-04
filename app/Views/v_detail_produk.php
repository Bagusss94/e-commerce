<?= $this->extend('templates/template_konsumen'); ?>

<?= $this->section('main'); ?>
<div class="single-product mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <!-- <h5 class="card-header">Iphone 11 Pro</h5> -->
            <div class="col-12 table-responsive d-flex">
              <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">

                    <?php
                    if ($gambar_produk) {
                      $active = 0;
                      foreach ($gambar_produk as $key => $value) : ?>
                        <li data-target="#carouselExampleCaptions" data-slide-to="<?= $active; ?>" class="<?= $active == 0 ? "active" : ""; ?>"></li>
                      <?php
                        $active++;
                      endforeach; ?>
                    <?php } else { ?>
                      <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                    <?php } ?>

                  </ol>
                  <div class="carousel-inner">

                    <?php if ($gambar_produk) {
                      $active = 0;
                      foreach ($gambar_produk as $key => $value) : ?>
                        <div class="carousel-item <?= $active == 0 ? "active" : ""; ?>">
                          <img src="<?= base_url("images/" . $value['gambar']); ?>" class="d-block w-10" width="300" alt="Big Bang">
                          <div class="carousel-caption d-none d-md-block">
                          </div>
                        </div>
                      <?php
                        $active++;
                      endforeach; ?>
                    <?php } else { ?>
                      <div class="carousel-item active">
                        <img src="<?= base_url("images/default.jpg"); ?>" class="d-block w-10" width="300" alt="Big Bang">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                      </div>
                    <?php } ?>

                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              </div>
              <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                <p style="font-weight: bold; font-size:25px"><strong><?= $produk['nama_produk']; ?></strong></p>
                <p style="color: #d0011b; font-weight: bold; font-size:30px">Rp. <?= number_format($produk['harga_produk'], 0, ",", "."); ?></p>
                <p>Berat(gr): <?= number_format($produk['berat'], 0, ",", "."); ?></p>
                <p>Satuan: <?= $produk['satuan'] ?? "-"; ?></p>
                <p>Kategori: <a href="<?= base_url('daftar-produk?cari=' . $produk['kategori']) ?>"><?= $produk['kategori'] ?? "-"; ?></a></p>
              </div>
              <div class="col-lg-3 pl-3">

                <?php $disabled = $produk['stok'] > 0 ? "" : "disabled"; ?>

                <!-- Quantity -->
                <div class="d-flex ml-4 mb-4" style="max-width: 150px">
                  <button class="btn btn-primary px-3 me-2" <?= $disabled; ?> onclick="kurangiJumlah()">
                    <i class="fa fa-minus"></i>
                  </button>

                  <div class="form-outline">
                    <input id="form1" min="1" name="jumlah" value="1" type="number" class="form-control" <?= $disabled; ?> />
                  </div>

                  <button class="btn btn-primary px-3 ms-2" <?= $disabled; ?> onclick="tambahJumlah()">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
                <!-- Quantity -->

                <!-- Price -->
                <p class="d-flex justify-content-center pr-4" style="color: #a9a399;"><?= $produk['stok'] > 0 ? "Tersisa " . $produk['stok'] . " buah" : "<span class='badge badge-danger'>Produk habis</span>"; ?> </p>
                <?php if ($produk['stok'] > 0) : ?>
                  <div class="d-flex justify-content-center pr-4">
                    <?= form_open(base_url('transaksiuser/tambah_keranjang/' . $produk['id_produk']), ['class' => 'formKeranjang']); ?>
                    <input type="number" name="jumlah" value="1" style="display: none;">
                    <a type="button" href="#" class="btn smartphone-btn tambahKeranjang">Keranjang
                      <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z" />
                        <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z" />
                      </svg>
                    </a>
                    <?= form_close(); ?>
                  </div>
                <?php endif; ?>
              </div>

            </div>
          </div>
        </div>


      </div>

      <div class="col-md-12 mt-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-header" style="background-color: white;">Deskripsi</h5>
            <div class="col-12 mt-2 table-responsive d-flex">
              <div class="col-lg-12 col-md-6 mb-4 mb-lg-0">
                <?= $produk['deskripsi_produk'] ?? "Kosong..."; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


<section id="produk" class="mt-4">
  <div class="container">
    <div class="smartphone-header">
      <div class="row">
        <div class="col-md-6">
          <h1>Produk Terkait</h1>
        </div>
        <div class="col-md-6 text-right">
          <a href="<?= base_url('daftar-produk?cari=' . $produk['kategori']); ?>">
            <h5>See All</h5>
          </a>
        </div>
      </div>
    </div>
    <div class="row justify-content-start">
      <?php
      $db = db_connect();
      foreach ($produk_terkait as $key => $value) :
        // mengambil detail gambar berdasarkan id produk
        $gambar = $db->table('gambar_produk')->getWhere([
          'id_produk' => $value['id_produk'],
          'status' => 1
        ])->getRowArray();

      ?>
        <div class="col-md-4 mb-4">
          <div class="card text-center" style="width: 18rem;border:none;">
            <div class="shadow pt-3 bg-white rounded">
              <img src="<?= $gambar ? base_url('images/' . $gambar['gambar']) : base_url("images/default.jpg"); ?>" class="card-img-top p-2" alt="Gambar produk <?= $value['nama_produk']; ?>">
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
    </div>
  </div>
</section>

<script>
  function tambahJumlah() {
    const jumlah = document.querySelectorAll('input[type=number]');
    jumlah.forEach(e => {
      e.stepUp()
    });
  }

  function kurangiJumlah() {
    const jumlah = document.querySelectorAll('input[type=number]');
    jumlah.forEach(e => {
      e.stepDown()
    });
  }

  $(".tambahKeranjang").click(function(e) {
    e.preventDefault();
    $(".formKeranjang").submit();
  });

  $("#form1").keyup(function(e) {
    e.preventDefault();
    $("input[type=number]").val($(this).val());
  });
</script>

<?= $this->endSection('main'); ?>