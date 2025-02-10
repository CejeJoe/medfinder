<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Inventory Management<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Your Inventory</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="<?= base_url('pharmacy/inventory/add') ?>" class="btn btn-primary">Add New Item</a>
                <a href="<?= base_url('pharmacy/inventory/bulk-upload') ?>" class="btn btn-secondary ml-2">Bulk Upload</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="inventoryTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Drug Name</th>
                            <th>Generic Name</th>
                            <th>Category</th>
                            <th>Price(UGX)</th>
                            <th>Stock</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inventory as $item): ?>
                            <tr id="drug-<?= $item['id'] ?>">
                                <td><?= esc($item['name']) ?></td>
                                <td><?= esc($item['generic_name']) ?></td>
                                <td><?= esc($item['category']) ?></td>
                                <td><?= esc($item['price']) ?></td>
                                <td><?= esc($item['stock']) ?></td>
                                <td><?= $item['featured'] ? 'Yes' : 'No' ?></td>
                                <td>
                                    <a href="<?= base_url('pharmacy/inventory/edit/' . $item['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
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

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        var table = $('#inventoryTable').DataTable();
    
        var eventSource = new EventSource("<?= base_url('api/stock-updates?pharmacy_id=' . session()->get('pharmacy_id')) ?>");
    
        eventSource.onmessage = function(event) {
            var data = JSON.parse(event.data);
            var row = table.row('#drug-' + data.id);
        
            if (row.length) {
                var rowData = row.data();
                rowData[4] = data.stock; // Update the stock column
                row.data(rowData).draw(false);
            }
        };
    });
</script>
<script>
    $(document).ready(function() {
        $('#inventoryTable').DataTable();
    });
</script>
<?= $this->endSection() ?>
