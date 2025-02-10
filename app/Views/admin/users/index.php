<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Manage Users<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="mb-4">Manage Users</h1>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= ucfirst($user['role']) ?></td>
                    <td>
                        <a href="<?= base_url('admin/users/edit/') ?><?= $user['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="<?= base_url('admin/users/delete/') ?><?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="mt-4">
        <?= $pager->links() ?>
    </div>
</div>
<?= $this->endSection() ?>

