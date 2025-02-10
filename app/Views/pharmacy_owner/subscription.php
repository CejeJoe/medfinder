<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Manage Subscription<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="mb-4">Manage Your Subscription</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Current Subscription</h5>
            <p><strong>Status:</strong> <?= ucfirst($subscription['status']) ?></p>
            <p><strong>Plan:</strong> <?= $subscription['plan'] ?></p>
            <p><strong>Expires:</strong> <?= date('F j, Y', strtotime($subscription['expiry'])) ?></p>
        </div>
    </div>

    <h2 class="mb-3">Available Plans</h2>
    <div class="row">
        <?php foreach ($plans as $plan): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $plan['name'] ?></h5>
                        <p class="card-text"><?= $plan['description'] ?></p>
                        <ul class="list-unstyled">
                            <?php foreach (json_decode($plan['features'], true) as $feature): ?>
                                <li><i class="fas fa-check text-success me-2"></i><?= $feature ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <p class="h4 mb-3">$<?= number_format($plan['price'], 2) ?> / <?= $plan['duration'] ?> days</p>
                        <form action="<?= base_url('pharmacy_owner/upgrade-plan') ?>" method="post">
                            <input type="hidden" name="plan_id" value="<?= $plan['id'] ?>">
                            <button type="submit" class="btn btn-primary">Upgrade to This Plan</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Premium Listing</h5>
            <p>Get your pharmacy featured at the top of search results!</p>
            <form action="<?= base_url('pharmacy_owner/toggle-premium-listing') ?>" method="post">
                <button type="submit" class="btn btn-<?= $pharmacy['premium_listing'] ? 'danger' : 'success' ?>">
                    <?= $pharmacy['premium_listing'] ? 'Disable' : 'Enable' ?> Premium Listing
                </button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

