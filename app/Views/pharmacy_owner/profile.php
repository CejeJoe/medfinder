<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Pharmacy Profile<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Pharmacy Profile</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
        </div>
        <div class="card-body">
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            
            <form action="<?= base_url('pharmacy/profile') ?>" method="post">
                <div class="form-group">
                    <label for="name">Pharmacy Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $pharmacy['name'] ?? '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?= $pharmacy['address'] ?? '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="tel" class="form-control" id="contact_number" name="contact_number" value="<?= $pharmacy['contact_number'] ?? ''  ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $pharmacy['email'] ?? '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="operating_hours">Operating Hours</label>
                    <input type="text" class="form-control" id="operating_hours" name="operating_hours" value="<?= $pharmacy['operating_hours']  ?? ''  ?>">
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="delivery_available" name="delivery_available" <?= $pharmacy['delivery_available'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="delivery_available">Delivery Available</label>
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

