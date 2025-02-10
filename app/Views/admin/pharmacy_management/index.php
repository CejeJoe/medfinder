<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Pharmacy Management<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Pharmacy Management</h1>
    <a href="<?= base_url('admin/pharmacies/add') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Pharmacy
    </a>
</div>

<div class="card table-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pharmacies as $pharmacy): ?>
                        <tr>
                            <td><?= $pharmacy['id'] ?></td>
                            <td><?= $pharmacy['name'] ?></td>
                            <td><?= $pharmacy['address'] ?></td>
                            <td><?= $pharmacy['contact_number'] ?></td>
                            <td>
                                <?php
                                $statusClass = [
                                    '1' => 'bg-success',
                                    '0' => 'bg-danger',
                                    'pending' => 'bg-warning'
                                ];
                                ?>
                                <span class="status-badge <?= $statusClass[$pharmacy['is_active']] ?? 'bg-secondary' ?>">
                                    <?= ucfirst($pharmacy['is_active']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= base_url('admin/pharmacies/edit/' . $pharmacy['id']) ?>" class="btn btn-light" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/pharmacies/view/' . $pharmacy['id']) ?>" class="btn btn-light" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-light" title="Delete" onclick="confirmDelete(<?= $pharmacy['id'] ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this pharmacy?')) {
        window.location.href = '<?= base_url('admin/pharmacies/delete/') ?>' + id;
    }
}
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>