<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Low Stock Items</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Drug Name</th>
                            <th>Pharmacy</th>
                            <th>Current Stock</th>
                            <th>Reorder Level</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($low_stock_items as $item): ?>
                            <tr>
                                <td><?= esc($item['drug_name']) ?></td>
                                <td><?= esc($item['pharmacy_name']) ?></td>
                                <td><?= $item['stock'] ?></td>
                                <td><?= $item['reorder_level'] ?></td>
                                <td>
                                    <a href="<?= base_url('admin/inventory/restock/' . $item['id']) ?>" class="btn btn-primary btn-sm">Restock</a>
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

