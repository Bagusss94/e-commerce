<div class="modal fade" id="modaldetail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Detail Konsumen</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item"><b>E-mail: </b><?= $dataUser['email']; ?></li>
          <li class="list-group-item"><b>Nama Lengkap: </b><?= $dataUser['nama_lengkap']; ?></li>
          <li class="list-group-item"><b>No. Telp: </b>
            <a href="https://wa.me/<?= $dataUser['telp']; ?>" target="_blank"><?= $dataUser['telp']; ?></a>
          </li>
          <li class="list-group-item"><b>Alamat: </b><?= $dataUser['alamat']; ?></li>
          <li class="list-group-item"><b>Provinsi: </b><span id="provinsi"></span></li>
          <li class="list-group-item"><b>Kota: </b><span id="distrik"></span></li>
          <li class="list-group-item"><b>Foto Profil: </b> <br>
            <img src="<?= base_url('images/' . $dataUser['foto_profil']); ?>" style="width: 200px;">
          </li>
        </ul>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="hideModal();">Tutup</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script>
  $(document).ready(function() {
    var id_provinsi = "<?= $dataUser['provinsi']; ?>";
    var id_alamat = "<?= $dataUser['alamat']; ?>";

    if (id_provinsi) {
      $.ajax({
        url: "<?= base_url('RajaOngkir/getProvinsi/'); ?>" + id_provinsi,
        dataType: "json",
        beforeSend: function() {
          $("#provinsi").html(`<i class="fa fa-spin fa-spinner"></i>`);
          $("#distrik").html(`<i class="fa fa-spin fa-spinner"></i>`);
        },
        success: function(response) {
          if (response.rajaongkir.results) {
            const provinsi = response.rajaongkir.results;
            $("#provinsi").html(provinsi.province);

            if (id_alamat) {
              $.ajax({
                type: "post",
                url: "<?= base_url('RajaOngkir/getKota/'); ?>" + id_alamat,
                data: {
                  id_provinsi
                },
                dataType: "json",
                beforeSend: function() {
                  $("#distrik").html(`<i class="fa fa-spin fa-spinner"></i>`);
                },
                success: function(response) {
                  if (response.rajaongkir.query) {
                    $("#distrik").html(response.rajaongkir.query.id);
                  }
                },
                error: function(xhr, status, error) {
                  var err = eval("(" + xhr.responseText + ")");
                  alert(err.Message);
                }
              });
            }
          }
        },
        error: function(xhr, status, error) {
          var err = eval("(" + xhr.responseText + ")");
          alert(err.Message);
        }
      });
    }
  });
</script>