<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">View Pharmacy</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="card-title"><?= $pharmacy['name'] ?></h5>
            <p><strong>Address:</strong> <?= $pharmacy['address'] ?></p>
            <p><strong>Contact Number:</strong> <?= $pharmacy['contact_number'] ?></p>
            <p><strong>Status:</strong> <?= $pharmacy['is_active'] ? 'Active' : 'Inactive' ?></p>
            <a href="<?= base_url('admin/pharmacies/edit/' . $pharmacy['id']) ?>" class="btn btn-primary">Edit</a>
            <a href="<?= base_url('admin/pharmacies') ?>" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

