<?= $this->extend('templates/template_admin'); ?>

<?= $this->section('main'); ?>

<!-- summernote -->
<link rel="stylesheet" href="<?= base_url(); ?>/template_admin/plugins/summernote/summernote-bs4.min.css">
<script src="<?= base_url(); ?>/template_admin/plugins/summernote/summernote-bs4.min.js"></script>

<div class="card card-primary card-outline">
  <div class="card-header">
    <h5 class="m-0 d-flex justify-content-between flex-wrap">
      <a href="<?= base_url('produk'); ?>" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
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

    <?= form_open(""); ?>
    <div class="form-group">
      <label for="nama_produk">Nama Produk</label>
      <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="<?= old('nama_produk'); ?>" autofocus>
    </div>
    <div class=" form-group">
      <label for="harga_produk">Harga Produk (Rp)</label>
      <input type="number" name="harga_produk" id="harga_produk" class="form-control" value="<?= old('harga_produk'); ?>">
    </div>
    <div class="form-group">
      <label for="stok">Stok Produk</label>
      <input type="number" name="stok" id="stok" class="form-control" value="<?= old('stok'); ?>">
    </div>
    <div class=" form-group">
      <label for="satuan">Satuan</label>
      <select name="id_satuan" id="id_satuan" class="form-control">
        <option value="">-- pilih --</option>
        <?php foreach ($satuan as $s) : ?>
          <option value="<?= $s['id_satuan'] ?>" <?= old('id_satuan') == $s['id_satuan'] ? 'selected' : ''; ?>><?= $s['satuan'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class=" form-group">
      <label for="kategori">Kategori Produk</label>
      <select name="id_kategori" id="id_kategori" class="form-control">
        <option value="">-- pilih --</option>
        <?php foreach ($kategori as $s) : ?>
          <option value="<?= $s['id_kategori'] ?>" <?= old('id_kategori') == $s['id_kategori'] ? 'selected' : ''; ?>><?= $s['kategori'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class=" form-group">
      <label for="berat">Berat Produk (gram)</label>
      <input type="number" name="berat" id="berat" class="form-control" value="<?= old('berat'); ?>">
    </div>
    <div class=" form-group">
      <label for="deskripsi_produk">Deskripsi Produk</label>
      <textarea name="deskripsi_produk" class="form-control summernote" id="deskripsi_produk"><?= old('deskripsi_produk'); ?></textarea>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i> Simpan</button>
    </div>
    <?= form_close(); ?>
  </div>
</div>

<script>
  $(function() {
    // Summernote
    $('.summernote').summernote({
      height: 250,
    })
  });
</script>

<?= $this->endSection('main'); ?><?= base_url(); ?>/template_admin/