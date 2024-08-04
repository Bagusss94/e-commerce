<?= $this->extend('templates/template_admin'); ?>

<?= $this->section('main'); ?>


<div class="card card-primary card-outline">
  <div class="card-header">
    <h5 class="m-0 d-flex justify-content-between flex-wrap">
      <button type="button" class="btn btn-warning refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
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

    <h4 class="mb-3 font-weight-bold text-center">
      <?= ucfirst($user['role']); ?> Login
    </h4>

    <?= form_open_multipart(""); ?>
    <div class="form-group">
      <label for="email">E-mail</label>
      <input type="email" name="email" value="<?= old('email') ? old('email') : $user['email']; ?>" class="form-control" readonly>
    </div>
    <div class="form-group">
      <label for="nama_lengkap">Nama Lengkap</label>
      <input type="text" name="nama_lengkap" value="<?= old('nama_lengkap') ? old('nama_lengkap') : $user['nama_lengkap']; ?>" class="form-control">
    </div>
    <div class="form-group row">
      <div class="col-lg-6">
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control">
        </div>
      </div>
      <div class="col-lg-6">
        <div class="form-group">
          <label for="retype_password">Nama Lengkap</label>
          <input type="password" name="retype_password" class="form-control">
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="telp">Telp</label>
      <input type="numberp" name="telp" value="<?= old('telp') ? old('telp') : $user['telp']; ?>" class="form-control">
    </div>
    <div class="row form-group row-img">
      <div class="col-lg-4">
        <img src="<?= base_url("images/" . $user['foto_profil']); ?>" style="width: 100%;" class="img-thumbnail img-preview">
      </div>
      <div class="col-lg-8">
        <div class="form-group">
          <label for="foto_profil">Foto Profil</label>
          <input type="file" class="form-control prevImg" id="foto_profil" name="foto_profil">
        </div>
      </div>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i> Simpan perubahan</button>
    </div>

    <?= form_close(); ?>
  </div>
</div>

<?= $this->endSection('main'); ?><?= base_url(); ?>/template_admin/