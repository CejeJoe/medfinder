<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Manage Drugs<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="mb-4">Manage Drugs</h1>

<a href="/admin/drugs/add" class="btn btn-primary mb-3">Add New Drug</a>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($drugs as $drug): ?>
                <tr>
                    <td><?= $drug['id'] ?></td>
                    <td><?= $drug['name'] ?></td>
                    <td><?= $drug['category'] ?></td>
                    <td>
                        <a href="/admin/drugs/edit/<?= $drug['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="/admin/drugs/delete/<?= $drug['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this drug?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>

