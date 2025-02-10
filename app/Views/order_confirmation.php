<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Order Confirmation<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center mb-4">Order Confirmation</h1>
                <div class="alert alert-success" role="alert">
                    Your order has been successfully placed!
                </div>
                <h5>Order Details:</h5>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Order ID
                        <span>#<?= $order['id'] ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Amount
                        <span>Ugx <?= number_format($order['total_amount'], 2) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Delivery Address
                        <span><?= $order['delivery_address'] ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Delivery Type
                        <span><?= ucfirst($order['delivery_type']) ?></span>
                    </li>
                </ul>
                <p class="text-center">
                    <a href="/" class="btn btn-primary">Back to Home</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

