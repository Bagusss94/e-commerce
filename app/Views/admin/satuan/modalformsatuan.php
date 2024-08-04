<div class="modal fade" id="modalFormSatuan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?= $title; ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" id="formSimpan">
        <div class="modal-body">
          <?= csrf_field(); ?>
          <input type="hidden" name="id_satuan" id="id_satuan" value="<?= $id_satuan; ?>">
          <div class="form-group">
            <label for="satuan">Satuan</label>
            <input type="text" name="satuan" value="<?= $satuan; ?>" id="satuan" class="form-control">
            <div class="invalid-feedback error_satuan"></div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="hideModal();">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script>
  $("#formSimpan").submit(function(e) {
    e.preventDefault();
    let url = `<?= base_url('satuan/simpan'); ?>`;
    if ($("#id_satuan").val()) {
      url = `<?= base_url('satuan/ubah'); ?>`;
    }
    $.ajax({
      url: url,
      method: 'POST',
      data: $(this).serialize(),
      dataType: "json",
      beforeSend: function() {
        $("button[type=submit]").html(`<i class="fa fa-spin fa-spinner"></i>`);
      },
      success: function(response) {
        $("button[type=submit]").html(`Simpan`);
        if (response.success) {
          Swal.fire({
            title: "Sukses!",
            text: response.success,
            icon: "success"
          }).then(() => window.location.reload());
        }
        if (response.error) Swal.fire('Error', response.error, 'error');
        if (response.errors) {
          if (response.errors.satuan) {
            $('#satuan').addClass('is-invalid');
            $('.error_satuan').html(response.errors.satuan);
          } else {
            $('#satuan').removeClass('is-invalid');
            $('.error_satuan').html('');
          }
        }
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });
  });
</script>