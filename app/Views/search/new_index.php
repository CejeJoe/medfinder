<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4">Advanced Search</h1>
    <form action="<?= base_url('search/results') ?>" method="get" id="searchForm">
        <div class="row">
            <div class="col-md-8 mb-3">
                <input type="text" name="query" id="query" class="form-control form-control-lg" placeholder="Search for medications..." autocomplete="off">
                <div id="suggestions" class="list-group mt-2 d-none"></div>
            </div>
            <div class="col-md-4 mb-3">
                <button type="submit" class="btn btn-primary btn-lg btn-block">Search</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3">
                <select name="category" class="form-control">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category ?>"><?= $category ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <input type="number" name="min_price" class="form-control" placeholder="Min Price">
            </div>
            <div class="col-md-3 mb-3">
                <input type="number" name="max_price" class="form-control" placeholder="Max Price">
            </div>
            <div class="col-md-3 mb-3">
                <select name="region" class="form-control">
                    <option value="">All Regions</option>
                    <?php foreach ($regions as $region): ?>
                        <option value="<?= $region ?>"><?= $region ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3">
                <select name="rating" class="form-control">
                    <option value="">Any Rating</option>
                    <option value="4">4+ Stars</option>
                    <option value="3">3+ Stars</option>
                    <option value="2">2+ Stars</option>
                    <option value="1">1+ Star</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <select name="availability" class="form-control">
                    <option value="">Any Availability</option>
                    <option value="in_stock">In Stock</option>
                    <option value="out_of_stock">Out of Stock</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <select name="sort" class="form-control">
                    <option value="relevance">Sort by Relevance</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                    <option value="rating">Highest Rated</option>
                </select>
            </div>
        </div>
    </form>
</div>
<?= $this->section('scripts')?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const queryInput = document.getElementById('query');
    const suggestionsContainer = document.getElementById('suggestions');

    queryInput.addEventListener('input', function() {
        if (this.value.length > 2) {
            fetch(`<?= base_url('search/autocomplete') ?>?query=${this.value}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsContainer.innerHTML = '';
                    data.forEach(suggestion => {
                        const item = document.createElement('a');
                        item.href = '#';
                        item.classList.add('list-group-item', 'list-group-item-action');
                        item.textContent = suggestion;
                        item.addEventListener('click', function(e) {
                            e.preventDefault();
                            queryInput.value = this.textContent;
                            suggestionsContainer.classList.add('d-none');
                        });
                        suggestionsContainer.appendChild(item);
                    });
                    suggestionsContainer.classList.remove('d-none');
                });
        } else {
            suggestionsContainer.classList.add('d-none');
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target !== queryInput && e.target !== suggestionsContainer) {
            suggestionsContainer.classList.add('d-none');
        }
    });
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>

