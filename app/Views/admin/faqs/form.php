<?= $this->extend('templates/template_admin'); ?>

<?= $this->section('main'); ?>

<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title"><?= isset($faq) ? 'Edit' : 'Tambah'; ?> FAQ</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <form action="<?= isset($faq) ? base_url('faqs/save/' . $faq['id']) : base_url('faqs/save'); ?>" method="post">
    <div class="card-body">
      <div class="form-group">
        <label for="question">Question</label>
        <textarea class="form-control" name="question" id="question" rows="3" placeholder="Enter question"><?= isset($faq) ? $faq['question'] : ''; ?></textarea>
      </div>
      <div class="form-group">
        <label for="answer">Answer</label>
        <textarea class="form-control" name="answer" id="answer" rows="3" placeholder="Enter answer"><?= isset($faq) ? $faq['answer'] : ''; ?></textarea>
      </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="btn btn-primary"><?= isset($faq) ? 'Update' : 'Save'; ?></button>
    </div>
  </form>
</div>
<!-- /.card -->

<?= $this->endSection(); ?>