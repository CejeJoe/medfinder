<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4 text-primary">Welcome, <?= esc($user['username']) ?>!</h1>
    <?php if ($user['profile_picture']): ?>
        <img src="<?= esc($user['profile_picture']) ?>" alt="Profile Picture" class="img-thumbnail mb-4" width="150">
    <?php endif; ?>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user-circle me-2"></i>Profile Summary</h5>
                    <ul class="list-unstyled">
                        <li><strong>Email:</strong> <?= esc($user['email']) ?></li>
                        <li><strong>Phone:</strong> <?= esc($user['phone'] ?? 'Not provided') ?></li>
                        <li><strong>Address:</strong> <?= esc($user['address'] ?? 'Not provided') ?></li>
                    </ul>
                    <a href="<?= base_url('user/profile') ?>" class="btn btn-primary"><i class="fas fa-edit me-2"></i>Edit Profile</a>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-shopping-bag me-2"></i>Recent Orders</h5>
                    <?php if (empty($recentOrders)): ?>
                        <p class="text-muted">You haven't placed any orders yet.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentOrders as $order): ?>
                                        <tr>
                                            <td>#<?= $order['id'] ?></td>
                                            <td><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
                                            <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                            <td><span class="badge bg-<?= $order['status'] == 'completed' ? 'success' : 'warning' ?>"><?= ucfirst($order['status']) ?></span></td>
                                            <td><a href="<?= base_url('user/order/order_view/' . $order['id']) ?>" class="btn btn-sm btn-outline-primary">View</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <a href="<?= base_url('user/order-history') ?>" class="btn btn-secondary mt-3"><i class="fas fa-history me-2"></i>View All Orders</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

