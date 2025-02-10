<?= $this->extend('layout/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
<style>
:root {
    --primary-blue: #00B4B6;
    --secondary-blue: #0891B2;
    --text-dark: #1E293B;
    --text-light: #64748B;
    --border-color: #E2E8F0;
    --bg-light: #F8FAFC;
}

.product-section {
    padding: 3rem 0;
    background: var(--bg-light);
}

.product-gallery {
    position: sticky;
    top: 2rem;
}

.product-main-image {
    border-radius: 1rem;
    overflow: hidden;
    background: white;
    padding: 2rem;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    margin-bottom: 1rem;
}

.product-main-image img {
    width: 100%;
    height: auto;
    object-fit: contain;
    aspect-ratio: 1;
}

.product-thumbnails {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.thumbnail {
    width: 80px;
    height: 80px;
    border-radius: 0.5rem;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid var(--border-color);
    padding: 0.5rem;
    background: white;
    transition: all 0.3s ease;
}

.thumbnail:hover {
    border-color: var(--primary-blue);
}

.thumbnail.active {
    border-color: var(--primary-blue);
}

.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.product-info {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
}

.product-title {
    font-size: 2rem;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.manufacturer-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-light);
    margin-bottom: 1.5rem;
}

.price-section {
    background: var(--bg-light);
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin: 1.5rem 0;
}

.price {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-blue);
}

.stock-status {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-weight: 500;
    font-size: 0.875rem;
}

.stock-status.in-stock {
    background: #DEF7EC;
    color: #03543F;
}

.stock-status.out-of-stock {
    background: #FDE8E8;
    color: #9B1C1C;
}

.pharmacy-list {
    margin-top: 2rem;
}

