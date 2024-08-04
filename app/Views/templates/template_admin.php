<?php

$uri = service('uri');
$url1 = $uri->getSegment(1);

try {
  $url2 = !empty($uri->getSegment(2)) ? $uri->getSegment(2) : null;
} catch (\Throwable $th) {
  $url2 = null;
}

$db = db_connect();
$setting = $db->table('setting')->limit(1)->orderBy('id_setting', 'ASC')->get()->getRowArray();
$user = $db->table('users')->where('id_user', session('LoginUser')['id_user'])->get()->getRowArray();
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= ucfirst(session('LoginUser')['role']); ?> | <?= $title; ?></title>

  <link rel="icon" href="<?= base_url("images/" . $setting['logo_web']); ?>" type="image/gif" sizes="16x16">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template_admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template_admin/dist/css/adminlte.min.css">
  <!-- jQuery -->
  <script src="<?= base_url(); ?>/template_admin/plugins/jquery/jquery.min.js"></script>
  <!-- Sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <button type="button" class="btn btn-danger keluar"><i class="fa fa-sign-out-alt"></i> Logout</button>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="" class="brand-link">
        <img src="<?= base_url("images/" . $setting['logo_web']); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= $setting['nama_web']; ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?= base_url("images/" . $user['foto_profil']); ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= $user['nama_lengkap']; ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            <li class="nav-item">
              <a href="<?= base_url('dashboard'); ?>" class="nav-link <?= $url1 === "dashboard" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>

            <li class="nav-item <?= $url1 === 'users' ? ' menu-open' : ''; ?>">
              <a href="#" class="nav-link <?= $url1 === 'users' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Data Users
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('users/admin'); ?>" class="nav-link <?= $url2 === 'admin' || $url2 === 'tambah_admin' || $url2 === 'edit_admin'  ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Admin</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url('users/konsumen'); ?>" class="nav-link <?= $url2 === 'konsumen' ? 'active' : ''; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Konsumen</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item <?= $url1 === 'satuan' || $url1 === 'kategori' ? ' menu-open' : ''; ?>">
              <a href="#" class="nav-link <?= $url1 === 'satuan' || $url1 === 'kategori' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  Data Kategori
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url('satuan'); ?>" class="nav-link <?= $url1 === "satuan" ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                      Kategori Satuan
                    </p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="<?= base_url('kategori'); ?>" class="nav-link <?= $url1 === "kategori" ? "active" : ""; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                      Kategori Barang
                    </p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item">
              <a href="<?= base_url('produk'); ?>" class="nav-link <?= $url1 === "produk" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-plug"></i>
                <p>
                  Daftar Produk
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('transaksi'); ?>" class="nav-link <?= $url1 === "transaksi" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-money-bill"></i>
                <p>
                  Lihat Transaksi
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('setting'); ?>" class="nav-link <?= $url1 === "setting" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                  Setting Web
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= base_url('faqs/index'); ?>" class="nav-link <?= $url1 === "faqs" ? "active" : ""; ?>">
                <i class="nav-icon fas fa-question"></i>
                <p>
                  Faqs
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="" class="nav-link keluar">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  Logout
                </p>
              </a>
            </li>

            <!-- <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Starter Pages
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Active Page</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Inactive Page</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Simple Link
                  <span class="right badge badge-danger">New</span>
                </p>
              </a>
            </li> -->
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?= $subtitle ? $subtitle : $title; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href=""><?= $title; ?></a></li>
                <?php
                if ($subtitle) { ?>
                  <li class="breadcrumb-item active"><?= $subtitle; ?></li>
                <?php } ?>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-md-12">
              <?= $this->renderSection('main'); ?>
            </div>

          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
      </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <!-- <div class="float-right d-none d-sm-inline">
        Anything you want
      </div> -->
      <!-- Default to the left -->
      <strong>Copyright &copy; <?= date('Y'); ?> <a href=""><?= $setting['nama_web']; ?></a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- Bootstrap 4 -->
  <script src=" <?= base_url(); ?>/template_admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url(); ?>/template_admin/dist/js/adminlte.min.js"></script>

  <script>
    $('.modal').on('hidden.bs.modal', function(e) {
      hideModal();
    });

    function hideModal() {
      $(".modal-backdrop").remove();
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

    $('.refresh').click(function(e) {
      e.preventDefault();
      window.location = "<?= base_url(uri_string()); ?>";
    });

    $('.prevImg').change(function(e) {
      e.preventDefault();
      const foto = this;
      const imgPreview = this.parentElement.parentElement.closest('.row-img').querySelector('.img-preview');

      const fileFoto = new FileReader();
      fileFoto.readAsDataURL(foto.files[0]);
      fileFoto.onload = function(e) {
        imgPreview.src = e.target.result;
      }
    });

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

    // hapus alert sementara
    window.setTimeout(function() {
      $('.temp-alert').fadeTo(500.0).slideUp(500,
        function() {
          $(this).remove();
        })
    }, 3000);
  </script>
</body>

</html>