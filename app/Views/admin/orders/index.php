<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Orders<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="h2 mb-4">Orders</h1>

<table class="table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td><?= $order['user_id'] ?></td>
            <td>UGX <?= number_format($order['total_amount'], 2) ?></td>
            <td><?= $order['status'] ?></td>
            <td>
                <a href="<?= base_url('admin/orders/view/' . $order['id']) ?>" class="btn btn-sm btn-primary">View</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>