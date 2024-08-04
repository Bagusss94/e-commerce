<?php

$db = db_connect();
$setting = $db->table('setting')->limit(1)->orderBy('id_setting', 'ASC')->get()->getRowArray();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $setting['nama_web']; ?> | <?= $title; ?></title>

  <link rel="icon" href="<?= base_url("images/" . $setting['logo_web']); ?>" type="image/gif" sizes="16x16">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template_admin/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template_admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>/template_admin/dist/css/adminlte.min.css">
  <!-- Sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href=""><b><?= $title; ?></b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body register-card-body">

        <?php if (validation_errors()) { ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            <?= validation_list_errors(); ?>
          </div>
        <?php } ?>

        <form action="" method="post">
          <?= csrf_field(); ?>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password baru" autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="retype_password" placeholder="Retype password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Ubah password</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="<?= base_url('auth/login'); ?>">Login</a>
        </p>
        <p class="mb-0">
          <a href="<?= base_url('auth/register'); ?>" class="text-center">Registrasi</a>
        </p>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?= base_url(); ?>/template_admin/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url(); ?>/template_admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url(); ?>/template_admin/dist/js/adminlte.min.js"></script>


  <script src="<?= base_url(); ?>/template_admin/plugins/moment/moment.min.js"></script>
  <script src="<?= base_url(); ?>/template_admin/plugins/inputmask/jquery.inputmask.min.js"></script>


  <script>
    $(document).ready(function() {
      $('[data-mask]').inputmask()

      var msg = "<?= session()->getFlashdata('msg'); ?>";
      if (msg) {
        let pesan = msg.split("#");
        Swal.fire({
          position: 'top-end',
          toast: true,
          icon: pesan[0],
          title: pesan[1],
          showConfirmButton: false,
          timer: 4000
        });
      }
    });
  </script>
</body>

</html>