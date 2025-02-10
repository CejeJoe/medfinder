<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title text-center mb-4">Order Confirmation</h1>
                    <div class="text-center mb-4">
                        <i class="fas fa-check-circle text-success fa-4x"></i>
                    </div>
                    <h2 class="text-center mb-4">Thank you for your order!</h2>
                    <p class="text-center mb-4">Your order has been received and is being processed.</p>

                    <div class="order-details mb-4">
                        <h3 class="mb-3">Order Details</h3>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Order Number:</th>
                                    <td>#<?= esc($order['id']) ?></td>
                                </tr>
                                <tr>
                                    <th>Order Date:</th>
                                    <td><?= date('F j, Y, g:i a', strtotime($order['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Total Amount:</th>
                                    <td>UGX <?= number_format($order['total_amount'], 2) ?></td>
                                </tr>
                                <tr>
                                    <th>Payment Method:</th>
                                    <td><?= ucfirst($order['payment_method']) ?></td>
                                </tr>
                                <tr>
                                    <th>Delivery Address:</th>
                                    <td><?= esc($order['delivery_address']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="order-items mb-4">
                        <h3 class="mb-3">Order Items</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order['items'] as $item): ?>
                                    <tr>
                                        <td><?= esc($item['drug_name']) ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>UGX <?= number_format($item['price'], 2) ?></td>
                                        <td>UGX <?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center">
                        <a href="<?= base_url('order/track/' . $order['id']) ?>" class="btn btn-primary me-2">Track Order</a>
                        <a href="<?= base_url('user/dashboard') ?>" class="btn btn-secondary">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

