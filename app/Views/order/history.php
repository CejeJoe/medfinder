<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4">Order History</h1>
    <?php if (empty($orders)): ?>
        <p>You haven't placed any orders yet.</p>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($orders as $order): ?>
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Order #<?= $order['id'] ?></h5>
                        <small><?= $order['created_at'] ?></small>
                    </div>
                    <p class="mb-1">Total: $<?= number_format($order['total_amount'], 2) ?></p>
                    <p class="mb-1">Status: <?= ucfirst($order['status']) ?></p>
                    <div class="mt-2">
                        <a href="<?= base_url('order/track/' . $order['id']) ?>" class="btn btn-info btn-sm">Track Order</a>
                        <a href="<?= base_url('order/reorder/' . $order['id']) ?>" class="btn btn-primary btn-sm">Reorder</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

