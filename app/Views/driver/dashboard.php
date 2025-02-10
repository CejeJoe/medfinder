<?= $this->extend('layout/driver') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<style>
:root {
    --primary-color: #4F46E5;
    --secondary-color: #10B981;
    --warning-color: #F59E0B;
    --danger-color: #EF4444;
    --background-color: #F3F4F6;
    --card-background: #FFFFFF;
    --text-primary: #111827;
    --text-secondary: #6B7280;
}

body {
    background-color: var(--background-color);
    color: var(--text-primary);
    font-family: 'Inter', sans-serif;
}

.dashboard-container {
    padding: 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background-color: var(--card-background);
    border-radius: 0.5rem;
    padding: 1.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    transition: transform 0.3s ease-in-out;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-title {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
}

.stat-icon {
    float: right;
    font-size: 2rem;
    color: var(--primary-color);
}

.orders-card, .deliveries-card {
    background-color: var(--card-background);
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    margin-bottom: 2rem;
}

.card-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #E5E7EB;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
}

.card-body {
    padding: 1.5rem;
}

.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 0.5rem;
}

.table th {
    text-align: left;
    padding: 0.75rem 1rem;
    font-weight: 500;
    color: var(--text-secondary);
    text-transform: uppercase;
    font-size: 0.75rem;
}

.table td {
    padding: 1rem;
    background-color: #F9FAFB;
    transition: background-color 0.3s ease-in-out;
}

.table tr:hover td {
    background-color: #F3F4F6;
}

.badge {
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-pending {
    background-color: #FEF3C7;
    color: #D97706;
}

.badge-in-progress {
    background-color: #DBEAFE;
    color: #2563EB;
}

.badge-completed {
    background-color: #D1FAE5;
    color: #059669;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.3s ease-in-out;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background-color: #4338CA;
}

.btn-success {
    background-color: var(--secondary-color);
    color: white;
}

.btn-success:hover {
    background-color: #059669;
}

.btn-info {
    background-color: #60A5FA;
    color: white;
}

.btn-info:hover {
    background-color: #3B82F6;
}

#map {
    height: 400px;
    border-radius: 0.5rem;
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-container">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-truck"></i>
            </div>
            <div class="stat-title">Today's Deliveries</div>
            <div class="stat-value"><?= count($todayDeliveries) ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-title">Earnings</div>
            <div class="stat-value">UGX <?= number_format($earnings, 2) ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-title">Completed Orders</div>
            <div class="stat-value"><?= $completedOrders ?></div>
        </div>
    </div>

    <div class="orders-card">
        <div class="card-header">
            <h2 class="card-title">Assigned Orders</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Delivery Address</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Estimated Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($assignedOrders as $order): ?>
                        <tr>
                            <td>#<?= esc($order['order_id']) ?></td>
                            <td><?= esc($order['delivery_address']) ?></td>
                            <td>UGX <?= number_format($order['total_amount'], 2) ?></td>
                            <td>
                                <span class="badge badge-<?= $order['status'] == 'pending' ? 'pending' : ($order['status'] == 'in_progress' ? 'in-progress' : 'completed') ?>">
                                    <?= ucfirst($order['status']) ?>
                                </span>
                            </td>
                            <td><?= esc($order['estimated_delivery_time']) ?></td>
                            <td>
                                <a href="<?= base_url('driver/track-delivery/' . $order['order_id']) ?>" class="btn btn-primary">Start Delivery</a>
                                <button type="button" class="btn btn-success update-status" data-job-id="<?= $order['id'] ?>" data-order-id="<?= $order['order_id'] ?>" data-status="delivered">Complete</button>
                                <button type="button" class="btn btn-info view-map" data-order-id="<?= $order['order_id'] ?>" data-lat="<?= $order['delivery_latitude'] ?>" data-lng="<?= $order['delivery_longitude'] ?>">View Map</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="deliveries-card">
        <div class="card-header">
            <h2 class="card-title">Today's Deliveries</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($todayDeliveries)): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($todayDeliveries as $delivery): ?>
                                <tr>
                                    <td>#<?= esc($delivery['order_id']) ?></td>
                                    <td><?= esc($delivery['customer_name']) ?></td>
                                    <td><?= esc($delivery['delivery_address']) ?></td>
                                    <td>
                                        <span class="badge badge-<?= $delivery['status'] == 'pending' ? 'pending' : ($delivery['status'] == 'in_progress' ? 'in-progress' : 'completed') ?>">
                                            <?= ucfirst(esc($delivery['status'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('driver/track-delivery/' . esc($delivery['order_id'])) ?>" class="btn btn-primary">Track</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center">No deliveries scheduled for today.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel">Delivery Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let map;
    let marker;

    // Update delivery status
    document.querySelectorAll('.update-status').forEach(button => {
        button.addEventListener('click', function() {
            const jobId = this.dataset.jobId;
            const orderId = this.dataset.orderId;
            const status = this.dataset.status;
            const csrfToken = '<?= csrf_token() ?>';
            const csrfHash = '<?= csrf_hash() ?>';
            
            
            fetch('<?= base_url('driver/update-delivery-status') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `job_id=${jobId}&order_id=${orderId}&status=${status}&${csrfToken}=${csrfHash}`

            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Failed to update status: ' + data.message);
                }
            });
        });
    });

    // View map
    document.querySelectorAll('.view-map').forEach(button => {
        button.addEventListener('click', function() {
            const lat = parseFloat(this.dataset.lat);
            const lng = parseFloat(this.dataset.lng);
            const orderId = this.dataset.orderId;

            if (!map) {
                map = L.map('map').setView([lat, lng], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                marker = L.marker([lat, lng]).addTo(map);
            } else {
                map.setView([lat, lng], 13);
                marker.setLatLng([lat, lng]);
            }

            $('#mapModal').modal('show');
            
            // Ensure the map is rendered correctly after the modal is shown
            setTimeout(() => {
                map.invalidateSize();
            }, 300);
        });
    });
});
</script>
<?= $this->endSection() ?>

