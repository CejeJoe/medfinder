<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Bulk Upload Inventory<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Bulk Upload Inventory</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Upload CSV File</h6>
        </div>
        <div class="card-body">
            <p>Download the <a href="<?= base_url('pharmacy/inventory/download-template') ?>">CSV template</a> to see the required format.</p>
            <p>Note: The CSV should contain the following columns: Drug Name, Price, Stock, Featured (Yes/No)</p>
            <form action="<?= base_url('pharmacy/inventory/bulk-upload') ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="csv_file">CSV File</label>
                    <input type="file" class="form-control-file" id="csv_file" name="csv_file" required accept=".csv">
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

