<?php

$uri = \Config\Services::uri();
$url = $uri->getSegment(1);

$db = db_connect();
$setting = $db->table('setting')->limit(1)->orderBy('id_setting', 'ASC')->get()->getRowArray();

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <?php
  if (isset($_GET['eraseCache'])) {
    echo '<meta http-equiv="Cache-control" content="no-cache">';
    echo '<meta http-equiv="Expires" content="-1">';
    $cache = '?' . time();
  }
  ?> <!-- Fav Icon -->
  <link rel="icon" href="<?= base_url("images/" . $setting['logo_web']); ?>" type="image/gif" sizes="16x16">
  <!-- Google fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <!-- Main css -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template_konsumen/style.css">
  <!-- FONTAWESOME STYLES-->
  <link href="<?= base_url(); ?>/template_konsumen/assets/css/font-awesome.css" rel="stylesheet" />

  <!-- Sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- jQuery -->
  <script src="<?= base_url(); ?>/template_admin/plugins/jquery/jquery.min.js"></script>

  <title><?= $setting['nama_web']; ?> | <?= $title; ?></title>
</head>

<body>
  <main class="container">
    <!-- Header start  -->
    <header>
      <nav class="navbar navbar-expand-lg navbar-light fill">
        <a class="navbar-brand d-flex align-items-center" href="">
          <img src="<?= base_url("images/" . $setting['logo_web']); ?>" width="75" height="75" style="border-radius: 999px;">
          <div class="d-flex flex-column justify-content-center" style="margin-left: 10px;">
            <h3 style="font-weight: bold;"><?= $setting['nama_web']; ?></h3>
            <span style="font-size: 0.9em;">Sistem Penjualan Alat Tulis Lengkap</span>
          </div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item <?= $url === "" ? "active" : ""; ?>">
              <a class="nav-link" href="<?= base_url("/"); ?>">Beranda</a>
            </li>
            <li class="nav-item <?= $url === "daftar-produk" ? "active" : ""; ?>">
              <a class="nav-link" href="<?= base_url("daftar-produk"); ?>">Produk</a>
            </li>
            <li class="nav-item <?= $url === "about-us" ? "active" : ""; ?>">
              <a class="nav-link" href="<?= base_url("about-us"); ?>">Tentang Kami</a>
            </li>
            <li class="nav-item <?= $url === "faqs" ? "active" : ""; ?>">
              <a class="nav-link" href="<?= base_url("faqs"); ?>">FAQs</a>
            </li>

            <?php if (empty(session('LoginUser'))) : ?>
              <li class="nav-item">
                <a class="nav-link" href="<?= base_url("auth/login"); ?>"><i class="fa fa-sign-in"></i> Login</a>
              </li>
            <?php endif; ?>

            <?php if (!empty(session('LoginUser')) && session('LoginUser')['role'] === "konsumen") : ?>

              <li class="dropdown nav-item">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-user"></i> <?= session('LoginUser')['nama_lengkap']; ?>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="nav-link dropdown-item" href="<?= base_url('profil'); ?>"><i class="fa fa-user"></i> Profil
                  </a>
                  <a class="nav-link dropdown-item" href="<?= base_url('keranjang'); ?>"><i class="fa fa-shopping-cart"></i> Keranjang
                  </a>
                  <a class="nav-link dropdown-item" href="<?= base_url('history'); ?>"><i class="fa fa-money"></i> Riwayat Transaksi
                  </a>
                  <a class="nav-link dropdown-item keluar" href=""><i class="fa fa-sign-out"></i> Logout
                  </a>
                </div>
              </li>

              <!-- <li class="nav-item  <?= $url === "keranjang" ? "active" : ""; ?>">
                <a class="nav-link" href="<?= base_url('keranjang'); ?>"><i class="fa fa-shopping-cart"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link keluar" href=""><i class="fa fa-sign-out"></i> Logout</a>
              </li> -->
            <?php elseif (!empty(session('LoginUser')) && (session('LoginUser')['role'] === "admin" || session('LoginUser')['role'] === "owner")) : ?>
              <li class="nav-item">
                <a class="nav-link" href="<?= base_url("dashboard"); ?>"><i class="fa fa-user"></i> <?= session('LoginUser')['nama_lengkap']; ?></a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Header end  -->

    <!-- Mack book pro start -->

    <?= $this->renderSection('carousel'); ?>

    <?= $this->renderSection('main'); ?>

    <!-- Laptop start  -->

    <!-- Footer start  -->
    <footer>
      <div class="text-center">
        <strong><?= $setting['nama_web']; ?></strong> &copy; All Right reserved
      </div>
    </footer>
    <!-- End  -->
  </main>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

  <script>
    function hideModal() {
      $(".modal-backdrop").remove();
    }

    function formatRupiah(number) {
      return number.toLocaleString('id-ID', {
        style: 'currency',
        currency: 'IDR'
      });
    }

    var msg = "<?= session()->getFlashdata('msg'); ?>";
    if (msg) {
      let pesan = msg.split("#");
      Swal.fire({
        position: 'top-end',
        toast: true,
        icon: pesan[0],
        title: pesan[1],
        showConfirmButton: false,
        timer: 5000
      });
    }

    $('.keluar').click(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Logout',
        text: "Apakah anda yakin keluar dari halaman ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, keluar!',
        cancelButtonText: 'batal',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location = "<?= base_url('auth/logout'); ?>";
        }
      })
    });
  </script>
</body>

</html>