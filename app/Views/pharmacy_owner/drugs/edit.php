<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4"><?= $title ?></h1>

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?= site_url('pharmacy/drugs/edit/' . $drug['id']) ?>" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Drug Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= esc($drug['name']) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" name="category" id="category" class="form-control" value="<?= esc($drug['category']) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control" value="<?= $drug['price'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-control" value="<?= $drug['stock'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="prescription_required" class="form-label">Prescription Required</label>
                    <select name="prescription_required" id="prescription_required" class="form-select" required>
                        <option value="1" <?= $drug['prescription_required'] ? 'selected' : '' ?>>Yes</option>
                        <option value="0" <?= !$drug['prescription_required'] ? 'selected' : '' ?>>No</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Drug</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

