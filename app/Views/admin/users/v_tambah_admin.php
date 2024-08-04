<?= $this->extend('templates/template_admin'); ?>

<?= $this->section('main'); ?>
<!-- InputMask -->
<script src="<?= base_url(); ?>/template_admin/plugins/moment/moment.min.js"></script>
<script src="<?= base_url(); ?>/template_admin/plugins/inputmask/jquery.inputmask.min.js"></script>

<div class="card card-primary card-outline">
  <div class="card-header">
    <h5 class="m-0 d-flex justify-content-between flex-wrap">
      <a href="<?= base_url('users/admin'); ?>" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
      <button type="button" class="btn btn-info refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
    </h5>
  </div>
  <div class="card-body">

    <?php if (validation_errors()) { ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> Error!</h5>
        <?= validation_list_errors(); ?>
      </div>
    <?php } ?>

    <?= form_open_multipart(""); ?>
    <input type="hidden" name="role" id="role" value="<?= $role; ?>" readonly>
    <div class="form-group">
      <label for="email">E-mail</label>
      <input type="text" name="email" id="email" class="form-control" value="<?= old('email'); ?>" autofocus>
    </div>
    <div class="form-group row">
      <div class="col-lg-6">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
      </div>
      <div class="col-lg-6">
        <label for="retype_password">Retype password</label>
        <input type="password" name="retype_password" id="retype_password" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <label for="nama_lengkap">Nama Lengkap</label>
      <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="<?= old('nama_lengkap'); ?>">
    </div>
    <div class="form-group">
      <label for="telp">No. Telp</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-phone"></i></span>
        </div>
        <input type="text" name="telp" id="telp" class="form-control" data-inputmask='"mask": "(62) 9999-9999-9999"' data-mask value="<?= old('telp'); ?>">
      </div>
    </div>
    <div class="form-group row row-img">
      <div class="col-lg-3">
        <img src="<?= base_url(); ?>/images/default.jpg" style="width: 100%;" class="img-thumbnail img-preview">
      </div>
      <div class="col-lg-9">
        <label for="">Foto profil</label>
        <input type="file" class="form-control prevImg" name="foto_profil">
      </div>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i> Simpan</button>
    </div>
    <?= form_close(); ?>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('[data-mask]').inputmask()
  });
</script>

<?= $this->endSection('main'); ?><?= base_url(); ?>