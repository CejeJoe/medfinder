<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4"><?= $title ?></h1>

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?= site_url('pharmacy/drugs/add') ?>" method="post">
                <div class="mb-3">
                    <label for="drug_id" class="form-label">Drug</label>
                    <select name="drug_id" id="drug_id" class="form-select" required>
                        <option value="">Select a drug</option>
                        <?php foreach ($allDrugs as $drug): ?>
                            <option value="<?= $drug['id'] ?>"><?= esc($drug['name']) ?> (<?= esc($drug['category']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="prescription_required" class="form-label">Prescription Required</label>
                    <select name="prescription_required" id="prescription_required" class="form-select" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Add Drug</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

