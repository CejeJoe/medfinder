<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <h1 class="mb-4">Shopping Cart</h1>
    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped">
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
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?= esc($item['drug_name']) ?></td>
                            <td><?= number_format($item['price'], 2) ?></td>
                            <td>
                                <input type="number" class="form-control quantity-input" 
                                       data-id="<?= $item['id'] ?>" 
                                       value="<?= $item['quantity'] ?>" 
                                       min="1" max="<?= $item['stock'] ?>">
                            </td>
                            <td><?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                            <td>
                                <button class="btn btn-sm btn-danger remove-item" data-id="<?= $item['id'] ?>">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td colspan="2"><strong><?= number_format($total, 2) ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-right mt-3">
            <a href="<?= base_url('order/checkout') ?>" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</div>
<?= $this->section('scripts')?>
<script>
$(document).ready(function() {
    $('.quantity-input').on('change', function() {
        var id = $(this).data('id');
        var quantity = $(this).val();
        $.post('<?= base_url('cart/update') ?>', {id: id, quantity: quantity}, function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert(response.message);
            }
        });
    });

    $('.remove-item').on('click', function() {
        var id = $(this).data('id');
        $.post('<?= base_url('cart/remove') ?>', {id: id}, function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert(response.message);
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>

