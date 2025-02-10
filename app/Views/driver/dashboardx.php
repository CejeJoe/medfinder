<?= $this->extend('layout/driver') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1>Welcome, <?= esc($driver['username']) ?></h1>

    <h2>Your Assigned Orders</h2>

    <?php if (empty($assignedOrders)): ?>
        <p>No orders assigned at the moment.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($assignedOrders as $order): ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order #<?= esc($order['order_id']) ?></h5>
                            <p class="card-text">
                                <strong>Delivery Address:</strong> <?= esc($order['delivery_address']) ?><br>
                                <strong>Total Amount:</strong> UGX <?= number_format($order['total_amount'], 2) ?><br>
                                <strong>Status:</strong> <?= esc(ucfirst($order['status'])) ?><br>
                                <strong>Estimated Delivery Time:</strong> <?= esc($order['estimated_delivery_time']) ?>
                            </p>
                            <div class="btn-group" role="group">
                                <a href="<?= base_url('driver/track-delivery/' . $order['order_id']) ?>" class="btn btn-primary">Start Delivery</a>
                                <button type="button" class="btn btn-success update-status" data-job-id="<?= $order['id'] ?>" data-order-id="<?= $order['order_id'] ?>" data-status="delivered">Complete Delivery</button>
                                <button type="button" class="btn btn-info view-map" data-order-id="<?= $order['order_id'] ?>" data-lat="<?= $order['delivery_latitude'] ?>" data-lng="<?= $order['delivery_longitude'] ?>">View Map</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div id="mapModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delivery Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="map" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let map;
    let marker;
    let routingControl;

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

    // Follow route
    document.querySelectorAll('.update-status[data-status="in_progress"]').forEach(button => {
        button.addEventListener('click', function() {
            const lat = parseFloat(this.dataset.lat);
            const lng = parseFloat(this.dataset.lng);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const currentLat = position.coords.latitude;
                    const currentLng = position.coords.longitude;

                    if (routingControl) {
                        map.removeControl(routingControl);
                    }

                    routingControl = L.Routing.control({
                        waypoints: [
                            L.latLng(currentLat, currentLng),
                            L.latLng(lat, lng)
                        ],
                        routeWhileDragging: true
                    }).addTo(map);
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });
    });
});
</script>
<?= $this->endSection() ?>

