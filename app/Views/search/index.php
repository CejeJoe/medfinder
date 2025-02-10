<?= $this->extend('layout/main') ?>

<?= $this->section('styles') ?>
<style>
/* Modern medical theme variables */
:root {
    --primary: #00B4B6;
    --primary-dark: #009B9E;
    --secondary: #2C3E50;
    --accent: #3498DB;
    --success: #27AE60;
    --danger: #E74C3C;
    --warning: #F1C40F;
    --light-bg: #F8FAFB;
    --border-color: #E5E9F2;
    --card-shadow: 0 2px 4px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.06);
    --hover-shadow: 0 4px 8px rgba(0,0,0,0.08), 0 8px 16px rgba(0,0,0,0.08);
}

/* Hero Section */
.search-hero {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    padding: 3rem 0;
    margin-bottom: 2rem;
}

.search-hero h1 {
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
}

.search-container {
    max-width: 800px;
    margin: 0 auto;
}

.search-input {
    border: none;
    border-radius: 50px;
    padding: 1rem 1.5rem;
    font-size: 1.1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Filters Panel */
.filters-panel {
    background: white;
    border-radius: 12px;
    box-shadow: var(--card-shadow);
    position: sticky;
    top: 2rem;
}

.filters-header {
    padding: 1.25rem;
    border-bottom: 1px solid var(--border-color);
}

.filters-body {
    padding: 1.25rem;
}

.filter-group {
    margin-bottom: 1.5rem;
}

.filter-group:last-child {
    margin-bottom: 0;
}

.filter-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--secondary);
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Results Section */
.results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.results-count {
    background: var(--light-bg);
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.9rem;
    color: var(--secondary);
}

.sort-select {
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

/* Medication Card */
.medication-card {
    background: white;
    border-radius: 12px;
    box-shadow: var(--card-shadow);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.medication-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--hover-shadow);
}

.card-image-wrapper {
    position: relative;
    padding-top: 100%;
    background: var(--light-bg);
    overflow: hidden;
}

.card-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 1rem;
    transition: transform 0.3s ease;
}

.medication-card:hover .card-image {
    transform: scale(1.05);
}

.stock-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 2;
}

.stock-badge.in-stock {
    background: var(--success);
    color: white;
}

.stock-badge.out-of-stock {
    background: var(--danger);
    color: white;
}

.price-tag {
    position: absolute;
    bottom: 1rem;
    left: 1rem;
    background: white;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    z-index: 2;
}

