<?= $this->extend('templates/template_konsumen'); ?>

<?= $this->section('main'); ?>

<!-- Main Content -->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card border-0">
        <div class="card-body">
          <h2 class="card-header text-center" style="background-color: white; font-weight:bold;">Faqs</h2>
          <div id="accordion">
            <?php foreach ($faqs as $index => $faq) : ?>
              <div class="card">
                <div class="card-header" id="heading<?= $index ?>">
                  <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
                      <?= $faq['question'] ?>
                    </button>
                  </h5>
                </div>
                <div id="collapse<?= $index ?>" class="collapse" aria-labelledby="heading<?= $index ?>" data-parent="#accordion">
                  <div class="card-body">
                    <?= $faq['answer'] ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function() {
    $('#accordion .collapse').on('show.bs.collapse', function() {
      $('#accordion .collapse.show').collapse('hide');
    });
  });
</script>

<?= $this->endSection(); ?>