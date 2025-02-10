<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Search Results<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="mb-4">Search Results</h1>

<div class="row">
    <?php foreach ($results as $result): ?>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="<?= $result['drug']['image_url'] ?? '/images/placeholder.jpg' ?>" class="img-fluid rounded" alt="<?= $result['drug']['name'] ?>">
                        </div>
                        <div class="col-md-8">
                            <h5 class="card-title"><?= $result['drug']['name'] ?></h5>
                            <p class="card-text">
                                <strong>Price:</strong> $<?= number_format($result['price'], 2) ?><br>
                                <strong>Stock:</strong> <?= $result['stock'] ?> units<br>
                                <strong>Pharmacy:</strong> <?= $result['pharmacy']['name'] ?><br>
                                <strong>Location:</strong> <?= $result['pharmacy']['address'] ?>
                            </p>
                            <a href="<?= base_url('/pharmacy')?>/<?= $result['pharmacy']['id'] ?>" class="btn btn-primary">View Pharmacy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>

