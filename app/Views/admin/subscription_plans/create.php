<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Create Subscription Plan</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('admin/subscription-plans/store') ?>" method="post">
                <div class="form-group">
                    <label for="name">Plan Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="duration">Duration (in days)</label>
                    <input type="number" class="form-control" id="duration" name="duration" required>
                </div>
                <div class="form-group">
                    <label for="features">Features (one per line)</label>
                    <textarea class="form-control" id="features" name="features" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create Plan</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

