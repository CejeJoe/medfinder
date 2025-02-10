<?= $this->extend('layout/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<style>
    #map { height: 400px; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Track Your Delivery</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order #<?= $order['id'] ?></h5>
                    <p><strong>Status:</strong> <span id="deliveryStatus"><?= $delivery['status'] ?></span></p>
                    <p><strong>Estimated Arrival:</strong> <span id="estimatedArrival">Calculating...</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div id="map"></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
<script>
    const deliveryId = <?= $delivery['id'] ?>;
    const initialLat = <?= $delivery['current_latitude'] ?>;
    const initialLng = <?= $delivery['current_longitude'] ?>;
    const destinationLat = <?= $order['delivery_latitude'] ?>;
    const destinationLng = <?= $order['delivery_longitude'] ?>;

    // Initialize map
    const map = L.map('map').setView([initialLat, initialLng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add markers
    const driverMarker = L.marker([initialLat, initialLng]).addTo(map);
    const destinationMarker = L.marker([destinationLat, destinationLng]).addTo(map);

    // Connect to WebSocket server
    const socket = io('<?= base_url() ?>:3000');

    socket.on('locationUpdate', function(data) {
        if (data.deliveryId === deliveryId) {
            updateDriverLocation(data.latitude, data.longitude);
        }
    });

    function updateDriverLocation(lat, lng) {
        driverMarker.setLatLng([lat, lng]);
        map.panTo([lat, lng]);
        updateETA(lat, lng);
    }

    function updateETA(lat, lng) {
        fetch(`https://api.openrouteservice.org/v2/directions/driving-car?api_key=YOUR_API_KEY&start=${lng},${lat}&end=${destinationLng},${destinationLat}`)
            .then(response => response.json())
            .then(data => {
                const duration = Math.round(data.features[0].properties.segments[0].duration / 60);
                document.getElementById('estimatedArrival').textContent = `${duration} minutes`;
            })
            .catch(error => console.error('Error:', error));
    }

    // Initial ETA calculation
    updateETA(initialLat, initialLng);

    // Periodically update delivery status
    setInterval(() => {
        fetch(`<?= base_url('delivery/status') ?>/${deliveryId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('deliveryStatus').textContent = data.status;
            })
            .catch(error => console.error('Error:', error));
    }, 30000); // Every 30 seconds
</script>
<?= $this->endSection() ?>

