<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4">Track Order #<?= $order['id'] ?></h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Order Status: <?= ucfirst($tracking['status']) ?></h5>
            <p class="card-text">Estimated Delivery: <?= $tracking['estimated_delivery'] ?></p>
            <p class="card-text">Current Location: <?= $tracking['current_location'] ?></p>
            <h6 class="mt-4">Driver Information</h6>
            <p class="card-text">Name: <?= $tracking['driver_name'] ?></p>
            <p class="card-text">Phone: <?= $tracking['driver_phone'] ?></p>
            <div class="progress mt-4">
                <?php
                $statusPercentage = [
                    'pending' => 25,
                    'processing' => 50,
                    'shipped' => 75,
                    'delivered' => 100,
                ];
                $percentage = $statusPercentage[$tracking['status']] ?? 0;
                ?>
                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"><?= $percentage ?>%</div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

