<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Add New Pharmacy<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="h2 mb-4">Add New Pharmacy</h1>

<form action="<?= base_url('admin/pharmacies/add') ?>" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Pharmacy Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <div class="mb-3">
        <label for="contact_number" class="form-label">Contact Number</label>
        <input type="tel" class="form-control" id="contact_number" name="contact_number" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="delivery_available" name="delivery_available" value="1">
        <label class="form-check-label" for="delivery_available">Delivery Available</label>
    </div>
    <button type="submit" class="btn btn-primary">Add Pharmacy</button>
</form>
<?= $this->endSection() ?>