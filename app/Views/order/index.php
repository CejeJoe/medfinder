<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">My Orders</h5>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-download"></i> Export
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3">Order ID</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Pharmacy</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td class="ps-3">
                                            <span class="fw-medium">#<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></span>
                                        </td>
                                        <td>
                                            <div><?= date('M d, Y', strtotime($order['created_at'])) ?></div>
                                            <small class="text-muted"><?= date('h:i A', strtotime($order['created_at'])) ?></small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php foreach ($order['items'] as $index => $item): ?>
                                                    <?php if ($index < 3): ?>
                                                        <div class="position-relative">
                                                            <img src="<?= base_url($item['image_url']) ?>" 
                                                                 class="rounded-circle" 
                                                                 width="40" 
                                                                 height="40"
                                                                 style="margin-left: <?= $index * -10 ?>px; object-fit: cover;">
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <?php if (count($order['items']) > 3): ?>
                                                    <span class="ms-2 text-muted">+<?= count($order['items']) - 3 ?> more</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= base_url($order['pharmacy_logo']) ?>" 
                                                     class="rounded-circle me-2" 
                                                     width="32" 
                                                     height="32"
                                                     style="object-fit: cover;">
                                                <div>
                                                    <div class="fw-medium"><?= esc($order['pharmacy_name']) ?></div>
                                                    <small class="text-muted"><?= esc($order['pharmacy_location']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-medium">$<?= number_format($order['total_amount'], 2) ?></div>
                                            <?php if ($order['delivery_fee'] > 0): ?>
                                                <small class="text-muted">Incl. $<?= number_format($order['delivery_fee'], 2) ?> delivery</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $statusClasses = [
                                                'pending' => 'bg-warning',
                                                'processing' => 'bg-info',
                                                'shipped' => 'bg-primary',
                                                'delivered' => 'bg-success',
                                                'cancelled' => 'bg-danger'
                                            ];
                                            $statusClass = $statusClasses[$order['status']] ?? 'bg-secondary';
                                            ?>
                                            <span class="badge <?= $statusClass ?>"><?= ucfirst($order['status']) ?></span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="dropdown">
                                                <button class="btn btn-link btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="<?= base_url('order/view/' . $order['id']) ?>">View Details</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('order/track/' . $order['id']) ?>">Track Order</a></li>
                                                    <?php if ($order['status'] === 'pending'): ?>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item text-danger" 
                                                               href="<?= base_url('order/cancel/' . $order['id']) ?>"
                                                               onclick="return confirm('Are you sure you want to cancel this order?')">
                                                                Cancel Order
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

