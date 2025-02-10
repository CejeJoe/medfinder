<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Inventory Management<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Drug Inventory</h6>
            <a href="<?= base_url('pharmacy/inventory/add') ?>" class="btn btn-primary btn-sm">Add New Drug</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Drug Name</th>
                            <th>Category</th>
                            <th>Current Stock</th>
                            <th>Price(UGX)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inventory as $item): ?>
                        <tr>
                            <td><?= $item['drug_name'] ?></td>
                            <td><?= $item['category'] ?></td>
                            <td><?= $item['stock'] ?></td>
                            <td><?= number_format($item['price'], 2) ?></td>
                            <td>
                                <a href="<?= base_url('pharmacy/inventory/edit/' . $item['id']) ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="<?= base_url('pharmacy/inventory/delete/' . $item['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

