<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Edit Inventory Item<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Inventory Item</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Item Details</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('pharmacy/inventory/edit/' . $item['id']) ?>" method="post">
                <div class="form-group">
                    <label for="drug_name">Drug Name</label>
                    <input type="text" class="form-control" id="drug_name" value="<?= $item['drug_name'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="<?= $item['stock'] ?>" required>
                </div>
                <div class="form-group">
    <label for="low_stock_threshold">Low Stock Threshold</label>
    <input type="number" class="form-control" id="low_stock_threshold" name="low_stock_threshold" value="10" required>
</div>
                <div class="form-group mb-3">
                    <label for="price">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $item['price'] ?>" required>
                </div>
                <!-- <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="featured" name="featured" <?= $item['featured'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="featured">Featured Item</label>
                </div> -->
                <button type="submit" class="btn btn-primary">Update Item</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

