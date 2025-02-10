<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4">Search Results</h1>
    <div class="row">
        <div class="col-md-3">
            <h3>Filters</h3>
            <form id="filterForm">
                <!-- Add filter options here (similar to the search form) -->
            </form>
        </div>
        <div class="col-md-9">
            <div id="searchResults">
                <?php if (empty($results)): ?>
                    <p>No results found.</p>
                <?php else: ?>
                    <?php foreach ($results as $result): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?= $result['drug_name'] ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= $result['pharmacy_name'] ?></h6>
                                <p class="card-text">
                                    Price: $<?= number_format($result['price'], 2) ?><br>
                                    Category: <?= $result['category'] ?><br>
                                    Rating: <?= $result['rating'] ?> stars<br>
                                    Availability: <?//= $result['in_stock'] ? 'In Stock' : 'Out of Stock' ?>
                                </p>
                                <a href="<?= base_url('pharmacy/' . $result['pharmacy_id']) ?>" class="card-link">View Pharmacy</a>
                                <a href="<?= base_url('drug/' . $result['drug_id']) ?>" class="card-link">View Drug</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->section('scripts') ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        updateResults();
    });

    function updateResults() {
        const formData = new FormData(filterForm);
        fetch('<?= base_url('search/results') ?>?' + new URLSearchParams(formData))
            .then(response => response.json())
            .then(data => {
                const resultsContainer = document.getElementById('searchResults');
                resultsContainer.innerHTML = '';
                data.forEach(result => {
                    // Create and append result cards similar to the PHP foreach loop above
                });
            });
    }
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>

