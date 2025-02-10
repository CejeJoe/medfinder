<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manage Subscription</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Current Plan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $currentPlan['name'] ?? 'No active plan' ?>
                                <?php if (!empty($currentPlan)): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Expiry Date</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php if (!empty($currentPlan['expiry_date'])): ?>
                                    <?= date('F j, Y', strtotime($currentPlan['expiry_date'])) ?>
                                    <?php 
                                    $daysLeft = ceil((strtotime($currentPlan['expiry_date']) - time()) / (60 * 60 * 24));
                                    if ($daysLeft > 0): ?>
                                        <small class="text-muted">(<?= $daysLeft ?> days left)</small>
                                    <?php endif; ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Available Plans</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($availablePlans as $plan): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 <?= (!empty($currentPlan) && $currentPlan['name'] === $plan['name']) ? 'border-primary' : '' ?>">
                            <div class="card-header bg-transparent <?= (!empty($currentPlan) && $currentPlan['name'] === $plan['name']) ? 'text-primary' : '' ?>">
                                <h5 class="card-title mb-0"><?= esc($plan['name']) ?></h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text"><?= esc($plan['description']) ?></p>
                                <div class="features-list mb-3">
                                    <h6 class="font-weight-bold">Features:</h6>
                                    <ul class="list-unstyled">
                                        <?php 
                                        $features = json_decode($plan['features'], true);
                                        if (is_array($features) && !empty($features)): 
                                            foreach ($features as $feature): ?>
                                                <li>
                                                    <i class="fas fa-check text-success me-2"></i>
                                                    <?= esc($feature) ?>
                                                </li>
                                            <?php endforeach; 
                                        else: ?>
                                            <li class="text-muted">No features listed</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                <div class="pricing text-center mb-3">
                                    <h4 class="text-primary mb-0">$<?= number_format($plan['price'], 2) ?></h4>
                                    <small class="text-muted">per <?= $plan['duration'] ?> days</small>
                                </div>
                                <?php if (empty($currentPlan) || $currentPlan['name'] !== $plan['name']): ?>
                                    <form action="<?= base_url('pharmacy/subscription/upgrade') ?>" method="post">
                                        <input type="hidden" name="plan_id" value="<?= $plan['id'] ?>">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <?= empty($currentPlan) ? 'Subscribe' : 'Upgrade to This Plan' ?>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-outline-primary w-100" disabled>Current Plan</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php if (!empty($currentPlan)): ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Cancel Subscription</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Warning: Cancelling your subscription will immediately remove access to premium features.
                </div>
                <p>If you wish to cancel your current subscription, please click the button below. This action cannot be undone.</p>
                <form action="<?= base_url('pharmacy/subscription/cancel') ?>" method="post" 
                      onsubmit="return confirm('Are you sure you want to cancel your subscription? This action cannot be undone.');">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times-circle me-2"></i>
                        Cancel Subscription
                    </button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->section('scripts')?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>

