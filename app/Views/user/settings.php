<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4 text-primary">User Settings</h1>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('user/settings/update') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= esc($user['username']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="<?= esc($user['phone']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Notification Preferences</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="email" id="email_notifications" name="notification_preferences[]" <?= in_array('email', json_decode($user['notification_preferences'] ?? '[]')) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="email_notifications">
                            Email Notifications
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="sms" id="sms_notifications" name="notification_preferences[]" <?= in_array('sms', json_decode($user['notification_preferences'] ?? '[]')) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="sms_notifications">
                            SMS Notifications
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Changes</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

