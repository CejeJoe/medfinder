<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - MedFinder Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/admin-style.css'); ?>" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="admin-layout">
        <nav class="sidebar">
            <div class="sidebar-header">
                <h4 class="mb-0"><i class="fas fa-clinic-medical me-2"></i><span class="brand-name">MedFinder</span></h4>
                <button id="sidebarToggle" class="btn btn-link text-white p-0">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="p-3">
            <?php if(session()->get('role') === 'super_admin'): ?>
                <!-- Admin Navigation -->
                <div class="mb-4">
                    <small class="text-muted text-uppercase px-3">Main</small>
                    <a href="<?= base_url('admin') ?>" class="nav-link <?= current_url() == base_url('admin') ? 'active' : '' ?>">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="mb-4">
                    <small class="text-muted text-uppercase px-3">Management</small>
                    <a href="<?= base_url('admin/users') ?>" class="nav-link <?= str_contains(current_url(), 'admin/users') ? 'active' : '' ?>">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                    <a href="<?= base_url('admin/drugs') ?>" class="nav-link <?= str_contains(current_url(), 'admin/drugs') ? 'active' : '' ?>">
                        <i class="fas fa-pills"></i>
                        <span>Drugs</span>
                    </a>
                    <a href="<?= base_url('admin/pharmacies') ?>" class="nav-link <?= str_contains(current_url(), 'admin/pharmacies') ? 'active' : '' ?>">
                        <i class="fas fa-clinic-medical"></i>
                        <span>Pharmacies</span>
                    </a>
                    <a href="<?= base_url('admin/orders') ?>" class="nav-link <?= str_contains(current_url(), 'admin/orders') ? 'active' : '' ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Orders</span>
                    </a>
                    <a href="<?= base_url('admin/delivery-partners') ?>" class="nav-link <?= str_contains(current_url(), 'admin/delivery-partners') ? 'active' : '' ?>">
                        <i class="fas fa-truck"></i>
                        <span>Delivery Partners</span>
                    </a>
                    <a href="<?= base_url('admin/subscription-plans') ?>" class="nav-link <?= str_contains(current_url(), 'admin/subscription-plans') ? 'active' : '' ?>">
                        <i class="fas fa-money-bill"></i>
                        <span>Subscription Plans</span>
                    </a>
                    <a href="<?= base_url('admin/testimonials') ?>" class="nav-link <?= str_contains(current_url(), 'admin/testimonials') ? 'active' : '' ?>">
                        <i class="fa-regular fa-comments"></i>
                        <span>Testimonials</span>
                    </a>
                    <a href="<?= base_url('admin/blog') ?>" class="nav-link <?= str_contains(current_url(), 'admin/blog') ? 'active' : '' ?>">
                        <i class="fa-solid fa-blog"></i>
                        <span>Blogs</span>
                    </a>
                </div>
                
                <div class="mb-4">
                    <small class="text-muted text-uppercase px-3">Analytics</small>
                    <a href="<?= base_url('admin/report') ?>" class="nav-link <?= str_contains(current_url(), 'admin/report') ? 'active' : '' ?>">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                    <a href="<?= base_url('admin/settings') ?>" class="nav-link <?= str_contains(current_url(), 'admin/settings') ? 'active' : '' ?>">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </div>
            <?php elseif(session()->get('role') === 'pharmacy_admin'): ?>
                <!-- Pharmacy Owner Navigation -->
                <div class="mb-4">
                    <small class="text-muted text-uppercase">Main</small>
                    <a href="<?= base_url('pharmacy') ?>" class="nav-link <?= current_url() == base_url('pharmacy') ? 'active' : '' ?>">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="mb-4">
                    <small class="text-muted text-uppercase">Management</small>
                    <a href="<?= base_url('pharmacy/profile') ?>" class="nav-link <?= str_contains(current_url(), 'pharmacy/profile') ? 'active' : '' ?>">
                        <i class="fas fa-store"></i>
                        <span>Pharmacy Profile</span>
                    </a>
                    <a href="<?= base_url('pharmacy/inventory') ?>" class="nav-link <?= str_contains(current_url(), 'pharmacy/inventory') ? 'active' : '' ?>">
                        <i class="fas fa-pills"></i>
                        <span>Inventory</span>
                    </a>
                    <a href="<?= base_url('pharmacy/orders') ?>" class="nav-link <?= str_contains(current_url(), 'pharmacy/orders') ? 'active' : '' ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Orders</span>
                    </a>
                    <a href="<?= base_url('pharmacy/drugs') ?>" class="nav-link <?= str_contains(current_url(), 'pharmacy/drugs') ? 'active' : '' ?>">
                        <i class="fa-solid fa-capsules"></i>
                        <span>Drugs</span>
                    </a>
                    <a href="<?= base_url('pharmacy/delivery-partners') ?>" class="nav-link <?= str_contains(current_url(), 'pharmacy/delivery-partners') ? 'active' : '' ?>">
                        <i class="fas fa-truck"></i>
                        <span>Delivery Partners</span>
                    </a>
                </div>
                
                <div class="mb-4">
                    <small class="text-muted text-uppercase">Analytics</small>
                    <a href="<?= base_url('pharmacy/reports') ?>" class="nav-link <?= str_contains(current_url(), 'pharmacy/analytics') ? 'active' : '' ?>">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                    <a href="<?= base_url('pharmacy/settings') ?>" class="nav-link <?= str_contains(current_url(), 'pharmacy/settings') ? 'active' : '' ?>">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </div>
            <?php endif; ?>
            </div>
        </nav>
        
        <main class="main-content">
            <header class="admin-header d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0"><?= $this->renderSection('title') ?></h1>
                <div class="d-flex align-items-center">
                    <div class="dropdown me-3">
                        <button class="btn btn-light" type="button" id="notificationsDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger notification-count">0</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" id="notificationsMenu">
                        <h6 class="dropdown-header">Notifications</h6>
                        <div id="notificationsList">
                            <!-- Notifications will be dynamically inserted here -->
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= base_url('notifications') ?>">View All Notifications</a>
                    </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <img src="<?= esc(session()->get('profile_picture')) ?>" alt="Profile Picture" class="rounded-circle me-2" width="30">
                            <?= session()->get('username') ?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="<?= base_url(session()->get('role') === 'admin' ? 'admin/profile' : 'pharmacy/profile') ?>">Profile</a>
                            <a class="dropdown-item" href="<?= base_url(session()->get('role') === 'admin' ? 'admin/settings' : 'pharmacy/settings') ?>">Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            
            <div class="p-4">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?= $this->renderSection('scripts') ?>
    <script>
    $(document).ready(function() {
        function fetchNotifications() {
            $.ajax({
                url: '<?= base_url('notifications/unread') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('.notification-count').text(data.length);
                    var notificationsList = $('#notificationsList');
                    notificationsList.empty();
                    if (data.length === 0) {
                        notificationsList.append('<span class="dropdown-item">No new notifications</span>');
                    } else {
                        $.each(data, function(index, notification) {
                            notificationsList.append(
                                '<a class="dropdown-item" href="<?= base_url('notifications') ?>" data-id="' + notification.id + '">' +
                                notification.message +
                                '</a>'
                            );
                        });
                    }
                }
            });
        }

        $(document).on('click', '#notificationsList a', function(e) {
            e.preventDefault();
            var notificationId = $(this).data('id');
            $.ajax({
                url: '<?= base_url('notifications/markAsRead') ?>/' + notificationId,
                type: 'POST',
                success: function() {
                    fetchNotifications();
                }
            });
        });

        fetchNotifications();
        setInterval(fetchNotifications, 30000); // Fetch every 30 seconds
    });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const brandName = document.querySelector('.brand-name');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                brandName.style.display = sidebar.classList.contains('collapsed') ? 'none' : 'inline';
            });

            // Handle responsive behavior
            function checkWidth() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                } else {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                }
            }

            window.addEventListener('resize', checkWidth);
            checkWidth(); // Initial check
        });
    </script>
</body>
</html>

