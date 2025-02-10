<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?><?= $pharmacy['name'] ?><?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
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
.pharmacy-hero {
    background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
    padding: 4rem 0;
    color: white;
    position: relative;
    overflow: hidden;
}

.pharmacy-hero::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='rgba(255,255,255,0.1)' fill-rule='evenodd'/%3E%3C/svg%3E");
    opacity: 0.1;
}

.pharmacy-logo {
    width: 120px;
    height: 120px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Cards and Sections */
.info-card {
    background: white;
    border-radius: 12px;
    box-shadow: var(--card-shadow);
    transition: all 0.3s ease;
    height: 100%;
}

.info-card:hover {
    box-shadow: var(--hover-shadow);
}

.service-icon {
    width: 48px;
    height: 48px;
    background: var(--light-bg);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    margin-bottom: 1rem;
}

/* Product Cards */
.product-card {
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--hover-shadow);
}

.product-image {
    height: 200px;
    object-fit: cover;
}

.stock-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
}

/* Reviews */
.review-card {
    border: none;
    border-radius: 12px;
    box-shadow: var(--card-shadow);
    transition: all 0.3s ease;
}

.review-card:hover {
    box-shadow: var(--hover-shadow);
}

.star-rating {
    color: var(--warning);
}

/* Facilities */
.facility-icon {
    width: 32px;
    height: 32px;
    background: var(--light-bg);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    margin-right: 1rem;
}

/* Map */
.map-container {
    height: 400px;
    border-radius: 12px;
    overflow: hidden;
}

