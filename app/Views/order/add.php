<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Create Order</h5>
                </div>
                <div class="card-body">
                    <?php if (session('error')): ?>
                        <div class="alert alert-danger">
                            <?= session('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">Product Details</h6>
                                    <h5 class="card-title mb-3"><?= esc($pharmacyDrug['drug_name']) ?></h5>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Price:</span>
                                        <strong>Ugx <?= number_format($pharmacyDrug['price'], 2) ?></strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Available Stock:</span>
                                        <strong><?= $pharmacyDrug['stock'] ?></strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Pharmacy:</span>
                                        <strong><?= esc($pharmacyDrug['pharmacy_name']) ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-subtitle mb-2 text-muted">Delivery Information</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Delivery Fee:</span>
                                        <strong>$5.00</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Estimated Delivery:</span>
                                        <strong>2-3 Business Days</strong>
                                    </div>
                                    <?php if ($pharmacyDrug['prescription_required']): ?>
                                        <div class="alert alert-warning mb-0">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                            Prescription will be required upon delivery
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="<?= base_url('order/create') ?>" method="post">
                        <input type="hidden" name="pharmacy_drug_id" value="<?= $pharmacyDrug['id'] ?>">
                        
                        <div class="mb-4">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" 
                                   class="form-control" 
                                   id="quantity" 
                                   name="quantity" 
                                   min="1" 
                                   max="<?= $pharmacyDrug['stock'] ?>" 
                                   value="<?= old('quantity', 1) ?>" 
                                   required>
                            <div class="form-text">Maximum quantity available: <?= $pharmacyDrug['stock'] ?></div>
                        </div>

                        <div class="mb-4">
                            <label for="delivery_address" class="form-label">Delivery Address</label>
                            <textarea class="form-control" 
                                      id="delivery_address" 
                                      name="delivery_address" 
                                      rows="3" 
                                      required><?= old('delivery_address') ?></textarea>
                        </div>

                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-3 text-muted">Order Summary</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <strong id="subtotal">$<?= number_format($pharmacyDrug['price'], 2) ?></strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Delivery Fee:</span>
                                    <strong>$5.00</strong>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span>Total:</span>
                                    <strong id="total">$<?= number_format($pharmacyDrug['price'] + 5, 2) ?></strong>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('quantity').addEventListener('change', function() {
    const quantity = this.value;
    const price = <?= $pharmacyDrug['price'] ?>;
    const deliveryFee = 5;
    
    const subtotal = quantity * price;
    const total = subtotal + deliveryFee;
    
    document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('total').textContent = '$' + total.toFixed(2);
});
</script>
<?= $this->endSection() ?>

