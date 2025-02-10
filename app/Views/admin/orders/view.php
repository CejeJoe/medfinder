<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <h1 class="mb-4">View Order #<?= $order['id'] ?></h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Order Details</h5>
            <p class="card-text">Status: <span class="badge bg-<?= $order['status'] == 'pending' ? 'warning' : 'success' ?>"><?= ucfirst($order['status']) ?></span></p>
            <p class="card-text">Total Amount: $<?= number_format($order['total_amount'], 2) ?></p>
            <p class="card-text">Delivery Address: <?= esc($order['delivery_address']) ?></p>
            <p class="card-text">Pharmacy: <?= esc($order['pharmacy_name']) ?></p>
            <h6 class="mt-4">Order Items:</h6>
            <table class="table">
                <thead>
                    <tr>
                        <th>Drug</th>
                        <th>Quantity</th>
                        <th>Price(UGX)</th>
                        <th>Subtotal(UGX)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td><?= esc($item['drug_name']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price'], 2) ?></td>
                            <td><?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

