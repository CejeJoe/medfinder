<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Bulk Upload Drugs<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/drugs') ?>">Drug Management</a></li>
            <li class="breadcrumb-item active">Bulk Upload</li>
        </ol>
    </nav>

    <h1 class="h3 mb-4">Bulk Upload Drugs</h1>

    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('admin/drugs/bulk-upload') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="csv_file" class="form-label">CSV File</label>
                    <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                    <div class="form-text">Upload a CSV file containing drug information.</div>
                </div>

                <div class="mb-3">
                    <a href="<?= base_url('admin/drugs/download-template') ?>" class="btn btn-secondary">
                        <i class="fas fa-download me-2"></i>Download CSV Template
                    </a>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload me-2"></i>Upload Drugs
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const fileInput = document.getElementById('csv_file');

    form.addEventListener('submit', function(e) {
        if (fileInput.files.length === 0) {
            e.preventDefault();
            alert('Please select a CSV file to upload.');
        }
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>

