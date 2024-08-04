<?= $this->extend('templates/template_konsumen'); ?>

<?= $this->section('main'); ?>

<div class="single-product mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <h5 class="card-header font-weight-bold">
            Pilih Pengiriman
          </h5>
          <div class="card-body">
            <div class="form-group">
              <label for="">No. Telp</label>
              <span style="display: block; font-size: 14px; margin-top: -10px; margin-bottom: 10px;" class="text-danger">(Masukkan No.Telp yang dapat dihubungi)</span>
              <input type="number" name="notelp" id="notelp" class="form-control" value="<?= $user['telp']; ?>" required autofocus>
            </div>
            <div class="form-group">
              <label for="">Alamat Pengiriman</label>
              <span style="display: block; font-size: 14px; margin-top: -10px; margin-bottom: 10px;" class="text-danger">(Masukkan alamat lengkap beserta nama jalan)</span>
              <textarea name="alamatpengiriman" id="alamatpengiriman" class="form-control" required><?= $user['alamat']; ?></textarea>
            </div>
            <div class="form-group">
              <label for="">Provinsi</label>
              <select name="provinsi" id="provinsi" class="form-control"></select>
            </div>
            <div class="form-group">
              <label for="">Kabupaten</label>
              <select name="distrik" id="distrik" class="form-control"></select>
            </div>
            <div class="form-group">
              <label for="">Ekspedisi</label>
              <select name="ekspedisi" id="ekspedisi" class="form-control"></select>
            </div>
            <div class="form-group">
              <label for="">Paket</label>
              <select name="paket" id="paket" class="form-control"></select>
            </div>
            <div class="form-group">
              <input type="hidden" name="total" id="total" value="<?= $total; ?>">
              <button type="submit" name="checkout" id="checkout" class="btn btn-lg btn-block btn-success btnCheckOut"><i class="fa fa-check-circle"></i> Checkout (<b id="totalcheckout">0</b>)</button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div class="card">
          <h5 class="card-header font-weight-bold">Detail Pengiriman</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Total Berat(Gram)</label>
                  <input type="text" name="totalberat" id="totalberat" class="form-control" value="<?= $totalBerat; ?>" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Provinsi</label>
                  <input type="text" name="provinsiterpilih" id="provinsiterpilih" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Distrik</label>
                  <input type="text" name="distrikterpilih" id="distrikterpilih" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Tipe(Kota/Kabupaten)</label>
                  <input type="text" name="tipeterpilih" id="tipeterpilih" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Kode POS</label>
                  <input type="text" name="kodeposterpilih" id="kodeposterpilih" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Ekspedisi</label>
                  <input type="text" name="ekspedisiterpilih" id="ekspedisiterpilih" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Paket</label>
                  <input type="text" name="paketterpilih" id="paketterpilih" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Ongkir (Rp)</label>
                  <input type="text" name="ongkir" id="ongkir" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Estimasi (Hari)</label>
                  <input type="text" name="estimasi" id="estimasi" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">Total Bayar (Rp)</label>
                  <input type="text" name="totalbayar" id="totalbayar" class="form-control" value="0" readonly>
                </div>
              </div>
            </div>
          </div>
        </div><br>
        <div class="card">
          <h5 class="card-header font-weight-bold">Keranjang - <?= $jmlItem; ?> item</h5>
          <div class="card-body">
            <div class="col-12 table-responsive datakeranjang">
              <?php
              foreach ($keranjang as $key => $value) :
                $gambarProduk = !empty($value['gambar']) ?  base_url("images/" . $value['gambar']) : base_url("images/default.jpg");
              ?>
                <div class="row">
                  <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                    <!-- Image -->
                    <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                      <img src="<?= $gambarProduk; ?>" class="w-100" alt="<?= $value['nama_produk']; ?>" />
                      <a href="#!">
                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                      </a>
                    </div>
                    <!-- Image -->
                  </div>
                  <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                    <!-- Data -->
                    <p><strong><?= $value['nama_produk']; ?></strong></p>
                    <ul>
                      <li>Berat(gr): <?= number_format($value['berat'], 0, ",", "."); ?></li>
                      <li>Harga(Rp): <?= number_format($value['harga_produk'], 0, ",", "."); ?></li>
                      <li>Jumlah: <?= number_format($value['jumlah'], 0, ",", "."); ?></li>
                    </ul>
                    <!-- Data -->
                  </div>
                  <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <p><strong>Subtotal</strong></p>
                    <p>Rp. <?= number_format($value['subtotal'], 0, ",", "."); ?></p>
                  </div>
                </div>
              <?php
              endforeach; ?>

              <hr>

              <div class="row">
                <div class="col-lg-8 col-md-12 mb-4 mb-lg-0">
                  <h4><strong>Total:</strong></h4>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                  <h4 class="font-weight-bold">Rp. <?= number_format($total, 0, ",", "."); ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= getenv('MIDTRANS_SERVER_KEY'); ?>"></script>
