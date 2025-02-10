<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Drug Categories<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="h2 mb-4">Drug Categories</h1>

<div class="mb-4"><div class="mb-4">
    <a href="<?= base_url('admin/drugs/add-category') ?>" class="btn btn-primary">Add New Category</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['id'] ?></td>
                    <td><?= $category['name'] ?></td>
                    <td><?= $category['description'] ?></td>
                    <td>
                        <a href="<?= base_url('admin/drugs/edit-category/' . $category['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="<?= base_url('admin/drugs/delete-category/' . $category['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

