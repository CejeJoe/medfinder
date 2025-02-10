<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Add Drug Category<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="h2 mb-4">Add Drug Category</h1>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('admin/drugs/add-category') ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

