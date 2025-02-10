<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/drugs') ?>">Drug Management</a></li>
            <li class="breadcrumb-item active">Pending Approvals</li>
        </ol>
    </nav>
    <h1 class="mb-4">Pending Drug Approvals</h1>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($drugs as $drug): ?>
                        <tr>
                            <td><?= $drug['id'] ?></td>
                            <td><?= esc($drug['name']) ?></td>
                            <td><?= esc($drug['category']) ?></td>
                            <td><?= esc($drug['description']) ?></td>
                            <td>
                                <a href="<?= base_url('admin/drugs/approve/' . $drug['id']) ?>" class="btn btn-success btn-sm">Approve</a>
                                <a href="<?= base_url('admin/drugs/reject/' . $drug['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this drug?')">Reject</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

