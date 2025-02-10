<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Edit Delivery Partner<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4">Edit Delivery Partner</h1>
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/delivery-partners/edit/' . $delivery_partner['id']) ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $delivery_partner['name']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="tel" class="form-control" id="contact_number" name="contact_number" value="<?= old('contact_number', $delivery_partner['contact_number']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $delivery_partner['email']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" required><?= old('address', $delivery_partner['address']) ?></textarea>
        </div>
        
        <div class="mb-3">
            <label for="vehicle_type" class="form-label">Vehicle Type</label>
            <select class="form-select" id="vehicle_type" name="vehicle_type" required>
                <option value="">Select Vehicle Type</option>
                <option value="Motorcycle" <?= old('vehicle_type', $delivery_partner['vehicle_type']) == 'Motorcycle' ? 'selected' : '' ?>>Motorcycle</option>
                <option value="Car" <?= old('vehicle_type', $delivery_partner['vehicle_type']) == 'Car' ? 'selected' : '' ?>>Car</option>
                <option value="Van" <?= old('vehicle_type', $delivery_partner['vehicle_type']) == 'Van' ? 'selected' : '' ?>>Van</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="license_number" class="form-label">License Number</label>
            <input type="text" class="form-control" id="license_number" name="license_number" value="<?= old('license_number', $delivery_partner['license_number']) ?>" required>
        </div>
        
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" <?= old('is_available', $delivery_partner['is_available']) ? 'checked' : '' ?>>
            <label class="form-check-label" for="is_available">Available for Delivery</label>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Delivery Partner</button>
        <a href="<?= base_url('admin/delivery-partners') ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>

