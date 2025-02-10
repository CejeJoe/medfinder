<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>MedFinder Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Users</h6>
                            <h2 class="mb-0"><?= $total_users ?></h2>
                        </div>
                        <div class="stats-icon bg-primary-subtle rounded-circle p-3">
                            <i class="fas fa-users text-primary fs-4"></i>
                        </div>
                    </div>
                    <a href="<?= base_url('admin/users') ?>" class="text-primary text-decoration-none mt-3 d-block">Show Details</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Pharmacies</h6>
                            <h2 class="mb-0"><?= $total_pharmacies ?></h2>
                        </div>
                        <div class="stats-icon bg-success-subtle rounded-circle p-3">
                            <i class="fas fa-clinic-medical text-success fs-4"></i>
                        </div>
                    </div>
                    <a href="<?= base_url('admin/pharmacies') ?>" class="text-success text-decoration-none mt-3 d-block">Show Details</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Orders</h6>
                            <h2 class="mb-0"><?= $total_orders ?></h2>
                        </div>
                        <div class="stats-icon bg-warning-subtle rounded-circle p-3">
                            <i class="fas fa-shopping-cart text-warning fs-4"></i>
                        </div>
                    </div>
                    <a href="<?= base_url('admin/orders') ?>" class="text-warning text-decoration-none mt-3 d-block">Show Details</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Drugs</h6>
                            <h2 class="mb-0"><?= $total_drugs ?></h2>
                        </div>
                        <div class="stats-icon bg-danger-subtle rounded-circle p-3">
                            <i class="fas fa-pills text-danger fs-4"></i>
                        </div>
                    </div>
                    <a href="<?= base_url('admin/drugs') ?>" class="text-danger text-decoration-none mt-3 d-block">Show Details</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="row g-4 mb-4">
        <!-- Recent Orders -->
        <div class="col-xl-8">
            <div class="card bg-white">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0">Recent Orders</h5>
                    <a href="<?= base_url('admin/orders') ?>" class="text-primary text-decoration-none">See All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Pharmacy</th>
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
                                    <td><?= $order['pharmacy_id'] ?></td>
                                    <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                    <td>
                                        <?php
                                        $statusClass = [
                                            'processing' => 'bg-warning',
                                            'completed' => 'bg-success',
                                            'cancelled' => 'bg-danger'
                                        ];
                                        ?>
                                        <span class="badge rounded-pill <?= $statusClass[$order['status']] ?? 'bg-secondary' ?>">
                                            <?= ucfirst($order['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('Y-m-d H:i', strtotime($order['created_at'])) ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('admin/orders/view/' . $order['id']) ?>" class="btn btn-light" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/orders/edit/' . $order['id']) ?>" class="btn btn-light" title="Edit">
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

        <!-- Low Stock Alerts -->
        <div class="col-xl-4">
            <div class="card bg-white">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0">Low Stock Alerts</h5>
                    <a href="<?= base_url('admin/inventory/low-stock') ?>" class="text-primary text-decoration-none">See All</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php if (isset($low_stock_drugs) && !empty($low_stock_drugs)): ?>
                            <?php foreach ($low_stock_drugs as $drug): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0"><?= $drug['name'] ?></h6>
                                        <small class="text-muted"><?= $drug['stock'] ?> units remaining</small>
                                    </div>
                                    <span class="badge bg-<?= $drug['stock'] <= 5 ? 'danger' : 'warning' ?>"><?= $drug['stock'] <= 5 ? 'Low Stock' : 'Running Low' ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="list-group-item">No low stock items found.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4">
        <!-- Monthly Sales -->
        <div class="col-xl-8">
            <div class="card bg-white">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0">Monthly Sales</h5>
                    <select class="form-select form-select-sm w-auto" id="monthlySalesPeriod">
                        <option value="6">Last 6 Months</option>
                        <option value="12">Last 12 Months</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="monthlySalesChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Order Statistics -->
        <div class="col-xl-4">
            <div class="card bg-white">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title mb-0">Order Statistics</h5>
                </div>
                <div class="card-body">
                <div style="height: 300px;"> <!-- Fixed height container -->
                    <canvas id="orderStatusChart"></canvas>
                </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Completed Orders</span>
                            <span class="fw-bold"><?= $order_status_data['delivered'] ?? 0 ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Processing Orders</span>
                            <span class="fw-bold"><?= $order_status_data['processing'] ?? 0 ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Pending Orders</span>
                            <span class="fw-bold"><?= $order_status_data['pending'] ?? 0 ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Cancelled Orders</span>
                            <span class="fw-bold"><?= $order_status_data['cancelled'] ?? 0 ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total Orders</span>
                            <span class="fw-bold"><?= $total_orders ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Activities</h5>
                    <a href="<?= base_url('admin/activities') ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <?php if (isset($recent_activities) && !empty($recent_activities)): ?>
                        <ul class="list-group">
                            <?php foreach ($recent_activities as $activity): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-<?= $activity['icon'] ?> me-2"></i>
                                        <?= $activity['description'] ?>
                                    </div>
                                    <small class="text-muted"><?= $activity['time_ago'] ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No recent activities found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Order Status Chart
const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
let orderStatusChart = null;

function initializeOrderStatusChart() {
    if (orderStatusChart) {
        orderStatusChart.destroy();
    }
    orderStatusChart = new Chart(orderStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Delivered', 'Processing', 'Pending', 'Cancelled'],
            datasets: [{
                data: [
                    <?= $order_status_data['delivered'] ?? 0 ?>, 
                    <?= $order_status_data['processing'] ??  0 ?>, 
                    <?= $order_status_data['pending'] ?? 0 ?>,
                    <?= $order_status_data['cancelled'] ??  0 ?>
                ],
                backgroundColor: ['#28a745', '#ffc107', '#5065f7' ,'#dc3545'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });
}

// Initialize the chart when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeOrderStatusChart();
});

// Redraw the chart on window resize to maintain responsiveness
window.addEventListener('resize', function() {
    initializeOrderStatusChart();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Sales Chart
    const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
    const monthlySalesChart = new Chart(monthlySalesCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($monthly_sales, 'month')) ?>,
            datasets: [{
                label: 'Sales',
                data: <?= json_encode(array_column($monthly_sales, 'total')) ?>,
                backgroundColor: '#0066FF',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Monthly Sales Period Selector
    document.getElementById('monthlySalesPeriod').addEventListener('change', function() {
        const period = this.value;
        // Here you would typically fetch new data based on the selected period
        // For this example, we'll just update the chart with random data
        const newData = Array.from({length: period}, () => Math.floor(Math.random() * 10000));
        const newLabels = Array.from({length: period}, (_, i) => `Month ${i + 1}`);
        
        monthlySalesChart.data.labels = newLabels;
        monthlySalesChart.data.datasets[0].data = newData;
        monthlySalesChart.update();
    });
});
</script>
<?= $this->endSection() ?>
