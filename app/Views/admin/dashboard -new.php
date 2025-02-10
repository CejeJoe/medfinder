<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Customer</h6>
                            <h2 class="mb-0">120</h2>
                        </div>
                        <div class="stats-icon bg-primary-subtle rounded-circle p-3">
                            <i class="fas fa-users text-primary fs-4"></i>
                        </div>
                    </div>
                    <a href="#" class="text-primary text-decoration-none mt-3 d-block">Show Details</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Sales</h6>
                            <h2 class="mb-0">234</h2>
                        </div>
                        <div class="stats-icon bg-success-subtle rounded-circle p-3">
                            <i class="fas fa-shopping-cart text-success fs-4"></i>
                        </div>
                    </div>
                    <a href="#" class="text-success text-decoration-none mt-3 d-block">Show Details</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Profit</h6>
                            <h2 class="mb-0">$456</h2>
                        </div>
                        <div class="stats-icon bg-warning-subtle rounded-circle p-3">
                            <i class="fas fa-dollar-sign text-warning fs-4"></i>
                        </div>
                    </div>
                    <a href="#" class="text-warning text-decoration-none mt-3 d-block">Show Details</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card bg-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Out of Stock</h6>
                            <h2 class="mb-0">56</h2>
                        </div>
                        <div class="stats-icon bg-danger-subtle rounded-circle p-3">
                            <i class="fas fa-exclamation-triangle text-danger fs-4"></i>
                        </div>
                    </div>
                    <a href="#" class="text-danger text-decoration-none mt-3 d-block">Show Details</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="row g-4 mb-4">
        <!-- Expiring List -->
        <div class="col-xl-6">
            <div class="card bg-white">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0">Expiring List</h5>
                    <a href="#" class="text-primary text-decoration-none">See All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Medicine name</th>
                                    <th>Expiry Date</th>
                                    <th>Quantity</th>
                                    <th>Chart</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $expiringDrugs = [
                                    ['name' => 'Doxycycline', 'date' => '24 Dec 2024', 'quantity' => 40],
                                    ['name' => 'Abetis', 'date' => '24 Dec 2024', 'quantity' => 40],
                                    ['name' => 'Insulin 10ml', 'date' => '24 Dec 2024', 'quantity' => 40],
                                    ['name' => 'Cerox CV', 'date' => '24 Dec 2024', 'quantity' => 40],
                                    ['name' => 'Fluclox', 'date' => '24 Dec 2024', 'quantity' => 40],
                                ];
                                foreach ($expiringDrugs as $drug): ?>
                                <tr>
                                    <td><?= $drug['name'] ?></td>
                                    <td><?= $drug['date'] ?></td>
                                    <td><?= $drug['quantity'] ?></td>
                                    <td>
                                        <canvas class="mini-chart" width="50" height="20" data-values="[4,6,3,7,5]"></canvas>
                                    </td>
                                    <td>
                                        <button class="btn btn-light btn-sm rounded-circle">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="col-xl-6">
            <div class="card bg-white">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0">Recent Orders</h5>
                    <a href="#" class="text-primary text-decoration-none">See All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Medicine name</th>
                                    <th>Batch No.</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $recentOrders = [
                                    ['name' => 'Paricol 15mg', 'batch' => '78362783', 'quantity' => 40, 'status' => 'Delivered', 'price' => '$23.00'],
                                    ['name' => 'Abetis 20mg', 'batch' => '8583433', 'quantity' => 40, 'status' => 'Pending', 'price' => '$23.00'],
                                    ['name' => 'Cerox CV', 'batch' => '7676344', 'quantity' => 40, 'status' => 'Cancelled', 'price' => '$23.00'],
                                    ['name' => 'Abetis 20mg', 'batch' => '4557866', 'quantity' => 40, 'status' => 'Delivered', 'price' => '$23.00'],
                                    ['name' => 'Cerox CV', 'batch' => '7676344', 'quantity' => 40, 'status' => 'Cancelled', 'price' => '$23.00'],
                                ];
                                foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td><?= $order['name'] ?></td>
                                    <td><?= $order['batch'] ?></td>
                                    <td><?= $order['quantity'] ?></td>
                                    <td>
                                        <span class="badge rounded-pill <?= strtolower($order['status']) === 'delivered' ? 'bg-success' : (strtolower($order['status']) === 'cancelled' ? 'bg-danger' : 'bg-warning') ?>">
                                            <?= $order['status'] ?>
                                        </span>
                                    </td>
                                    <td><?= $order['price'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4">
        <!-- Monthly Progress -->
        <div class="col-xl-8">
            <div class="card bg-white">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0">Monthly Progress</h5>
                    <select class="form-select form-select-sm w-auto">
                        <option>Monthly</option>
                        <option>Weekly</option>
                        <option>Daily</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="monthlyProgressChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Today's Report -->
        <div class="col-xl-4">
            <div class="card bg-white">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title mb-0">Today's Report</h5>
                </div>
                <div class="card-body">
                    <canvas id="todaysReportChart" height="300"></canvas>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Total Earning</span>
                            <span class="fw-bold">$5098.00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Total Purchase</span>
                            <span class="fw-bold">$2345.00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Cash Received</span>
                            <span class="fw-bold">$1456.00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Bank Receive</span>
                            <span class="fw-bold">$1297.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mini Charts (Sparklines)
    document.querySelectorAll('.mini-chart').forEach(function(canvas) {
        const ctx = canvas.getContext('2d');
        const values = JSON.parse(canvas.dataset.values);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: values.map((_, i) => i + 1),
                datasets: [{
                    data: values,
                    borderColor: '#0066FF',
                    borderWidth: 2,
                    pointRadius: 0,
                    fill: false,
                    tension: 0.4
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
                    x: {
                        display: false
                    },
                    y: {
                        display: false
                    }
                }
            }
        });
    });

    // Monthly Progress Chart
    const monthlyCtx = document.getElementById('monthlyProgressChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Progress',
                data: [30, 35, 33, 45, 35, 40, 50, 35, 40, 35, 40, 30],
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

    // Today's Report Chart
    const reportCtx = document.getElementById('todaysReportChart').getContext('2d');
    new Chart(reportCtx, {
        type: 'doughnut',
        data: {
            labels: ['Total Purchase', 'Cash Received', 'Bank Receive', 'Total Service'],
            datasets: [{
                data: [30, 25, 25, 20],
                backgroundColor: ['#0066FF', '#FF6B35', '#9B7EDE', '#2ecc71'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>

