<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Subscription Plan</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('admin/subscription-plans/update/' . $plan['id']) ?>" method="post">
                <div class="form-group">
                    <label for="name">Plan Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= esc($plan['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= esc($plan['description']) ?></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?= $plan['price'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="duration">Duration (in days)</label>
                    <input type="number" class="form-control" id="duration" name="duration" value="<?= $plan['duration'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="features">Features (one per line)</label>
                    <textarea class="form-control" id="features" name="features" rows="5"><?= is_array($decodedFeatures = json_decode($plan['features'], true)) ? implode("\n", $decodedFeatures) : '' ?></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active" <?= $plan['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $plan['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Plan</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

