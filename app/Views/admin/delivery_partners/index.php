<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Delivery Partners<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4">Delivery Partners</h1>
    <a href="<?= base_url('admin/delivery-partners/create') ?>" class="btn btn-primary mb-3">Add New Delivery Partner</a>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Vehicle Type</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($delivery_partners as $partner): ?>
                    <tr>
                        <td><?= esc($partner['name']) ?></td>
                        <td><?= esc($partner['contact_number']) ?></td>
                        <td><?= esc($partner['email']) ?></td>
                        <td><?= esc($partner['vehicle_type']) ?></td>
                        <td><?= $partner['is_available'] ? 'Yes' : 'No' ?></td>
                        <td>
                            <a href="<?= base_url('admin/delivery-partners/edit/' . $partner['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= base_url('admin/delivery-partners/delete/' . $partner['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this delivery partner?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

