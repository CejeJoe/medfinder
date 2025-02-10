<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4">Your Cart</h1>
    <?php if (empty($cart)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <form action="<?= base_url('cart/update') ?>" method="post">
            <?= csrf_field() ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price(UGX)</th>
                        <th>Quantity</th>
                        <th>Subtotal(UGX)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $item): ?>
                        <tr>
                            <td><?= esc($item['name']) ?></td>
                            <td><?= number_format($item['price'], 0) ?></td>
                            <td>
                                <input type="number" name="quantities[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control" style="width: 80px;">
                            </td>
                            <td><?= number_format($item['price'] * $item['quantity'], 0) ?></td>
                            <td>
                                <a href="<?= base_url('cart/remove/' . $item['id']) ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td><strong>UGX <?= number_format($total, 0) ?></strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Update Cart</button>
                <a href="<?= base_url('order/checkout') ?>" class="btn btn-success">Proceed to Checkout</a>
            </div>
        </form>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

