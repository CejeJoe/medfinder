<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
  <h1 class="mb-4">Upload Drug Image</h1>
  <form id="uploadForm" enctype="multipart/form-data">
      <div class="mb-3">
          <label for="drug_id" class="form-label">Select Drug</label>
          <select class="form-select" id="drug_id" name="drug_id" required>
              <?php foreach ($drugs as $drug): ?>
                  <option value="<?= $drug['id'] ?>"><?= esc($drug['name']) ?></option>
              <?php endforeach; ?>
          </select>
      </div>
      <div class="mb-3">
          <label for="drug_image" class="form-label">Drug Image</label>
          <input class="form-control" type="file" id="drug_image" name="drug_image" accept="image/jpeg,image/png" required>
      </div>
      <button type="submit" class="btn btn-primary">Upload Image</button>
  </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.getElementById('uploadForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  let formData = new FormData(this);
  
  fetch('<?= base_url('admin/drugs/upload-image') ?>', {
      method: 'POST',
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          alert(data.message);
      } else {
          alert('Error: ' + data.error);
      }
  })
  .catch(error => {
      console.error('Error:', error);
  });
});
</script>
<?= $this->endSection() ?>

