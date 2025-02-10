<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Pending Pharmacy Approvals<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="h2 mb-4">Pending Pharmacy Approvals</h1>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pending_approvals as $pharmacy): ?>
                <tr>
                    <td><?= $pharmacy['id'] ?></td>
                    <td><?= $pharmacy['pharmacy_name'] ?></td>
                    <td><?= $pharmacy['address'] ?></td>
                    <td><?= $pharmacy['email'] ?></td>
                    <td>
                        <button class="btn btn-sm btn-success" onclick="approvePharmacy(<?= $pharmacy['id'] ?>)">Approve</button>
                        <button class="btn btn-sm btn-danger" onclick="rejectPharmacy(<?= $pharmacy['id'] ?>)">Reject</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function approvePharmacy(id) {
    if (confirm('Are you sure you want to approve this pharmacy?')) {
        const notes = prompt('Enter any approval notes:');
        if (notes !== null) {
            window.location.href = `<?= base_url('admin/pharmacies/approve/') ?>${id}?notes=${encodeURIComponent(notes)}`;
        }
    }
}

function rejectPharmacy(id) {
    if (confirm('Are you sure you want to reject this pharmacy?')) {
        const notes = prompt('Enter rejection reason:');
        if (notes !== null) {
            window.location.href = `<?= base_url('admin/pharmacies/reject/') ?>${id}?notes=${encodeURIComponent(notes)}`;
        }
    }
}
</script>
<?= $this->endSection() ?>

