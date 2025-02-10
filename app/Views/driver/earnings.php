<?= $this->extend('layout/driver') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Earnings & Performance</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Earnings Overview</h4>
                            <canvas id="earningsChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <h4>Performance Metrics</h4>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    On-Time Deliveries
                                    <span class="badge bg-primary rounded-pill"><?= $onTimeDeliveries ?>%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Customer Satisfaction
                                    <span class="badge bg-success rounded-pill"><?= number_format($customerSatisfaction, 1) ?>/5</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total Deliveries
                                    <span class="badge bg-info rounded-pill"><?= $totalDeliveries ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Recent Earnings</h4>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Orders Completed</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Earnings</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tips</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentEarnings as $earning): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?= date('M d, Y', strtotime($earning['date'])) ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?= $earning['orders_completed'] ?></p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-secondary text-xs font-weight-bold">UGX <?= number_format($earning['earnings'], 2) ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">UGX <?= number_format($earning['tips'], 2) ?></span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('earningsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($weeklyEarnings, 'week')) ?>,
            datasets: [{
                label: 'Weekly Earnings',
                data: <?= json_encode(array_column($weeklyEarnings, 'earnings')) ?>,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Earnings (UGX)'
                    }
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>

