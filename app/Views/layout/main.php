<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - MedFinder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
    <style>
    :root {
        --primary-color: #00A67C;
        --secondary-color: #00C4B4;
        --accent-color: #FF6B6B;
        --background-light: #F5F7FA;
    }

    .navbar {
        background: white;
        padding: 1rem 0;
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
    }

    .navbar-brand {
        color: var(--primary-color) !important;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .nav-link {
        color: #2D3436 !important;
        font-weight: 500;
        transition: color 0.3s ease;
        position: relative;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--primary-color);
        transition: width 0.3s ease;
    }

    .nav-link:hover::after,
    .nav-link.active::after {
        width: 100%;
    }

    .search-form {
        position: relative;
    }

    .search-form .form-control {
        padding-left: 2.5rem;
        border-radius: 50px;
        border: 2px solid #E8E8E8;
        transition: all 0.3s ease;
    }

    .search-form .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: none;
    }

    .search-form i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #A0A0A0;
    }

    .btn-primary {
        background: var(--primary-color);
        border: none;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        transition: transform 0.3s ease;
    }

    .btn-primary:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
    }

    .cart-icon {
        position: relative;
        font-size: 1.25rem;
        color: #2D3436;
        transition: color 0.3s ease;
    }

    .cart-icon:hover {
        color: var(--primary-color);
    }

    .cart-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: var(--accent-color);
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-menu .dropdown-toggle {
        background: transparent;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
    }

    .user-menu .dropdown-toggle:hover {
        background: var(--primary-color);
        color: white;
    }

    .user-menu .dropdown-menu {
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 12px;
        margin-top: 10px;
    }

    .user-menu .dropdown-item {
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }

    .user-menu .dropdown-item:hover {
        background: var(--background-light);
        color: var(--primary-color);
    }

    footer {
        background: #2D3436;
        color: white;
        padding: 4rem 0 2rem;
    }

    footer h5 {
        color: white;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    footer p, footer address {
        color: rgba(255,255,255,0.7);
        line-height: 1.8;
    }

    footer .list-unstyled li {
        margin-bottom: 0.75rem;
    }

    footer .list-unstyled a {
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    footer .list-unstyled a:hover {
        color: white;
    }

    .social-icons a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }

    .social-icons a:hover {
        background: var(--primary-color);
        transform: translateY(-3px);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    main {
        animation: fadeIn 0.6s ease-out;
    }
    </style>
    <?= $this->renderSection('styles')?>
    
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="<?= base_url() ?>">
                    <i class="fas fa-capsules me-2"></i>MedFinder
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url() ? 'active' : '' ?>" href="<?= base_url() ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('about') ? 'active' : '' ?>" href="<?= base_url('about') ?>">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('search') ? 'active' : '' ?>" href="<?= base_url('search') ?>">Search</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('pharmacies') ? 'active' : '' ?>" href="<?= base_url('pharmacies') ?>">Pharmacies</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == base_url('contact') ? 'active' : '' ?>" href="<?= base_url('contact') ?>">Contact</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-3">
                        <form class="search-form d-none d-lg-block" action="<?= base_url('search') ?>" method="get">
                            <i class="fas fa-search"></i>
                            <input class="form-control" type="search" placeholder="Quick search..." name="query">
                        </form>
                        <a href="<?= base_url('cart') ?>" class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cart-count" class="cart-badge">0</span>
                        </a>
                        <?php if(session()->get('logged_in')): ?>
                            <div class="user-menu dropdown">
                                <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                                    <img src="<?= esc(session()->get('profile_picture')) ?>" alt="Profile Picture" class="rounded-circle me-2" width="30">
                                    <?= session()->get('username') ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="<?= base_url('user/dashboard') ?>">
                                        <i class="fas fa-user-circle me-2"></i>My Dashboard
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('user/order-history') ?>">
                                        <i class="fas fa-shopping-bag me-2"></i>My Orders
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('logout') ?>">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="<?= base_url('login') ?>" class="btn btn-primary">Login</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <a class="navbar-brand d-flex align-items-center mb-4" href="<?= base_url() ?>">
                        <i class="fas fa-capsules me-2"></i>MedFinder
                    </a>
                    <p>Your trusted platform for finding medications and connecting with local pharmacies. We make healthcare accessible and convenient.</p>
                    <div class="social-icons d-flex gap-2 mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= base_url() ?>">Home</a></li>
                        <li><a href="<?= base_url('about') ?>">About Us</a></li>
                        <li><a href="<?= base_url('search') ?>">Search</a></li>
                        <li><a href="<?= base_url('pharmacies') ?>">Pharmacies</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5>Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= base_url('faqs') ?>">FAQs</a></li>
                        <li><a href="<?= base_url('contact') ?>">Contact Us</a></li>
                        <li><a href="<?= base_url('privacy') ?>">Privacy Policy</a></li>
                        <li><a href="<?= base_url('terms') ?>">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5>Contact Info</h5>
                    <address>
                        <p><i class="fas fa-map-marker-alt me-2"></i>123 MedFinder Street<br>Health City, HC 12345</p>
                        <p><i class="fas fa-envelope me-2"></i>info@medfinder.com</p>
                        <p><i class="fas fa-phone me-2"></i>(123) 456-7890</p>
                    </address>
                </div>
            </div>
            <hr class="mt-4 mb-3 opacity-25">
            <div class="text-center opacity-75">
                <small>&copy; <?= date('Y') ?> MedFinder. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/jquery-3.6.0.min.js')?>"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->

    <?= $this->renderSection('scripts') ?>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize cart
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        updateCartCount(cart.length);

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Cart functionality
        function updateCartCount(count) {
            const cartBadge = document.getElementById('cart-count');
            cartBadge.textContent = count;
            cartBadge.style.display = count > 0 ? 'flex' : 'none';
        }

        window.addToCart = function(item) {
            cart.push(item);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount(cart.length);
            
            // Show notification
            const notification = document.createElement('div');
            notification.className = 'position-fixed top-0 end-0 p-3';
            notification.style.zIndex = '9999';
            notification.innerHTML = `
                <div class="toast show" role="alert">
                    <div class="toast-header">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong class="me-auto">Success</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        Item added to cart successfully!
                    </div>
                </div>
            `;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }

        window.removeFromCart = function(index) {
            fetch('<?= base_url('cart/remove') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ index: index })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.cartCount);
                    location.reload();
                }
            });
        }
    });
    </script>
</body>
</html>