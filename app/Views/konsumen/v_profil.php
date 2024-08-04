<?= $this->extend('templates/template_konsumen'); ?>

<?= $this->section('main'); ?>

<div class="single-product mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mt-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-header" style="background-color: white; font-weight:bold;">User Profile</h5>
            <div class="row mt-2">
              <div class="col-lg-9 mb-3">

                <?php if (validation_errors()) { ?>
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="fa fa-ban"></i> Error!</h5>
                    <?= validation_list_errors(); ?>
                  </div>
                <?php } ?>

                <?= form_open(""); ?>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" id="email" class="form-control" value="<?= $user['email']; ?>">
                </div>
                <div class="form-group">
                  <label>Nama Lengkap</label>
                  <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="<?= $user['nama_lengkap']; ?>">
                </div>
                <div class="form-group row">
                  <div class="col-md-6">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Retype Password</label>
                    <input type="password" name="retype_password" id="retype_password" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label>No Telp</label>
                  <input type="text" name="telp" id="telp" class="form-control" value="<?= $user['telp']; ?>">
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <input type="hidden" name="id_alamat" value="<?= $user['id_alamat']; ?>">
                  <textarea type="text" name="alamat" id="alamat" class="form-control"><?= $user['alamat']; ?></textarea>
                </div>
                <div class="form-group">
                  <label>Provinsi</label>
                  <select name="provinsi" id="provinsi" class="form-control"></select>
                </div>
                <div class="form-group">
                  <label>Kota</label>
                  <select name="distrik" id="distrik" class="form-control"></select>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-lg btn-block btn-dark btnSimpan"><i class="fa fa-save"></i> Simpan perubahan</button>
                </div>
                <?= form_close(); ?>
              </div>
              <div class="col-lg-3">
                <?= form_open_multipart(base_url('profil/ubah_profil')); ?>
                <p class="font-weight-bold">Foto Profil</p>
                <div class="row row-img">
                  <label for="foto_profil" class="col-lg-12">
                    <img src="<?= base_url("images/" . $user['foto_profil']); ?>" style="width: 100%;" class="img-thumbnail mr-3 rounded img-preview">
                  </label>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <input type="file" class="form-control prevImg" id="foto_profil" name="foto_profil" style="display: none;">
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-block btn-lg btn-dark"><i class="fa fa-edit mr-1"></i> Ubah Profile</button>
                <?= form_close(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function awal() {
    $("#provinsi").attr('disabled', true);
    $("#distrik").attr('disabled', true);
  }

  function getProvinsi(id_provinsi, id_distrik) {
    $.ajax({
      url: "<?= base_url("RajaOngkir/getProvinsi"); ?>",
      dataType: "json",
      beforeSend: function() {
        $(".btnSimpan").attr('disabled', true);
      },
      success: function(response) {
        if (response.rajaongkir.results) {
          const provinsi = response.rajaongkir.results;
          let body = "<option value=''>-- Pilih --</option>";
          provinsi.forEach(prov => {
            body += `<option value="${prov.province_id}" ${id_provinsi == prov.province_id ? "selected" : ""}>${prov.province}</option>`;
          });
          $('#provinsi').html(body);
          $("#provinsi").removeAttr("disabled");

          // memanggil data distrik jika sudah memiliki id distrik  
          // if (id_distrik) {
          getKota(id_distrik);
          // } else {
          // }
        }
        $(".btnSimpan").removeAttr('disabled');
      },
      error: function(request, status, error) {
        $(".btnSimpan").removeAttr('disabled');
        alert(request.responseText);
      }
    });
  }

  function getKota(id_distrik = null) {
    $.ajax({
      type: "POST",
      url: "<?= base_url("RajaOngkir/getKota"); ?>",
      data: {
        id_provinsi: $('#provinsi').find(":checked").val(),
      },
      dataType: "json",
      success: function(response) {
        // console.log(response);
        if (response.rajaongkir.results) {
          const distrik = response.rajaongkir.results;
          let body = "<option value=''>-- Pilih --</option>";
          distrik.forEach(prov => {
            body += `<option value="${prov.city_id}" ${id_distrik == prov.city_id ? "selected" : ""}>${prov.type} ${prov.city_name}</option>`;
          });
          $('#distrik').html(body);

          $("#provinsi").removeAttr("disabled");
          $("#distrik").removeAttr("disabled");
        }
      },
      error: function(request, status, error) {
        alert(request.responseText);
      }
    });
  }

  $("#provinsi").change(function(e) {
    e.preventDefault();
    $("#distrik").attr('disabled', true);
    getKota();
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

  $(document).ready(function() {
    awal();
    getProvinsi("<?= $user['provinsi']; ?>", "<?= $user['distrik']; ?>");
  });
</script>

<?= $this->endSection('main'); ?>