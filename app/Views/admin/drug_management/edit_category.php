<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Edit Category<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="h2 mb-4">Edit Category</h1>

<form action="<?= base_url('admin/drugs/edit-category/' . $category['id']) ?>" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $category['name'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"><?= $category['description'] ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Update Category</button>
</form>
<?= $this->endSection() ?>