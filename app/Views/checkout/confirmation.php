<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4">Order Confirmation</h1>
    <div class="alert alert-success">
        <h4 class="alert-heading">Thank you for your order!</h4>
        <p>Your order has been placed successfully. Your order number is: <strong>#<?= $order['id'] ?></strong></p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Order Details</h3>
        </div>
        <div class="card-body">
            <p><strong>Order Date:</strong> <?= date('F j, Y, g:i a', strtotime($order['created_at'])) ?></p>
            <p><strong>Order Status:</strong> <?= ucfirst($order['status']) ?></p>
            <p><strong>Shipping Address:</strong> <?= $order['shipping_address'] ?></p>

            <h4 class="mt-4">Order Items</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price(UGX)</th>
                        <th>Subtotal(UGX)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td><?= $item['drug_name'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price'], 2) ?></td>
                            <td><?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">Total:</th>
                        <th>$<?= number_format($order['total_amount'], 2) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <a href="<?= base_url('/') ?>" class="btn btn-primary">Continue Shopping</a>
    </div>
</div>
<?= $this->endSection() ?>

