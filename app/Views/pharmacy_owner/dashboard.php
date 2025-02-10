<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Pharmacy Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row g-4">
    <div class="col-md-6 col-lg-3">
        <div class="card stats-card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="display-6"><?= $total_drugs ?></div>
                    <i class="fas fa-pills fa-2x opacity-50"></i>
                </div>
                <h6 class="card-title mb-0">Total Drugs</h6>
                <small class="opacity-75">In your inventory</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="card stats-card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="display-6"><?= $low_stock_count ?></div>
                    <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                </div>
                <h6 class="card-title mb-0">Low Stock Alert</h6>
                <small class="opacity-75">Drugs with low stock</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="card stats-card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="display-6">Ugx<?= number_format($total_sales, 2) ?></div>
                    <i class="fas fa-chart-line fa-2x opacity-50"></i>
                </div>
                <h6 class="card-title mb-0">Total Sales</h6>
                <small class="opacity-75">This month</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="card stats-card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="display-6"><?= $total_orders ?></div>
                    <i class="fas fa-shopping-cart fa-2x opacity-50"></i>
                </div>
                <h6 class="card-title mb-0">Total Orders</h6>
                <small class="opacity-75">This month</small>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8 mb-4">
        <div class="card table-card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Orders</h5>
                <a href="#" class="btn btn-sm btn-primary">View All Orders</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_orders as $order): ?>
                                <tr>
                                    <td>#<?= $order['id'] ?></td>
                                    <td><?= $order['user_id'] ?></td>
                                    <td>Ugx <?= number_format($order['total_amount'], 2) ?></td>
                                    <td>
                                        <?php
                                        $statusClass = [
                                            'processing' => 'bg-warning',
                                            'completed' => 'bg-success',
                                            'cancelled' => 'bg-danger'
                                        ];
                                        ?>
                                        <span class="status-badge <?= $statusClass[$order['status']] ?? 'bg-secondary' ?>">
                                            <?= ucfirst($order['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('Y-m-d H:i', strtotime($order['created_at'])) ?></td>
                                    <td>
    <div class="btn-group btn-group-sm">
        <a href="<?= base_url('pharmacy/orders/view/' . $order['id']) ?>" class="btn btn-light" title="View">
            <i class="fas fa-eye"></i>
        </a>
        <a href="<?= base_url('pharmacy/orders/edit/' . $order['id']) ?>" class="btn btn-light" title="Edit">
            <i class="fas fa-edit"></i>
        </a>
    </div>
</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card table-card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Top Selling Drugs</h5>
            </div>
            <div class="card-body">
                <canvas id="topSellingDrugsChart" height="200"></canvas>
            </div>
        </div>
        
        <div class="card table-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Low Stock Alerts</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php foreach ($low_stock_drugs as $drug): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0"><?= $drug['name'] ?></h6>
                                <small class="text-muted"><?= $drug['stock'] ?> units remaining</small>
                            </div>
                            <span class="badge bg-danger">Low Stock</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->section('scripts')?>

<script>
// Top Selling Drugs Chart
const ctx = document.getElementById('topSellingDrugsChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Drug A', 'Drug B', 'Drug C', 'Drug D', 'Drug E'],
        datasets: [{
            label: 'Units Sold',
            data: [120, 90, 70, 60, 50],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>

