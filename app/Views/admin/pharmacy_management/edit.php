<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Pharmacy</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('admin/pharmacies/edit/' . $pharmacy['id']) ?>" method="post">
                <div class="form-group">
                    <label for="name">Pharmacy Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $pharmacy['name'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?= $pharmacy['address'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?= $pharmacy['contact_number'] ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Pharmacy</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

