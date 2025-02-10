<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
  <h1 class="mb-4">Upload Stock CSV</h1>
  <form id="csvUploadForm" enctype="multipart/form-data">
      <div class="mb-3">
          <label for="stock_csv" class="form-label">CSV File</label>
          <input class="form-control" type="file" id="stock_csv" name="stock_csv" accept=".csv" required>
      </div>
      <button type="submit" class="btn btn-primary">Upload CSV</button>
  </form>

  <div id="mappingForm" style="display: none;" class="mt-5">
      <h2>Map CSV Columns</h2>
      <form id="columnMappingForm">
          <div id="mappingFields"></div>
          <button type="submit" class="btn btn-primary mt-3">Import Data</button>
      </form>
  </div>
</div>

<script>
document.getElementById('csvUploadForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  let formData = new FormData(this);
  
  fetch('<?= base_url('admin/stocks/upload') ?>', {
      method: 'POST',
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          showMappingForm(data.headers, data.filename);
      } else {
          alert('Error: ' + data.error);
      }
  })
  .catch(error => {
      console.error('Error:', error);
  });
});

function showMappingForm(headers, filename) {
  const mappingFields = document.getElementById('mappingFields');
  mappingFields.innerHTML = '';
  
  const requiredFields = ['drug_name', 'price', 'stock'];
  
  requiredFields.forEach(field => {
      const select = document.createElement('select');
      select.name = field;
      select.className = 'form-select mb-3';
      select.required = true;
      
      const defaultOption = document.createElement('option');
      defaultOption.value = '';
      defaultOption.textContent = `Select column for ${field}`;
      select.appendChild(defaultOption);
      
      headers.forEach((header, index) => {
          const option = document.createElement('option');
          option.value = index;
          option.textContent = header;
          select.appendChild(option);
      });
      
      const label = document.createElement('label');
      label.textContent = `Map ${field}`;
      label.className = 'form-label';
      
      const div = document.createElement('div');
      div.className = 'mb-3';
      div.appendChild(label);
      div.appendChild(select);
      
      mappingFields.appendChild(div);
  });
  
  const filenameInput = document.createElement('input');
  filenameInput.type = 'hidden';
  filenameInput.name = 'filename';
  filenameInput.value = filename;
  mappingFields.appendChild(filenameInput);
  
  document.getElementById('mappingForm').style.display = 'block';
}

document.getElementById('columnMappingForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);
  const mapping = {};
  formData.forEach((value, key) => {
      if (key !== 'filename') {
          mapping[key] = value;
      }
  });
  
  const data = {
      mapping: mapping,
      filename: formData.get('filename'),
      pharmacy_id: <?= session()->get('pharmacy_id') ?>
  };
  
  fetch('<?= base_url('admin/stocks/map') ?>', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          alert(data.message);
          location.reload();
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

