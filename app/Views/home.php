<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Add required CSS -->
<style>
.category-icon {
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}
.category-icon:hover {
    transform: translateY(-8px);
}

.product-card {
    position: relative;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.product-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(45deg, #00A67C, #00C4B4);
    border-radius: 12px;
    z-index: -1;
    opacity: 0;
    transform: scale(0.8);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.product-card:hover {
    transform: translateY(-5px);
}
.product-card:hover::before {
    opacity: 0.1;
    transform: scale(1);
}

.sale-badge {
    background: linear-gradient(45deg, #FF6B6B, #FF8E8E);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    color: white;
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 1;
}

.rating-stars {
    color: #FFB800;
    display: inline-flex;
    gap: 2px;
}

@keyframes floatAnimation {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.floating-image {
    animation: floatAnimation 3s ease-in-out infinite;
}

.section-fade {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.section-fade.visible {
    opacity: 1;
    transform: translateY(0);
}
</style>

<!-- Hero Section -->
<section class="position-relative overflow-hidden bg-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 pe-lg-5">
                <span class="badge bg-success-subtle text-success mb-3 px-3 py-2">
                    Trusted by 10,000+ Users
                </span>
                <h1 class="display-4 fw-bold mb-4" style="color: #00A67C">
                    Your Health Journey Starts Here
                </h1>
                <p class="lead mb-4 text-muted">
                    Find and compare medication prices from verified pharmacies near you
                </p>
                <div class="search-container bg-light p-3 rounded-4 mb-4">
                    <form action="<?= base_url('search') ?>" method="get" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-white">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-0 shadow-none" 
                                   placeholder="Search medications..."
                                   aria-label="Search medications">
                        </div>
                        <button class="btn btn-success px-4" type="submit">Search</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="<?= base_url('assets/images/banner.png') ?>" 
                         alt="Medicine Illustration" 
                         class="img-fluid floating-image">
                    <div class="position-absolute top-0 end-0 mt-4 me-4">
                        <div class="bg-white shadow-sm rounded-4 p-3 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-success-subtle p-2">
                                    <i class="bi bi-check2 text-success"></i>
                                </div>
                                <span class="fw-medium">Verified Pharmacies</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="mb-0">Browse Categories</h2>
            <a href="<?= base_url('categories') ?>" class="text-decoration-none text-success">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="row g-4 row-cols-2 row-cols-md-3 row-cols-lg-6">
            <?php
            $categories = [
                ['icon' => 'bi-capsule', 'name' => 'Prescription'],
                ['icon' => 'bi-heart-pulse', 'name' => 'Vitamins'],
                ['icon' => 'bi-shield-check', 'name' => 'Immunity'],
                ['icon' => 'bi-droplet', 'name' => 'Skincare'],
                ['icon' => 'bi-lightning', 'name' => 'Energy'],
                ['icon' => 'bi-moon', 'name' => 'Sleep']
            ];
            foreach ($categories as $category):
            ?>
            <div class="col">
                <a href="<?= base_url('category/' . strtolower($category['name'])) ?>" 
                   class="text-decoration-none">
                    <div class="category-icon bg-white rounded-4 p-4 text-center">
                        <i class="bi <?= $category['icon'] ?> fs-1 text-success mb-3"></i>
                        <h6 class="mb-0 text-dark"><?= $category['name'] ?></h6>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Flash Sale Section -->
<section class="py-5 section-fade">
    <div class="container">
        <div class="d-flex align-items-center gap-3 mb-4">
            <h2 class="mb-0">Flash Sale</h2>
            <div class="flash-timer d-flex align-items-center gap-2">
                <div class="bg-danger text-white rounded px-2 py-1">
                    <span class="fw-bold">12</span>h
                </div>
                <div class="bg-danger text-white rounded px-2 py-1">
                    <span class="fw-bold">45</span>m
                </div>
                <div class="bg-danger text-white rounded px-2 py-1">
                    <span class="fw-bold">30</span>s
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            <?php foreach ($featuredDrugs as $drug): ?>
            <div class="col-md-3">
                <div class="product-card bg-white rounded-4 p-3">
                    <span class="sale-badge">-20%</span>
                    <img src="<?= $drug['image_url'] ?>" 
                         class="img-fluid rounded-3 mb-3" 
                         alt="<?= $drug['name'] ?>">
                    <div class="rating-stars mb-2">
                        <?php for($i = 0; $i < 5; $i++): ?>
                            <i class="bi bi-star-fill"></i>
                        <?php endfor; ?>
                        <span class="text-muted ms-2">(4.8)</span>
                    </div>
                    <h5 class="mb-1"><?= $drug['name'] ?></h5>
                    <p class="text-muted small mb-2"><?= $drug['category'] ?></p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-decoration-line-through text-muted">
                                UGX <?= number_format($drug['price'] * 1.2, 2) ?>
                            </span>
                            <div class="fw-bold text-success">
                                UGX <?= number_format($drug['price'], 2) ?>
                            </div>
                        </div>
                        <button class="btn btn-success btn-sm rounded-circle">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Promotional Banners -->
<section class="py-5 bg-light section-fade">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="rounded-4 p-4" style="background: linear-gradient(45deg, #00A67C, #00C4B4);">
                    <div class="text-white mb-4">
                        <h3 class="fw-bold mb-2">30% Off</h3>
                        <p class="mb-0">On Your First Purchase</p>
                    </div>
                    <a href="#" class="btn btn-light">Shop Now</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="rounded-4 p-4 bg-primary">
                    <div class="text-white mb-4">
                        <h3 class="fw-bold mb-2">Weekend Sale</h3>
                        <p class="mb-0">Up to 50% off</p>
                    </div>
                    <a href="#" class="btn btn-light">Learn More</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="rounded-4 p-4" style="background: linear-gradient(45deg, #FF6B6B, #FF8E8E);">
                    <div class="text-white mb-4">
                        <h3 class="fw-bold mb-2">Free Delivery</h3>
                        <p class="mb-0">Orders above UGX 50,000</p>
                    </div>
                    <a href="#" class="btn btn-light">Order Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Best Sellers Section -->
<section class="py-5 section-fade">
    <div class="container">
        <h2 class="mb-4">Best Sellers</h2>
        <div class="row g-4">
            <?php foreach (array_slice($featuredDrugs, 0, 8) as $drug): ?>
            <div class="col-md-3">
                <div class="product-card bg-white rounded-4 p-3">
                    <img src="<?= $drug['image_url'] ?>" 
                         class="img-fluid rounded-3 mb-3" 
                         alt="<?= $drug['name'] ?>">
                    <div class="rating-stars mb-2">
                        <?php for($i = 0; $i < 5; $i++): ?>
                            <i class="bi bi-star-fill"></i>
                        <?php endfor; ?>
                        <span class="text-muted ms-2">(4.8)</span>
                    </div>
                    <h5 class="mb-1"><?= $drug['name'] ?></h5>
                    <p class="text-muted small mb-2"><?= $drug['category'] ?></p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="fw-bold text-success">
                            UGX <?= number_format($drug['price'], 2) ?>
                        </div>
                        <button class="btn btn-success btn-sm rounded-circle">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Latest Blog Posts -->
<section class="py-5 bg-light section-fade">
    <div class="container">
        <h2 class="mb-4">Latest Health Tips</h2>
        <div class="row g-4">
            <?php foreach ($blogPosts as $post): ?>
            <div class="col-md-3">
                <article class="bg-white rounded-4 overflow-hidden">
                    <img src="<?= $post['image_url'] ?>" 
                         class="img-fluid" 
                         alt="<?= $post['title'] ?>">
                    <div class="p-3">
                        <h5 class="mb-2"><?= $post['title'] ?></h5>
                        <p class="text-muted small mb-3">
                            <?= substr($post['content'], 0, 100) ?>...
                        </p>
                        <a href="<?= base_url('blog/' . $post['slug']) ?>" 
                           class="text-success text-decoration-none">
                            Read More <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5 section-fade">
    <div class="container">
        <h2 class="text-center mb-5">What Our Customers Say</h2>
        <div class="row g-4">
            <?php foreach (array_slice($testimonials, 0, 3) as $testimonial): ?>
            <div class="col-md-4">
                <div class="bg-white rounded-4 p-4">
                    <div class="rating-stars mb-3">
                        <?php for($i = 0; $i < 5; $i++): ?>
                            <i class="bi bi-star-fill"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="mb-4"><?= $testimonial['content'] ?></p>
                    <div class="d-flex align-items-center">
                        <img src="<?= $testimonial['user_image'] ?>" 
                             class="rounded-circle me-3" 
                             width="48" 
                             height="48" 
                             alt="<?= $testimonial['user_name'] ?>">
                        <div>
                            <h6 class="mb-1"><?= $testimonial['user_name'] ?></h6>
                            <p class="text-muted small mb-0">
                                <?= $testimonial['created_at'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="py-5 bg-success-subtle section-fade">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-6">
                <h2 class="mb-3">Stay Updated</h2>
                <p class="text-muted mb-4">
                    Subscribe to our newsletter for exclusive offers and health tips
                </p>
                <form class="d-flex gap-2">
                    <input type="email" 
                           class="form-control" 
                           placeholder="Enter your email">
                    <button type="submit" class="btn btn-success px-4">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->section('scripts') ?>
<!-- Intersection Observer for Animations -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.section-fade').forEach((section) => {
        observer.observe(section);
    });
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>