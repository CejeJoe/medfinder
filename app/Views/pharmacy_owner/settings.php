<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <h1 class="mb-4">Pharmacy Settings</h1>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
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
            <form action="<?= base_url('pharmacy/settings') ?>" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Pharmacy Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= esc($pharmacy['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?= esc($pharmacy['address']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="contact_number" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?= esc($pharmacy['contact_number']) ?>" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="delivery_available" name="delivery_available" <?= $pharmacy['delivery_available'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="delivery_available">Delivery Available</label>
                </div>
                <div class="mb-3">
                    <label for="delivery_terms" class="form-label">Delivery Terms</label>
                    <textarea class="form-control" id="delivery_terms" name="delivery_terms" rows="3"><?= esc($pharmacy['delivery_terms']) ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