.action-buttons {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    z-index: 2;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.medication-card:hover .action-buttons {
    opacity: 1;
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: white;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.action-btn:hover {
    transform: scale(1.1);
    background: var(--light-bg);
}

.action-btn.favorite.active {
    color: var(--danger);
}

.card-content {
    padding: 1.25rem;
}

.medication-name {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--secondary);
}

.medication-category {
    font-size: 0.9rem;
    color: #64748B;
    margin-bottom: 0.5rem;
}

.pharmacy-info {
    font-size: 0.85rem;
    color: #64748B;
}

/* Toast Notifications */
.toast-container {
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 1050;
}

.toast {
    background: white;
    border-radius: 12px;
    box-shadow: var(--card-shadow);
    margin-bottom: 0.5rem;
}

/* Pagination */
.pagination {
    margin-top: 2rem;
    justify-content: center;
}

.page-link {
    border: none;
    padding: 0.75rem 1rem;
    margin: 0 0.25rem;
    border-radius: 8px;
    color: var(--secondary);
    transition: all 0.2s ease;
}

.page-link:hover {
    background: var(--light-bg);
    color: var(--primary);
}

.page-item.active .page-link {
    background: var(--primary);
    color: white;
}

/* Loading States */
.skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="search-hero">
    <div class="container">
        <h1>Find Your Medication</h1>
        <div class="search-container">
            <form action="<?= base_url('search') ?>" method="GET" class="d-flex gap-2">
                <input 
                    type="text" 
                    name="query" 
                    class="form-control search-input flex-grow-1" 
                    placeholder="Search for medications or pharmacies..." 
                    value="<?= esc($query ?? '') ?>"
                    autocomplete="off"
                >
                <button type="submit" class="btn btn-light px-4 rounded-pill">
                    <i class="bi bi-search me-2"></i>
                    Search
                </button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row g-4">
        <!-- Filters Panel -->
        <div class="col-lg-3">
            <div class="filters-panel">
                <div class="filters-header">
                    <h5 class="m-0">
                        <i class="bi bi-funnel me-2"></i>
                        Filters
                    </h5>
                </div>
                <div class="filters-body">
                    <form id="filterForm" action="<?= base_url('search') ?>" method="GET">
                        <!-- Category Filter -->
                        <div class="filter-group">
                            <h6 class="filter-title">Category</h6>
                            <?php foreach ($categories as $category): ?>
                            <div class="form-check mb-2">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input" 
                                    name="category" 
                                    value="<?= $category ?>"
                                    id="category-<?= $category ?>"
                                    <?= ($selectedCategory ?? '') == $category ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="category-<?= $category ?>">
                                    <?= esc($category) ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="filter-group">
                            <h6 class="filter-title">Price Range</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        name="min_price" 
                                        placeholder="Min"
                                        value="<?= esc($minPrice ?? '') ?>"
                                    >
                                </div>
                                <div class="col-6">
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        name="max_price" 
                                        placeholder="Max"
                                        value="<?= esc($maxPrice ?? '') ?>"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Availability Filter -->
                        <div class="filter-group">
                            <h6 class="filter-title">Availability</h6>
                            <div class="form-check mb-2">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input" 
                                    name="in_stock" 
                                    id="in-stock"
                                    value="1"
                                    <?= isset($inStock) && $inStock ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="in-stock">
                                    In Stock Only
                                </label>
                            </div>
                        </div>

                        <!-- Location Filter -->
                        <div class="filter-group">
                            <h6 class="filter-title">Location</h6>
                            <select name="location" class="form-select">
                                <option value="">All Locations</option>
                                <?php foreach ($locations as $location): ?>
                                <option 
                                    value="<?= $location ?>"
                                    <?= ($selectedLocation ?? '') == $location ? 'selected' : '' ?>
                                >
                                    <?= esc($location) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Pharmacy Filter -->
                        <div class="filter-group">
                            <h6 class="filter-title">Pharmacy</h6>
                            <?php foreach ($pharmacies as $pharmacy): ?>
                            <div class="form-check mb-2">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input" 
                                    name="pharmacy" 
                                    value="<?= $pharmacy ?>"
                                    id="pharmacy-<?= $pharmacy ?>"
                                    <?= ($selectedPharmacy ?? '') == $pharmacy ? 'checked' : '' ?>
                                >
                                <label class="form-check-label" for="pharmacy-<?= $pharmacy ?>">
                                    <?= esc($pharmacy) ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Apply Filters
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="col-lg-9">
            <?php if (isset($results) && count($results) > 0): ?>
                <div class="results-header">
                    <div class="d-flex align-items-center gap-3">
                        <h2 class="h5 m-0">Search Results</h2>
                        <span class="results-count">
                            <?= number_format($totalResults) ?> items found
                        </span>
                    </div>
                    <select class="sort-select" id="sortSelect">
                        <option value="relevance" <?= ($sort ?? '') == 'relevance' ? 'selected' : '' ?>>
                            Most Relevant
                        </option>
                        <option value="price_asc" <?= ($sort ?? '') == 'price_asc' ? 'selected' : '' ?>>
                            Price: Low to High
                        </option>
                        <option value="price_desc" <?= ($sort ?? '') == 'price_desc' ? 'selected' : '' ?>>
                            Price: High to Low
                        </option>
                        <option value="name_asc" <?= ($sort ?? '') == 'name_asc' ? 'selected' : '' ?>>
                            Name: A to Z
                        </option>
                        <option value="name_desc" <?= ($sort ?? '') == 'name_desc' ? 'selected' : '' ?>>
                            Name: Z to A
                        </option>
                    </select>
                </div>

                <div class="row g-4">
                    <?php foreach ($results as $medication): ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="<?= base_url('drug/' . $medication['id']) ?>" class="text-decoration-none">
                            <div class="medication-card">
                                <div class="card-image-wrapper">
                                    <img 
                                        src="<?= base_url($medication['image_url']) ?>" 
                                        alt="<?= esc($medication['drug_name']) ?>"
                                        class="card-image"
                                    >
                                    <span class="stock-badge <?= $medication['stock'] > 0 ? 'in-stock' : 'out-of-stock' ?>">
                                        <?= $medication['stock'] > 0 ? 'In Stock' : 'Out of Stock' ?>
                                    </span>
                                    <div class="price-tag">
                                        UGX <?= number_format($medication['price'], 2) ?>
                                    </div>
                                    <div class="action-buttons">
                                        <button 
                                            type="button"
                                            class="action-btn add-to-cart"
                                            data-id="<?= $medication['id'] ?>"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="left"
                                            title="Add to Cart"
                                            <?= $medication['stock'] <= 0 ? 'disabled' : '' ?>
                                        >
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                        <button 
                                            type="button"
                                            class="action-btn favorite <?= in_array($medication['id'], $favorites ?? []) ? 'active' : '' ?>"
                                            data-id="<?= $medication['id'] ?>"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="left"
                                            title="Add to Favorites"
                                        >
                                            <i class="bi bi-heart<?= in_array($medication['id'], $favorites ?? []) ? '-fill' : '' ?>"></i>
                                        </button>
                                        <button 
                                            type="button"
                                            class="action-btn compare"
                                            data-id="<?= $medication['id'] ?>"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="left"
                                            title="Compare"
                                        >
                                            <i class="bi bi-arrow-left-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <h3 class="medication-name">
                                        <?= esc($medication['drug_name']) ?>
                                    </h3>
                                    <p class="medication-category">
                                        <i class="bi bi-tag me-1"></i>
                                        <?= esc($medication['category']) ?>
                                    </p>
                                    <div class="pharmacy-info">
                                        <p class="mb-1">
                                            <i class="bi bi-shop me-1"></i>
                                            <?= esc($medication['pharmacy_name']) ?>
                                        </p>
                                        <p class="mb-0">
                                            <i class="bi bi-geo-alt me-1"></i>
                                            
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($pager): ?>
                <div class="pagination">
                    <?= $pager->links() ?>
                </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <div>
                        No medications found matching your criteria. Try adjusting your filters or search terms.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Toast Container for Notifications -->
<div class="toast-container"></div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltips.forEach(function (tooltip) {
        new bootstrap.Tooltip(tooltip)
    })

    // Add to cart functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault()
            const id = this.dataset.id

            try {
                const response = await fetch('<?= base_url('cart/add') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    },
                    body: JSON.stringify({ id: id })
                })

                const data = await response.json()

                if (data.success) {
                    showToast('Success', 'Item added to cart successfully!', 'success')
                    
                    // Update cart count in header if it exists
                    const cartCount = document.querySelector('#cartCount')
                    if (cartCount) {
                        cartCount.textContent = data.cartCount
                        cartCount.classList.add('bounce')
                        setTimeout(() => cartCount.classList.remove('bounce'), 1000)
                    }
                } else {
                    showToast('Error', data.message || 'Failed to add item to cart', 'danger')
                }
            } catch (error) {
                showToast('Error', 'An error occurred. Please try again.', 'danger')
            }
        })
    })

    // Favorite functionality
    document.querySelectorAll('.favorite').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault()
            const id = this.dataset.id

            try {
                const response = await fetch('<?= base_url('favorites/toggle') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    },
                    body: JSON.stringify({ id: id })
                })

                const data = await response.json()

                if (data.success) {
                    this.classList.toggle('active')
                    const icon = this.querySelector('i')
                    icon.classList.toggle('bi-heart')
                    icon.classList.toggle('bi-heart-fill')
                    showToast('Success', data.message, 'success')
                } else {
                    showToast('Error', data.message || 'Failed to update favorites', 'danger')
                }
            } catch (error) {
                showToast('Error', 'An error occurred. Please try again.', 'danger')
            }
        })
    })

    // Compare functionality
    document.querySelectorAll('.compare').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault()
            const id = this.dataset.id

            try {
                const response = await fetch('<?= base_url('compare/add') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    },
                    body: JSON.stringify({ id: id })
                })

                const data = await response.json()

                if (data.success) {
                    showToast('Success', 'Item added to comparison list!', 'success')
                    this.classList.add('active')
                } else {
                    showToast('Error', data.message || 'Failed to add item to comparison', 'danger')
                }
            } catch (error) {
                showToast('Error', 'An error occurred. Please try again.', 'danger')
            }
        })
    })

    // Sort functionality
    const sortSelect = document.getElementById('sortSelect')
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const currentUrl = new URL(window.location.href)
            currentUrl.searchParams.set('sort', this.value)
            window.location.href = currentUrl.toString()
        })
    }

    // Filter form submission
    const filterForm = document.getElementById('filterForm')
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault()
            const formData = new FormData(this)
            const params = new URLSearchParams(formData)
            const currentUrl = new URL(window.location.href)
            
            // Preserve the search query if it exists
            const searchQuery = currentUrl.searchParams.get('query')
            if (searchQuery) {
                params.set('query', searchQuery)
            }

            window.location.href = `${this.action}?${params.toString()}`
        })
    }

    // Toast notification function
    function showToast(title, message, type = 'info') {
        const toastContainer = document.querySelector('.toast-container')
        const toastHtml = `
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2 text-${type}"></i>
                    <strong class="me-auto">${title}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `
        
        const toastElement = document.createElement('div')
        toastElement.innerHTML = toastHtml
        const toast = toastElement.firstChild
        toastContainer.appendChild(toast)
        
        const bsToast = new bootstrap.Toast(toast, {
            autohide: true,
            delay: 3000
        })
        
        bsToast.show()
        
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove()
        })
    }
})
</script>
<?= $this->endSection() ?>

