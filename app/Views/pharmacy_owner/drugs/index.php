<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4"><?= $title ?></h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="<?= site_url('pharmacy/drugs/add') ?>" class="btn btn-primary">Add New Drug</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price (UGX)</th>
                            <th>Stock</th>
                            <th>Prescription Required</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($drugs as $drug): ?>
                            <tr>
                                <td><?= esc($drug['name']) ?></td>
                                <td><?= esc($drug['category']) ?></td>
                                <td><?= number_format($drug['price'], 2) ?></td>
                                <td><?= $drug['stock'] ?></td>
                                <td><?= $drug['prescription_required'] ? 'Yes' : 'No' ?></td>
                                <td>
                                    <a href="<?= site_url('pharmacy/drugs/edit/' . $drug['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="<?= site_url('pharmacy/drugs/delete/' . $drug['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this drug?')">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <?= $pager->links() ?>
    </div>
</div>
<?= $this->endSection() ?>

