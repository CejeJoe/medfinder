<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?><?= error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);?>

<div class="container mt-5">
    <h1 class="mb-4 text-primary">Order Details</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Order Information</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Order ID:</strong> #<?= esc($order['id']) ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Date:</strong> <?= esc(date('Y-m-d', strtotime($order['created_at']))) ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Total:</strong> Ugx <?= esc(number_format($order['total_amount'], 2)) ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Status:</strong>
                            <span class="badge bg-<?= $order['status'] == 'delivered' ? 'success' : 'warning' ?>">
                                <?= esc(ucfirst($order['status'])) ?>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Delivery Information</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Delivery Person:</strong> <?= esc($order['delivery_person'] ?? 'Not Assigned') ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Estimated Delivery Time:</strong>
                            <?= esc($order['estimated_time'] ?? 'Not Available') ?>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="my-4">

            <h5 class="card-title">Order Items</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Drug Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($order['items'])): ?>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td><?= esc($item['drug_name']) ?></td>
                                    <td><?= esc($item['quantity']) ?></td>
                                    <td>$<?= esc(number_format($item['price'], 2)) ?></td>
                                    <td>$<?= esc(number_format($item['price'] * $item['quantity'], 2)) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No items found for this order.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="<?= base_url('user/order-history') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Order History
        </a>
    </div>
</div>
<?= $this->endSection() ?>