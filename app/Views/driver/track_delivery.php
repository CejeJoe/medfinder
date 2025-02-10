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

.delivery-container {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 64px);
    padding: 1rem;
}

.map-container {
    flex: 1;
    position: relative;
    z-index: 1;
    margin-bottom: 1rem;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

#map {
    height: 100%;
    width: 100%;
}

.delivery-card {
    background: var(--card-background);
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    padding: 1.5rem;
}

.delivery-header {
    margin-bottom: 1rem;
}

.earnings {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.trip-stats {
    display: flex;
    gap: 1rem;
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.delivery-progress {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
}

.step-icon {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    background: var(--background-color);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.5rem;
    color: var(--text-secondary);
}

.progress-step.active .step-icon {
    background: var(--primary-color);
    color: white;
}

.progress-step.completed .step-icon {
    background: var(--secondary-color);
    color: white;
}

.step-label {
    font-size: 0.75rem;
    color: var(--text-secondary);
    text-align: center;
}

.location-list {
    margin-bottom: 1.5rem;
}

.location-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.location-icon {
    width: 2rem;
    height: 2rem;
    background: var(--background-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
}

.location-details h3 {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.location-details p {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0;
}

.action-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.btn {
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 0.375rem;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background-color: #4338CA;
}

.btn-secondary {
    background-color: var(--secondary-color);
    color: white;
}

.btn-secondary:hover {
    background-color: #059669;
}

@media (min-width: 768px) {
    .delivery-container {
        flex-direction: row;
        gap: 1rem;
    }

    .map-container {
        flex: 2;
        margin-bottom: 0;
    }

    .delivery-card {
        flex: 1;
        max-width: 400px;
        overflow-y: auto;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="delivery-container">
    <div class="map-container">
        <div id="map"></div>
    </div>
    
    <div class="delivery-card">
        <div class="delivery-header">
            <div class="earnings">UGX <?= number_format($order['delivery_fee'], 2) ?></div>
            <div class="trip-stats">
                <div>1 stop</div>
                <div id="distance">Calculating distance...</div>
                <div id="estimatedTime">Calculating time...</div>
            </div>
        </div>

        <div class="delivery-progress">
            <div class="progress-step completed">
                <div class="step-icon">
                    <i class="fas fa-check"></i>
                </div>
                <div class="step-label">Accepted</div>
            </div>
            <div class="progress-step active">
                <div class="step-icon">
                    <i class="fas fa-motorcycle"></i>
                </div>
                <div class="step-label">On the Way</div>
            </div>
            <div class="progress-step">
                <div class="step-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="step-label">Arrived</div>
            </div>
            <div class="progress-step">
                <div class="step-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="step-label">Delivered</div>
            </div>
        </div>

        <div class="location-list">
            <div class="location-item">
                <div class="location-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="location-details">
                    <h3>Delivery Location</h3>
                    <p><?= esc($order['delivery_address']) ?></p>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <button id="startDelivery" class="btn btn-primary">Start Delivery</button>
            <button id="arrivedAtLocation" class="btn btn-secondary" style="display: none;">Arrived at Location</button>
            <button id="endDelivery" class="btn btn-secondary" style="display: none;">Complete Delivery</button>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="deliveryCompletedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                <h3 class="mb-3">Delivery Completed!</h3>
                <p class="mb-4">Great job! You've successfully completed the delivery.</p>
                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">Back to Dashboard</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lat = <?= $order['delivery_latitude'] ?>;
    const lng = <?= $order['delivery_longitude'] ?>;
    let map = L.map('map').setView([lat, lng], 13);
    let routingControl;
    let startTime;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const destinationMarker = L.marker([lat, lng]).addTo(map);
    let driverMarker;

    function updateDriverLocation(position) {
        const { latitude, longitude } = position.coords;
        if (!driverMarker) {
            driverMarker = L.marker([latitude, longitude], {
                icon: L.divIcon({
                    className: 'driver-icon',
                    html: '<i class="fas fa-motorcycle fa-2x text-primary"></i>',
                    iconSize: [40, 40],
                    iconAnchor: [20, 20]
                })
            }).addTo(map);
        } else {
            driverMarker.setLatLng([latitude, longitude]);
        }

        if (routingControl) {
            routingControl.setWaypoints([
                L.latLng(latitude, longitude),
                L.latLng(lat, lng)
            ]);
        }
    }

    function startTracking() {
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(updateDriverLocation, null, {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            });
        }
    }

    function updateOrderStatus(status) {
        const orderId = <?= $order['id'] ?>;
        const csrfToken = '<?= csrf_token() ?>';
        const csrfHash = '<?= csrf_hash() ?>';

        return fetch('<?= base_url('driver/update-delivery-status') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `job_id=${orderId}&order_id=${orderId}&status=${status}&${csrfToken}=${csrfHash}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateProgressSteps(status);
                return true;
            } else {
                throw new Error(data.message);
            }
        });
    }

    function updateProgressSteps(status) {
        const steps = document.querySelectorAll('.progress-step');
        let currentStepFound = false;

        steps.forEach(step => {
            step.classList.remove('active');
            if (!currentStepFound) {
                step.classList.add('completed');
            }

            if (
                (status === 'in_progress' && step.querySelector('.step-label').textContent === 'On the Way') ||
                (status === 'arrived' && step.querySelector('.step-label').textContent === 'Arrived') ||
                (status === 'delivered' && step.querySelector('.step-label').textContent === 'Delivered')
            ) {
                step.classList.add('active');
                step.classList.remove('completed');
                currentStepFound = true;
            }
        });
    }

    document.getElementById('startDelivery').addEventListener('click', function() {
        this.style.display = 'none';
        document.getElementById('arrivedAtLocation').style.display = 'block';
        startTracking();
        updateOrderStatus('in_progress');
    });

    document.getElementById('arrivedAtLocation').addEventListener('click', function() {
        this.style.display = 'none';
        document.getElementById('endDelivery').style.display = 'block';
        updateOrderStatus('arrived');
    });

    document.getElementById('endDelivery').addEventListener('click', function() {
        updateOrderStatus('delivered').then(() => {
            const modal = new bootstrap.Modal(document.getElementById('deliveryCompletedModal'));
            modal.show();
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 }
            });
        }).catch(error => {
            alert('Failed to update status: ' + error.message);
        });
    });

    document.getElementById('deliveryCompletedModal').addEventListener('hidden.bs.modal', function () {
        window.location.href = '<?= base_url('driver/dashboard') ?>';
    });

    // Initialize routing control
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(position.coords.latitude, position.coords.longitude),
                    L.latLng(lat, lng)
                ],
                routeWhileDragging: true
            }).addTo(map);

            routingControl.on('routesfound', function(e) {
                const routes = e.routes;
                const summary = routes[0].summary;
                document.getElementById('distance').textContent = `${(summary.totalDistance / 1000).toFixed(1)} km`;
                document.getElementById('estimatedTime').textContent = `${Math.round(summary.totalTime / 60)} mins`;
            });
        });
    }
});
</script>
<?= $this->endSection() ?>

