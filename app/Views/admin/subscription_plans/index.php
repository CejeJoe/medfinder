<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Subscription Plans</h1>
    
    <a href="<?= base_url('admin/subscription-plans/create') ?>" class="btn btn-primary mb-4">Create New Plan</a>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price(UGX)</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subscriptionPlans as $plan): ?>
                        <tr>
                            <td><?= esc($plan['name']) ?></td>
                            <td><?= number_format($plan['price'], 2) ?></td>
                            <td><?= $plan['duration'] ?> days</td>
                            <td><?= ucfirst($plan['status']) ?></td>
                            <td>
                                <a href="<?= base_url('admin/subscription-plans/edit/' . $plan['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="<?= base_url('admin/subscription-plans/delete/' . $plan['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this plan?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