.pharmacy-card {
    padding: 1rem;
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.pharmacy-card:hover {
    border-color: var(--primary-blue);
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
}

.product-tabs {
    margin-top: 3rem;
}

.nav-tabs {
    border: none;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.nav-tabs .nav-link {
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    color: var(--text-light);
    background: var(--bg-light);
}

.nav-tabs .nav-link.active {
    background: var(--primary-blue);
    color: white;
}

.tab-content {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
}

.tab-pane h3 {
    color: var(--text-dark);
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.info-card {
    background: var(--bg-light);
    padding: 1.5rem;
    border-radius: 0.5rem;
}

.info-card h4 {
    font-size: 1rem;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.info-card p {
    color: var(--text-light);
    margin: 0;
    font-size: 0.875rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.btn-primary {
    background: var(--primary-blue);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: var(--secondary-blue);
    transform: translateY(-2px);
}

.btn-outline {
    border: 2px solid var(--primary-blue);
    color: var(--primary-blue);
    background: transparent;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline:hover {
    background: var(--primary-blue);
    color: white;
}

.features-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.feature-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--bg-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-blue);
}

.feature-text {
    font-size: 0.875rem;
    color: var(--text-light);
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="product-section">
    <div class="container">
        <div class="row g-4">
            <!-- Product Gallery -->
            <div class="col-lg-5">
                <div class="product-gallery">
                    <div class="product-main-image">
                        <a href="<?= base_url($drug['image_url']) ?>" data-fancybox="gallery">
                            <img src="<?= base_url($drug['image_url']) ?>" alt="<?= esc($drug['name']) ?>">
                        </a>
                    </div>
                    <?php if (!empty($drug['additional_images'])): ?>
                    <div class="product-thumbnails">
                        <?php foreach (json_decode($drug['additional_images']) as $index => $image): ?>
                        <div class="thumbnail <?= $index === 0 ? 'active' : '' ?>">
                            <img src="<?= base_url($image) ?>" alt="<?= esc($drug['name']) ?> view <?= $index + 1 ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-7">
                <div class="product-info">
                    <h1 class="product-title"><?= esc($drug['name']) ?></h1>
                    
                    <div class="manufacturer-info">
                        <i class="fas fa-industry"></i>
                        <span>Manufactured by <?= esc($drug['manufacturer_name']) ?> in <?= esc($drug['manufacturer_country']) ?></span>
                    </div>

                    <div class="price-section">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="price">UGX <?= number_format($drug['price'], 2) ?></div>
                            <div class="stock-status <?= $drug['stock'] > 0 ? 'in-stock' : 'out-of-stock' ?>">
                                <?= $drug['stock'] > 0 ? 'In Stock' : 'Out of Stock' ?>
                            </div>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn btn-primary" <?= $drug['stock'] <= 0 ? 'disabled' : '' ?>>
                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                        </button>
                        <button class="btn btn-outline">
                            <i class="fas fa-heart me-2"></i>Add to Wishlist
                        </button>
                    </div>

                    <div class="features-list">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="feature-text">
                                Genuine Product
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="feature-text">
                                Fast Delivery
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="feature-text">Quality Assured</div>
                        </div>
                    </div>

                    <div class="pharmacy-list">
                        <h3>Available at Pharmacies</h3>
                        <?php foreach ($pharmacies as $pharmacy): ?>
                        <div class="pharmacy-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-1"><?= esc($pharmacy['pharmacy_name']) ?></h4>
                                    <p class="mb-0 text-muted"><?= esc($pharmacy['address']) ?></p>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-primary">UGX <?= number_format($pharmacy['price'], 2) ?></div>
                                    <small class="text-muted"><?= $pharmacy['stock'] ?> in stock</small>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="product-tabs">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab">
                        Description
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="indications-tab" data-bs-toggle="tab" href="#indications" role="tab">
                        Indications
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="dosage-tab" data-bs-toggle="tab" href="#dosage" role="tab">
                        Dosage
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="side-effects-tab" data-bs-toggle="tab" href="#side-effects" role="tab">
                        Side Effects
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <h3>Product Description</h3>
                    <p><?= nl2br(esc($drug['description'])) ?></p>
                    
                    <div class="info-grid">
                        <div class="info-card">
                            <h4>Storage</h4>
                            <p><?= esc($drug['storage_conditions']) ?></p>
                        </div>
                        <div class="info-card">
                            <h4>Shelf Life</h4>
                            <p><?= esc($drug['shelf_life']) ?></p>
                        </div>
                        <div class="info-card">
                            <h4>Category</h4>
                            <p><?= esc($drug['category']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="indications" role="tabpanel">
                    <h3>Indications</h3>
                    <p><?= nl2br(esc($drug['indications'])) ?></p>
                </div>

                <div class="tab-pane fade" id="dosage" role="tabpanel">
                    <h3>Dosage & Administration</h3>
                    <p><?= nl2br(esc($drug['dosage_administration'])) ?></p>
                </div>

                <div class="tab-pane fade" id="side-effects" role="tabpanel">
                    <h3>Side Effects</h3>
                    <p><?= nl2br(esc($drug['side_effects'])) ?></p>
                    
                    <h3 class="mt-4">Contraindications</h3>
                    <p><?= nl2br(esc($drug['contraindications'])) ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Fancybox
    Fancybox.bind('[data-fancybox]', {
        // Your custom options
    });

    // Thumbnail click handling
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.addEventListener('click', function() {
            // Remove active class from all thumbnails
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            // Add active class to clicked thumbnail
            this.classList.add('active');
            // Update main image
            const mainImage = document.querySelector('.product-main-image img');
            const newSrc = this.querySelector('img').src;
            mainImage.src = newSrc;
        });
    });

    // Add to cart functionality
    document.querySelector('.btn-primary').addEventListener('click', async function() {
        if (this.disabled) return;

        try {
            const response = await fetch('<?= base_url('cart/add') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                },
                body: JSON.stringify({
                    drug_id: <?= $drug['id'] ?>,
                    quantity: 1
                })
            });

            const data = await response.json();

            if (data.success) {
                // Show success message
                alert('Added to cart successfully!');
                // Update cart count in header if it exists
                const cartCount = document.querySelector('#cartCount');
                if (cartCount) {
                    cartCount.textContent = data.cartCount;
                }
            } else {
                alert(data.message || 'Failed to add to cart');
            }
        } catch (error) {
            alert('An error occurred. Please try again.');
        }
    });
});
</script>
<?= $this->endSection() ?>

