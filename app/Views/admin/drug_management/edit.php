<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Edit Drug<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="h2 mb-4">Edit Drug</h1>

<form action="<?= base_url('admin/drugs/edit/' . $drug['id']) ?>" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Drug Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $drug['name'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select class="form-control" id="category" name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= $category['id'] == $drug['category'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"><?= $drug['description'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?= $drug['price'] ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Drug</button>
</form>
<?= $this->endSection() ?>