<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Order Management<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Order Management</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td>name</td>
                            <td>Ugx <?= number_format($order['total_amount'], 2) ?></td>
                            <td><?= ucfirst($order['status']) ?></td>
                            <td><?= $order['created_at'] ?></td>
                            <td>
                                <a href="<?= base_url('pharmacy/orders/view/' . $order['id']) ?>" class="btn btn-info btn-sm">View</a>
                                <?php if ($order['status'] == 'processing' || $order['status'] == 'pending'): ?>
                                    <a href="<?= base_url('pharmacy/orders/assign-delivery/' . $order['id']) ?>" class="btn btn-primary btn-sm">Assign Delivery</a>
                                <?php endif; ?>
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

