<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4 text-primary">Order History</h1>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>You haven't placed any orders yet.
        </div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?= $order['id'] ?></td>
                                    <td><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
                                    <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                    <td><span class="badge bg-<?= $order['status'] == 'completed' ? 'success' : 'warning' ?>"><?= ucfirst($order['status']) ?></span></td>
                                    <td>
                                        <a href="<?= base_url('user/order/order_view/' . $order['id']) ?>" class="btn btn-sm btn-primary"><i class="fas fa-eye me-1"></i>View Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?= $pager->links() ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

