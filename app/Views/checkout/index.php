<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4">Checkout</h1>

    <?php if (session('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <form action="<?= base_url('order/create') ?>" method="post">
                <?= csrf_field() ?>
                <h3>Shipping Information</h3>
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?= esc(session('full_name')) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= esc(session('phone_number')) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= esc(session('email')) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" required>
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country" required>
                </div>
                <div class="mb-3">
                    <label for="zip_code" class="form-label">ZIP Code</label>
                    <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                </div>
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        </div>
        <div class="col-md-4">
            <h3>Order Summary</h3>
            <ul class="list-group mb-3">
                <?php foreach ($cart_items as $item): ?>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0"><?= $item['name'] ?></h6>
                            <small class="text-muted">Quantity: <?= $item['quantity'] ?></small>
                        </div>
                        <span class="text-muted">$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                    </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong>$<?= number_format($total, 2) ?></strong>
                </li>
            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