/* Responsive Design */
@media (max-width: 768px) {
    .pharmacy-hero {
        padding: 2rem 0;
    }

    .pharmacy-logo {
        width: 80px;
        height: 80px;
    }

    .map-container {
        height: 300px;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="pharmacy-profile">
    <!-- Hero Section -->
    <div class="pharmacy-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 text-center">
                    <div class="pharmacy-logo mb-3">
                        <img 
                            src="<?= base_url($pharmacy['logo'] ?? 'assets/images/pharmacy-default.png') ?>" 
                            alt="<?= $pharmacy['name'] ?>"
                            class="img-fluid"
                            width="80"
                            height="80"
                        >
                    </div>
                </div>
                <div class="col-lg-7">
                    <h1 class="display-4 mb-2"><?= $pharmacy['name'] ?></h1>
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-4">
                            <div class="star-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star<?= $i <= round($averageRating) ? '' : '-o' ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="text-white-50"><?= number_format($averageRating, 1) ?> (<?= count($reviews) ?> reviews)</span>
                        </div>
                        <?php if ($pharmacy['is_active']): ?>
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i> Verified
                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <?= $pharmacy['address'] ?>
                    </p>
                </div>
                <div class="col-lg-3 text-center text-lg-end mt-4 mt-lg-0">
                    <div class="d-flex flex-column gap-2">
                        <?php if ($pharmacy['delivery_available']): ?>
                            <span class="badge bg-success p-2">
                                <i class="fas fa-truck me-1"></i> Delivery Available
                            </span>
                        <?php endif; ?>
                        <a href="tel:<?= $pharmacy['contact_number'] ?>" class="btn btn-light">
                            <i class="fas fa-phone me-2"></i> Call Now
                        </a>
                        <button class="btn btn-outline-light" onclick="showDirections()">
                            <i class="fas fa-directions me-2"></i> Get Directions
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <!-- Quick Info Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="info-card p-4">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-clock text-primary me-2"></i>
                        Working Hours
                    </h5>
                    <?php foreach ($workingHours as $day => $hours): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?= $day ?></span>
                            <span><?= $hours['open'] ?> - <?= $hours['close'] ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card p-4">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Services
                    </h5>
                    <?php foreach ($services as $service): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="service-icon">
                                <i class="fas fa-<?= $service['icon'] ?>"></i>
                            </div>
                            <div>
                                <h6 class="mb-0"><?= $service['name'] ?></h6>
                                <small class="text-muted"><?= $service['description'] ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card p-4">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-certificate text-primary me-2"></i>
                        Certifications & Facilities
                    </h5>
                    <?php foreach ($certifications as $cert): ?>
                        <div class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <?= $cert['name'] ?>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="facilities mt-3">
                        <?php foreach ($facilities as $key => $available): ?>
                            <?php if ($available): ?>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="facility-icon">
                                        <i class="fas fa-<?= str_replace('_', '-', $key) ?>"></i>
                                    </div>
                                    <span><?= ucwords(str_replace('_', ' ', $key)) ?></span>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Available Products</h4>
                        <div class="d-flex gap-2">
                            <select class="form-select" id="categoryFilter">
                                <option value="">All Categories</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category ?>"><?= $category ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group" style="width: 200px;">
                                <input type="text" class="form-control" id="searchProducts" placeholder="Search...">
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4" id="productsContainer">
                            <?php foreach ($drugs as $drug): ?>
                                <div class="col-md-6 col-lg-4" data-category="<?= $drug['category'] ?>">
                                    <div class="product-card">
                                        <div class="position-relative">
                                            <img 
                                                src="<?= base_url($drug['drug']['image_url'] ?? 'assets/images/placeholder.jpg') ?>" 
                                                class="product-image w-100" 
                                                alt="<?= $drug['drug']['name'] ?>"
                                            >
                                            <span class="stock-badge <?= $drug['stock'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                                <?= $drug['stock'] > 0 ? 'In Stock' : 'Out of Stock' ?>
                                            </span>
                                            <?php if ($drug['discount'] > 0): ?>
                                                <span class="badge bg-danger position-absolute top-0 start-0 m-3">
                                                    <?= $drug['discount'] ?>% OFF
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title mb-1"><?= $drug['drug']['name'] ?></h5>
                                            <p class="text-muted small mb-2"><?= $drug['category'] ?></p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <?php if ($drug['discount'] > 0): ?>
                                                        <small class="text-decoration-line-through text-muted">
                                                            UGX <?= number_format($drug['price']) ?>
                                                        </small>
                                                        <br>
                                                    <?php endif; ?>
                                                    <span class="text-primary fw-bold">
                                                        UGX <?= number_format($drug['price'] * (1 - $drug['discount']/100)) ?>
                                                    </span>
                                                </div>
                                                <button 
                                                    class="btn btn-primary btn-sm add-to-cart"
                                                    data-id="<?= $drug['drug']['id'] ?>"
                                                    data-name="<?= $drug['drug']['name'] ?>"
                                                    data-price="<?= $drug['price'] * (1 - $drug['discount']/100) ?>"
                                                    <?= $drug['stock'] <= 0 ? 'disabled' : '' ?>
                                                >
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map and Reviews Section -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Location & Directions</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="map-container">
                            <iframe
                                width="100%"
                                height="100%"
                                frameborder="0"
                                style="border:0"
                                src="https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY&q=<?= urlencode($pharmacy['address']) ?>"
                                allowfullscreen
                            ></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Customer Reviews</h4>
                        <a href="<?= base_url('reviews/create/' . $pharmacy['id']) ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-pen me-2"></i>Write a Review
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($reviews)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-comments text-muted fa-3x mb-3"></i>
                                <p class="mb-0">No reviews yet. Be the first to review this pharmacy!</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($reviews as $review): ?>
                                <div class="review-card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center">
                                                <img 
                                                    src="<?= base_url($review['user_avatar'] ?? 'assets/images/default-avatar.png') ?>" 
                                                    class="rounded-circle me-2"
                                                    width="40"
                                                    height="40"
                                                    alt="<?= $review['username'] ?>"
                                                >
                                                <div>
                                                    <h6 class="mb-0"><?= $review['username'] ?></h6>
                                                    <small class="text-muted">
                                                        <?= date('F j, Y', strtotime($review['created_at'])) ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="star-rating">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fas fa-star<?= $i <= $review['rating'] ? '' : '-o' ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <p class="mb-0"><?= nl2br(esc($review['comment'])) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-info-circle me-2"></i>
            <strong class="me-auto">Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltips.forEach(function (tooltip) {
        new bootstrap.Tooltip(tooltip)
    })

    // Toast initialization
    const toast = new bootstrap.Toast(document.getElementById('liveToast'))

    // Add to cart functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', async function() {
            const drugId = this.dataset.id;
            const drugName = this.dataset.name;
            const price = this.dataset.price;

            try {
                const response = await fetch('<?= base_url('cart/add') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                    },
                    body: JSON.stringify({ id: drugId, name: drugName, price: price })
                });

                const data = await response.json();

                if (data.success) {
                    // Update cart count
                    const cartCount = document.querySelector('#cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.cartCount;
                        cartCount.classList.add('bounce');
                        setTimeout(() => cartCount.classList.remove('bounce'), 1000);
                    }

                    // Update button state
                    this.innerHTML = '<i class="fas fa-check"></i>';
                    this.disabled = true;
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-success');

                    // Show success toast
                    document.querySelector('#liveToast .toast-body').textContent = 'Item added to cart successfully!';
                    toast.show();
                } else {
                    // Show error toast
                    document.querySelector('#liveToast .toast-body').textContent = data.message || 'Failed to add item to cart';
                    toast.show();
                }
            } catch (error) {
                console.error('Error:', error);
                document.querySelector('#liveToast .toast-body').textContent = 'An error occurred. Please try again.';
                toast.show();
            }
        });
    });

    // Product filtering functionality
    const categoryFilter = document.getElementById('categoryFilter');
    const searchInput = document.getElementById('searchProducts');
    const productsContainer = document.getElementById('productsContainer');

    function filterProducts() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;

        document.querySelectorAll('#productsContainer > div').forEach(product => {
            const productName = product.querySelector('.card-title').textContent.toLowerCase();
            const productCategory = product.dataset.category;
            
            const matchesSearch = productName.includes(searchTerm);
            const matchesCategory = !selectedCategory || productCategory === selectedCategory;

            product.style.display = matchesSearch && matchesCategory ? 'block' : 'none';
        });
    }

    categoryFilter.addEventListener('change', filterProducts);
    searchInput.addEventListener('input', filterProducts);

    // Map functionality
    window.showDirections = function() {
        const address = '<?= urlencode($pharmacy['address']) ?>';
        window.open(`https://www.google.com/maps/dir/?api=1&destination=${address}`, '_blank');
    }
});
</script>
<?= $this->endSection() ?>

