<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-5">
    <h1 class="mb-4">Pharmacies</h1>

    <!-- Search and Filter Form -->
    <form id="filterForm" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" id="search" class="form-control" placeholder="Search pharmacies...">
            </div>
            <div class="col-md-2">
                <select name="region" id="region" class="form-select">
                    <option value="">All Regions</option>
                    <?php foreach ($regions as $region): ?>
                        <option value="<?= $region['id'] ?>"><?= esc($region['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="rating" id="rating" class="form-select">
                    <option value="">Any Rating</option>
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?= $i ?>"><?= $i ?>+ Stars</option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="delivery" value="1" id="deliveryCheck">
                    <label class="form-check-label" for="deliveryCheck">
                        Delivery Available
                    </label>
                </div>
            </div>
        </div>
    </form>

    <!-- Pharmacies Grid -->
    <div id="pharmaciesGrid" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        <!-- Pharmacies will be loaded here -->
    </div>

    <!-- Pagination -->
    <div id="pagination" class="d-flex justify-content-center mt-4">
        <!-- Pagination links will be loaded here -->
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const pharmaciesGrid = document.getElementById('pharmaciesGrid');
    const paginationContainer = document.getElementById('pagination');

    function loadPharmacies(url = '<?= base_url('pharmacies') ?>') {
        const formData = new FormData(filterForm);
        const searchParams = new URLSearchParams(formData);

        fetch(`${url}?${searchParams.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            pharmaciesGrid.innerHTML = renderPharmacies(data.pharmacies);
            paginationContainer.innerHTML = data.pager;

            // Add event listeners to new pagination links
            paginationContainer.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    loadPharmacies(this.href);
                });
            });
        })
        .catch(error => console.error('Error:', error));
    }

    function renderPharmacies(pharmacies) {
        return pharmacies.map(pharmacy => `
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="${pharmacy.logo_url || '<?= base_url('assets/images/default-pharmacy.jpg') ?>'}" 
                         class="card-img-top" 
                         alt="${pharmacy.name}"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">${pharmacy.name}</h5>
                        <p class="card-text">
                            <i class="bi bi-geo-alt-fill text-primary"></i> ${pharmacy.address}
                        </p>
                        <p class="card-text">
                            <i class="bi bi-telephone-fill text-primary"></i> ${pharmacy.contact_number}
                        </p>
                        <p class="card-text">
                            <i class="bi bi-star-fill text-warning"></i> 
                            ${Number(pharmacy.rating).toFixed(1)} / 5.0
                        </p>
                        ${pharmacy.delivery_available ? `
                            <p class="card-text text-success">
                                <i class="bi bi-truck"></i> Delivery Available
                            </p>
                        ` : ''}
                    </div>
                    <div class="card-footer bg-white">
                        <a href="<?= base_url('pharmacy/') ?>${pharmacy.id}" class="btn btn-primary btn-sm">View Details</a>
                        ${pharmacy.premium_listing ? '<span class="badge bg-warning float-end">Premium</span>' : ''}
                    </div>
                </div>
            </div>
        `).join('');
    }

    // Initial load
    loadPharmacies();

    // Add event listeners for form inputs
    filterForm.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('change', () => loadPharmacies());
    });

    // Add debounce for search input
    const searchInput = document.getElementById('search');
    let debounceTimer;
    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => loadPharmacies(), 300);
    });
});
</script>
<?= $this->endSection() ?>

