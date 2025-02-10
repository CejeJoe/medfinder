<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Assign Delivery<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Assign Delivery for Order #<?= esc($order_id) ?></h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Delivery Assignment</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('pharmacy/orders/assign-delivery/' . esc($order_id)) ?>" method="post">
                <div class="form-group">
                    <label for="delivery_partner_id">Select Delivery Partner</label>
                    <select class="form-control" id="delivery_partner_id" name="delivery_partner_id" required>
                        <option value="">Choose a delivery partner</option>
                        <?php foreach ($delivery_partners as $partner): ?>
                            <option value="<?= esc($partner['id']) ?>"><?= esc($partner['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="estimated_delivery_time">Estimated Delivery Time</label>
                    <input type="datetime-local" class="form-control" id="estimated_delivery_time" name="estimated_delivery_time" required>
                </div>
                <button type="submit" class="btn btn-primary">Assign Delivery</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

