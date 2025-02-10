<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <h1 class="mb-4">Edit User</h1>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('admin/users/edit/' . $user['id']) ?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= esc($user['username']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="pharmacy_admin" <?= $user['role'] === 'pharmacy_admin' ? 'selected' : '' ?>>Pharmacy Admin</option>
                        <option value="super_admin" <?= $user['role'] === 'super_admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="driver" <?= $user['role'] === 'driver' ? 'selected' : '' ?>>Driver</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