<!-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-server-gys4ERLQDCMLVbXBD_lFg44i"></script> -->
<script type="text/javascript">
  function start() {
    $('#provinsi').attr('disabled', true);
    $('#distrik').attr('disabled', true);
    $('#ekspedisi').attr('disabled', true);
    $('#paket').attr('disabled', true);
    $('#checkout').attr('disabled', true);
    $('#totalcheckout').html(formatRupiah(parseInt(<?= $total; ?>)));
  }

  function getProvinsi(id_provinsi_sistem = null, id_distrik_sistem = null) {
    $.ajax({
      url: "<?= base_url('RajaOngkir/getProvinsi'); ?>",
      dataType: "json",
      success: function(response) {
        if (response.rajaongkir.results) {
          const provinsi = response.rajaongkir.results;
          // console.log(provinsi);
          let body = `<option value="">-- Pilih --</option>`;
          provinsi.forEach(prov => {
            body += `<option value="${prov.province_id}" provinsi="${prov.province}" ${prov.province_id === id_provinsi_sistem ? 'selected':''}>${prov.province}</option>`;
          });
          $('#provinsi').html(body);
          $('#provinsi').removeAttr('disabled');

          if (id_distrik_sistem) {
            getDistrik(id_distrik_sistem);
          }
        }
      },
      error: function(request, status, error) {
        alert(request.responseText);
      }
    });
  }

  function getDistrik(id_distrik_sistem = null) {
    $('#distrik').attr('disabled', true);
    $('#ekspedisi').attr('disabled', true);
    $('#paket').attr('disabled', true);

    $.ajax({
      type: "post",
      url: "<?= base_url('RajaOngkir/getKota'); ?>",
      data: {
        id_provinsi: $("#provinsi").find(":checked").val(),
      },
      beforeSend: function() {
        $('#distrik').html("");
      },
      dataType: "json",
      success: function(response) {
        if (response.rajaongkir.results) {
          const distrik = response.rajaongkir.results;
          let body = `<option value="">-- Pilih --</option>`;
          distrik.forEach(prov => {
            body += `<option value="${prov.city_id}" id_provinsi="${prov.province_id}" distrik="${prov.city_name}" tipe="${prov.type}" ${prov.city_id === id_distrik_sistem ? 'selected':''}>${prov.type} ${prov.city_name}</option>`;
          });
          $('#distrik').html(body);

          $("#provinsiterpilih").val($('#provinsi').find(':selected').attr('provinsi'));

          $('#provinsi').removeAttr('disabled');
          $('#distrik').removeAttr('disabled');

          // $('#ekspedisi').attr('disabled', true);
          // $('#paket').attr('disabled', true);

          $.ajax({
            url: "<?= base_url("RajaOngkir/getEkspedisi"); ?>",
            dataType: "json",
            success: function(response) {
              if (response.ekspedisi) {
                const ekspedisi = response.ekspedisi;
                let body = `<option value="">-- Pilih --</option>`;
                ekspedisi.forEach(prov => {
                  body += `<option value="${prov}">${prov.toUpperCase()}</option>`;
                });
                $('#ekspedisi').html(body);

                $("#distrikterpilih").val($('#distrik').find(':selected').attr('distrik'));
                $("#tipeterpilih").val($('#distrik').find(':selected').attr('tipe'));

                $('#provinsi').removeAttr('disabled');
                $('#distrik').removeAttr('disabled');
                $('#ekspedisi').removeAttr('disabled');
              }
            },
            error: function(xhr, status, error) {
              var err = eval("(" + xhr.responseText + ")");
              alert(err.Message);
            }
          });
        }
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });


  }

  $('#provinsi').change(function(e) {
    e.preventDefault();
    getDistrik();
  });

  $('#distrik').change(function(e) {
    e.preventDefault();

    // mendisable input ekspedisi dan paket
    $('#ekspedisi').attr('disabled', true);
    $('#paket').attr('disabled', true);

    $.ajax({
      url: "<?= base_url("RajaOngkir/getEkspedisi"); ?>",
      dataType: "json",
      success: function(response) {
        if (response.ekspedisi) {
          const ekspedisi = response.ekspedisi;

          let body = `<option value="">-- Pilih --</option>`;
          ekspedisi.forEach(prov => {
            body += `<option value="${prov}">${prov.toUpperCase()}</option>`;
          });
          $('#ekspedisi').html(body);

          $("#distrikterpilih").val($('#distrik').find(':selected').attr('distrik'));
          $("#tipeterpilih").val($('#distrik').find(':selected').attr('tipe'));

          $('#provinsi').removeAttr('disabled');
          $('#distrik').removeAttr('disabled');
          $('#ekspedisi').removeAttr('disabled');
        }
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });
  });

  $('#ekspedisi').change(function(e) {
    e.preventDefault();

    $('#paket').attr('disabled', true);

    $.ajax({
      type: "post",
      url: "<?= base_url("RajaOngkir/getBiayaOngkir"); ?>",
      data: {
        id_distrik: $('#distrik').val(),
        berat: $('#totalberat').val(),
        kurir: $(this).val(),
      },
      dataType: "json",
      success: function(response) {
        // console.log(response);
        if (response.rajaongkir.destination_details && response.rajaongkir.results[0].costs) {
          const destinasi = response.rajaongkir.destination_details;
          const paket = response.rajaongkir.results[0].costs;

          // console.log(paket);

          let body = `<option value="">-- Pilih --</option>`;
          paket.forEach(element => {
            body += `<option value="${element.cost[0].value}" etd="${element.cost[0].etd}" service="${element.service}">${element.service} - Rp. ${element.cost[0].value} (Estimasi: ${element.cost[0].etd})</option>`;
          });
          $('#paket').removeAttr('disabled');
          $("#paket").html(body);

          $("#kodeposterpilih").val(destinasi.postal_code);
          $("#ekspedisiterpilih").val($('#ekspedisi').find(':selected').val());

        }
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });
  });

  $("#paket").change(function(e) {
    e.preventDefault();
    // console.log($('#paket').find(":selected").attr('service'));
    // console.log($('#paket').find(":selected").attr('etd'));
    $("#paketterpilih").val($('#paket').find(":selected").attr('service'));
    $("#ongkir").val($(this).val());
    $("#estimasi").val($('#paket').find(":selected").attr('etd'));

    // hitung total bayar
    const total = parseInt($('#total').val());
    const ongkir = parseInt($(this).val());
    $('#totalbayar').val(parseInt(total + ongkir));

    $("#totalcheckout").html(formatRupiah(parseInt(total + ongkir)));
    $('#checkout').removeAttr("disabled");
  });

  $('#checkout').click(function(e) {
    const detail_transaksi = <?= json_encode($keranjang); ?>;
    const alamat = $("#alamatpengiriman").val();
    const distrik = $('#distrikterpilih').val();
    const provinsi = $("#provinsiterpilih").val();
    const telp = $("#notelp").val();
    const kodepos = $("#kodeposterpilih").val();
    const ekspedisi = $('#ekspedisiterpilih').val();
    const paket = $('#paketterpilih').val();
    const total_berat = $("#totalberat").val();
    const ongkir = $('#ongkir').val();
    const estimasi = $("#estimasi").val();
    const total_bayar = $("#totalbayar").val();

    if (
      !alamat ||
      !distrik ||
      !provinsi ||
      !telp ||
      !kodepos ||
      !ongkir ||
      !total_berat ||
      !total_bayar
    ) {
      Swal.fire('Error', 'Semua form harus terisi!', 'error');
      return false;
    }

    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "<?= base_url('transaksiuser/payment'); ?>",
      data: {
        alamat,
        distrik,
        provinsi,
        telp,
        kodepos,
        detail_transaksi,
        ongkir,
        total_berat,
        total_bayar,
      },
      dataType: "json",
      success: function(response) {
        console.log(response);
        if (response.snapToken) {
          var snapToken = response.snapToken;
          snap.pay(response.snapToken, {
            // Optional
            onSuccess: function(result) {
              console.log(result);
              const status_pembayaran = result.transaction_status;
              const id_transaksi = result.order_id;
              const tanggal = result.transaction_time;
              const tipe_pembayaran = result.payment_type;
              const link_pdf = result.pdf_url;
              $.ajax({
                type: "post",
                url: "<?= base_url('transaksiuser/simpanTransaksi'); ?>",
                data: {
                  alamat,
                  distrik,
                  provinsi,
                  telp,
                  kodepos,
                  detail_transaksi,

                  total_bayar,
                  ekspedisi,
                  paket,
                  total_berat,
                  ongkir,
                  estimasi,
                  status_pembayaran,
                  id_transaksi,
                  tanggal,
                  tipe_pembayaran,
                  link_pdf,
                  snapToken,
                },
                dataType: "json",
                success: function(response) {
                  if (response.success) {
                    Swal.fire('Sukses', response.success, 'success').then(() => {
                      window.location = "<?= base_url('history/'); ?>" + id_transaksi;
                    });
                  }
                  console.log(response);
                  if (response.error) {
                    Swal.fire('Error', response.error, 'error').then(() => window.location.reload());
                  }
                },
                error: function(xhr, status, error) {
                  var err = eval("(" + xhr.responseText + ")");
                  alert(err.Message);
                }
              });
            },
            // Optional
            onPending: function(result) {
              console.log(result);
              const status_pembayaran = result.transaction_status;
              const id_transaksi = result.order_id;
              const tanggal = result.transaction_time;
              const tipe_pembayaran = result.payment_type;
              const link_pdf = result.pdf_url;
              $.ajax({
                type: "post",
                url: "<?= base_url('transaksiuser/simpanTransaksi'); ?>",
                data: {
                  alamat,
                  distrik,
                  provinsi,
                  telp,
                  kodepos,
                  detail_transaksi,

                  total_bayar,
                  ekspedisi,
                  paket,
                  total_berat,
                  ongkir,
                  estimasi,
                  status_pembayaran,
                  id_transaksi,
                  tanggal,
                  tipe_pembayaran,
                  link_pdf,
                  snapToken,
                },
                dataType: "json",
                success: function(response) {
                  if (response.success) {
                    Swal.fire('Sukses', response.success, 'success').then(() => {
                      window.location = "<?= base_url('history/'); ?>" + id_transaksi;
                    });
                  }
                  console.log(response);
                  if (response.error) {
                    Swal.fire('Error', response.error, 'error').then(() => window.location.reload());
                  }
                },
                error: function(xhr, status, error) {
                  var err = eval("(" + xhr.responseText + ")");
                  alert(err.Message);
                }
              });
            },
            // Optional
            onError: function(result) {
              console.log(result);
              const status_pembayaran = result.transaction_status;
              const id_transaksi = result.order_id;
              const tanggal = result.transaction_time;
              const tipe_pembayaran = result.payment_type;
              const link_pdf = result.pdf_url;
              $.ajax({
                type: "post",
                url: "<?= base_url('transaksiuser/simpanTransaksi'); ?>",
                data: {
                  alamat,
                  distrik,
                  provinsi,
                  telp,
                  kodepos,
                  detail_transaksi,

                  total_bayar,
                  ekspedisi,
                  paket,
                  total_berat,
                  ongkir,
                  estimasi,
                  status_pembayaran,
                  id_transaksi,
                  tanggal,
                  tipe_pembayaran,
                  link_pdf,
                  snapToken,
                },
                dataType: "json",
                success: function(response) {
                  if (response.success) {
                    Swal.fire('Sukses', response.success, 'success').then(() => {
                      window.location = "<?= base_url('history/'); ?>" + id_transaksi;
                    });
                  }
                  console.log(response);
                  if (response.error) {
                    Swal.fire('Error', response.error, 'error').then(() => window.location.reload());
                  }
                },
                error: function(xhr, status, error) {
                  var err = eval("(" + xhr.responseText + ")");
                  alert(err.Message);
                }
              });
            },
            onClose: function() {
              window.location.href = "<?= base_url('checkout'); ?>";
            }
          });
        }

        // jika response error
        if (response.error) {
          Swal.fire('Error', response.error, 'error').then(() => window.location.reload());
        }
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
      }
    });
  });

  $(document).ready(function() {
    start();
    getProvinsi("<?= $user['provinsi']; ?>", "<?= $user['distrik']; ?>");
  });
</script>

<?= $this->endSection('main'); ?>