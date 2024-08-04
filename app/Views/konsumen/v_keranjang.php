<?= $this->extend('templates/template_konsumen'); ?>

<?= $this->section('main'); ?>
<section class="h-100 gradient-custom">
  <div class="container">
    <div class="row d-flex justify-content-center my-4">
      <div class="col-md-8">
        <div class="row">
          <!-- Keranjang -->
          <div class="col-md-12">
            <div class="card mb-4">
              <div class="card-header py-3">
                <h5 class="mb-0 font-weight-bold">Keranjang - <?= $jmlItems; ?> items</h5>
              </div>
              <div class="card-body">
                <?php
                $total = 0;
                if ($keranjang) {
                  foreach ($keranjang as $k) :
                    $gambarProduk = !empty($k['gambar']) ?  $k['gambar'] : "default.jpg";
                ?>
                    <!-- Single item -->
                    <div class="row position-relative p-2">
                      <div class="position-absolute"></div>
                      <div class=" col-lg-3 col-md-12 mb-4 mb-lg-0">
                        <!-- Image -->
                        <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">

                          <img src="<?= base_url('images/' . $gambarProduk); ?>" class="w-100" />
                          <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                          </a>
                        </div>
                        <!-- Image -->
                      </div>

                      <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                        <!-- Data -->
                        <p><strong><?= $k['nama_produk']; ?></strong></p>
                        <ul>
                          <li>Berat(gr): <?= number_format($k['berat'], 0, ",", "."); ?></li>
                          <li>Harga(Rp): <?= number_format($k['harga_produk'], 0, ",", "."); ?></li>
                          <li>Stok: <?= $k['stok'] > 0 ? number_format($k['stok'], 0, ",", ".") : "<span class='badge badge-danger'>Habis</span>"; ?></li>
                        </ul>

                        <button type="button" class="btn btn-danger btn-sm me-1 mb-2 position-relative" data-mdb-toggle="tooltip" title="Remove item" onclick="hapusItem('<?= $k['id_keranjang']; ?>')" style="z-index: 2;">
                          <i class="fa fa-trash"></i> Hapus Item
                        </button>
                        <!-- Data -->
                      </div>

                      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                        <!-- Quantity -->
                        <div class="d-flex ml-4 mb-4 kelolaJumlahItem" style="max-width: 150px">
                          <button class="btn btn-primary px-3 me-2 kurangiItem" id_keranjang="<?= $k['id_keranjang']; ?>">
                            <i class="fa fa-minus"></i>
                          </button>

                          <div class="form-outline">
                            <input id="form1" min="0" name="jumlah" value="<?= $k['jumlah']; ?>" type="number" class="form-control jumlahItem" id_keranjang="<?= $k['id_keranjang']; ?>" />
                          </div>

                          <button class="btn btn-primary px-3 ms-2 tambahItem" id_keranjang="<?= $k['id_keranjang']; ?>">
                            <i class="fa fa-plus"></i>
                          </button>
                        </div>
                        <!-- Quantity -->

                        <!-- Price -->
                        <p class="text-start text-md-center mr-3">
                          <strong>Rp. <?= number_format($k['subtotal'], 0, ",", "."); ?></strong>
                        </p>
                        <!-- Price -->
                      </div>
                    </div>

                    <hr class="my-4" />
                    <!-- Single item -->
                  <?php
                    // ketika stok lebih dari 0
                    $total += $k['subtotal'];
                  endforeach;
                } else { ?>
                  <h4 class="text-center text-danger font-weight-bold">Keranjang Kosong</h4>
                <?php } ?>
              </div>
            </div>
          </div>
          <!-- endKeranjang -->

          <!-- Tidak dapat diproses -->
          <?php if ($gagalDiproses) : ?>
            <div class="col-md-12">
              <div class="card mb-4">
                <div class="card-header py-3">
                  <h5 class="mb-0 text-danger font-weight-bold">Gagal diproses</h5>
                </div>
                <div class="card-body">
                  <?php
                  foreach ($gagalDiproses as $g) :
                    $gambarProduk = !empty($g['gambar']) ?  $g['gambar'] : "default.jpg";
                  ?>
                    <!-- Single item -->
                    <div class="row position-relative p-2">
                      <div class="position-absolute" style="background-color: rgba(244, 241, 241, 0.625); left: 0; right: 0; top: 0; bottom: 0; z-index: 1;"></div>
                      <div class=" col-lg-3 col-md-12 mb-4 mb-lg-0">
                        <!-- Image -->
                        <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">

                          <img src="<?= base_url('images/' . $gambarProduk); ?>" class="w-100" />
                          <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                          </a>
                        </div>
                        <!-- Image -->
                      </div>

                      <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                        <!-- Data -->
                        <p><strong><?= $g['nama_produk']; ?></strong></p>
                        <ul>
                          <li>Berat(gr): <?= number_format($g['berat'], 0, ",", "."); ?></li>
                          <li>Harga(Rp): <?= number_format($g['harga_produk'], 0, ",", "."); ?></li>
                          <li>Stok: <?= $g['stok'] > 0 ? number_format($g['stok'], 0, ",", ".") : "<span class='badge badge-danger'>Habis</span>"; ?></li>
                        </ul>

                        <button type="button" class="btn btn-danger btn-sm me-1 mb-2 position-relative" data-mdb-toggle="tooltip" title="Remove item" onclick="hapusItem('<?= $g['id_keranjang']; ?>')" style="z-index: 2;">
                          <i class="fa fa-trash"></i> Hapus Item
                        </button>
                        <!-- Data -->
                      </div>

                      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                        <!-- Quantity -->
                        <div class="d-flex ml-4 mb-4 kelolaJumlahItem" style="max-width: 150px">
                          <button class="btn btn-primary px-3 me-2">
                            <i class="fa fa-minus"></i>
                          </button>

                          <div class="form-outline">
                            <input id="form1" min="1" name="jumlah" value="<?= $g['jumlah']; ?>" type="number" class="form-control jumlahItem" />
                          </div>

                          <button class="btn btn-primary px-3 ms-2">
                            <i class="fa fa-plus"></i>
                          </button>
                        </div>
                        <!-- Quantity -->

                        <!-- Price -->
                        <p class="text-start text-md-center mr-3">
                          <strong>Rp. <?= number_format($g['subtotal'], 0, ",", "."); ?></strong>
                        </p>
                        <!-- Price -->
                      </div>
                    </div>
                    <!-- Single item -->
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          <?php endif; ?>
          <!-- End Tidak dapat diproses -->
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0 font-weight-bold">Ringkasan</h5>
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                <div>
                  <strong>Total </strong>
                </div>
                <span><strong>Rp. <?= number_format($total, 0, ",", "."); ?></strong></span>
              </li>
            </ul>

            <?php if ($keranjang) { ?>
              <a href="<?= base_url('checkout'); ?>" class="btn btn-success btn-lg btn-block">Checkout</a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function hapusItem(id_keranjang) {
    Swal.fire({
      title: 'Hapus item',
      text: `Apakah anda yakin menghapus item ini?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'batal',
    }).then((result) => {
      if (result.isConfirmed) {
        window.location = "<?= base_url('transaksiuser/hapusItem/'); ?>" + id_keranjang;
      }
    })
  }

  function ubahJumlah(id_keranjang, jumlah) {
    $.ajax({
      type: "post",
      url: "<?= base_url('transaksiuser/ubahJumlahItem'); ?>",
      data: {
        id_keranjang: id_keranjang,
        jumlah: jumlah,
      },
      dataType: "json",
      success: function(response) {
        if (response.success) Swal.fire('Success', response.success, 'success').then(() => window.location.reload());
        if (response.error) Swal.fire('Error', response.error, 'error').then(() => window.location.reload());
      },
      error: function(request, status, error) {
        alert(request.responseText);
      }
    });
  }

  $('.tambahItem').click(function(e) {
    e.preventDefault();
    // nambah jumlah
    this.parentNode.querySelector('input[type=number]').stepUp();

    const jumlah = $(this).parent(".kelolaJumlahItem").find(".jumlahItem").val();
    const id_keranjang = $(this).attr('id_keranjang');

    if (jumlah > 0) {
      ubahJumlah(id_keranjang, jumlah);
    } else {
      Swal.fire("Error", "Jumlah harus lebih dari 0!", "error").then(() => window.location.reload());
    }
  });

  $('.kurangiItem').click(function(e) {
    e.preventDefault();
    this.parentNode.querySelector('input[type=number]').stepDown();

    const jumlah = $(this).parent(".kelolaJumlahItem").find(".jumlahItem").val();
    const id_keranjang = $(this).attr('id_keranjang');

    if (jumlah > 0) {
      ubahJumlah(id_keranjang, jumlah);
    } else {
      Swal.fire("Error", "Jumlah harus lebih dari 0!", "error").then(() => window.location.reload());
    }
  });

  $(".jumlahItem").change(function(e) {
    e.preventDefault();

    const jumlah = $(this).val();
    const id_keranjang = $(this).attr('id_keranjang');

    if (jumlah > 0) {
      ubahJumlah(id_keranjang, jumlah);
    } else {
      Swal.fire("Error", "Jumlah harus lebih dari 0!", "error").then(() => window.location.reload());
    }
  });
</script>

<?= $this->endSection('main'); ?>