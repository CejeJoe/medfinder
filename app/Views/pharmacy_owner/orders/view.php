<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>View Order<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">View Order #<?= $order['id'] ?></h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Customer:</strong> <?= $user['username'] ?? '' ?></p>
                    <p><strong>Email:</strong> <?= $user['email'] ?? '' ?></p>
                    <p><strong>Phone:</strong> <?= $user['phone'] ?? '' ?></p>
                    <p><strong>Delivery Address:</strong> <?= $order['delivery_address'] ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Order Date:</strong> <?= $order['created_at'] ?></p>
                    <p><strong>Status:</strong> <?= ucfirst($order['status']) ?></p>
                    <p><strong>Total Amount:</strong> Ugx <?= number_format($order['total_amount'], 2) ?></p>
                </div>
            </div>
            
            <h5 class="mt-4">Order Items</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Drug Name</th>
                            <th>Quantity</th>
                            <th>Price(UGX)</th>
                            <th>Subtotal(UGX)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td><?= $item['pharmacy_drug_id'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price'], 2) ?></td>
                            <td><?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <form action="<?= base_url('pharmacy/orders/update-status/' . $order['id']) ?>" method="post" class="mt-4">
                <div class="form-group">
                    <label for="status">Update Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                        <option value="delivered" <?= $order['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                        <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
