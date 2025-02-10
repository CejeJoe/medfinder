<?= $this->extend('layout/main') ?>

<?= $this->section('styles') ?>
<style>
:root {
    --checkout-primary: #6366f1;
    --checkout-success: #10b981;
    --checkout-warning: #f59e0b;
    --checkout-danger: #ef4444;
    --checkout-border: #e5e7eb;
    --checkout-bg: #ffffff;
    --checkout-text: #374151;
    --checkout-text-light: #6b7280;
}

.checkout-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.checkout-header {
    text-align: center;
    margin-bottom: 2rem;
}

.checkout-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--checkout-text);
    margin-bottom: 0.5rem;
}

.checkout-subtitle {
    color: var(--checkout-text-light);
    font-size: 1rem;
}

.checkout-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
}

@media (max-width: 1024px) {
    .checkout-grid {
        grid-template-columns: 1fr;
    }
}

.checkout-section {
    background: var(--checkout-bg);
    border-radius: 1rem;
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-title i {
    color: var(--checkout-primary);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: var(--checkout-text);
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--checkout-border);
    border-radius: 0.5rem;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--checkout-primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.product-list {
    margin-bottom: 1.5rem;
}

.product-item {
    display: flex;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid var(--checkout-border);
}

.product-item:last-child {
    border-bottom: none;
}

.product-image {
    width: 64px;
    height: 64px;
    border-radius: 0.5rem;
    object-fit: cover;
    margin-right: 1rem;
}

.product-info {
    flex: 1;
}

.product-name {
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.product-meta {
    font-size: 0.875rem;
    color: var(--checkout-text-light);
}

.product-price {
    font-weight: 600;
    color: var(--checkout-text);
}

.payment-methods {
    display: grid;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.payment-method {
    border: 1px solid var(--checkout-border);
    border-radius: 0.5rem;
    padding: 1rem;
    cursor: pointer;
    transition: all 0.2s;
}

.payment-method:hover {
    border-color: var(--checkout-primary);
}

.payment-method.active {
    border-color: var(--checkout-primary);
    background-color: rgba(99, 102, 241, 0.05);
}

.payment-method-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.payment-method-radio {
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid var(--checkout-border);
    border-radius: 50%;
    padding: 2px;
    transition: all 0.2s;
}

.payment-method.active .payment-method-radio {
    border-color: var(--checkout-primary);
    background: var(--checkout-primary);
    background-clip: content-box;
}

.payment-method-title {
    font-weight: 500;
    flex: 1;
}

.payment-method-icons {
    display: flex;
    gap: 0.5rem;
}

.payment-method-icons img {
    height: 24px;
    width: auto;
}

.order-summary {
    position: sticky;
    top: 2rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    font-size: 0.875rem;
    color: var(--checkout-text-light);
}

.summary-total {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--checkout-text);
    border-top: 1px solid var(--checkout-border);
    padding-top: 1rem;
    margin-top: 1rem;
}

.checkout-btn {
    width: 100%;
    background: var(--checkout-primary);
    color: white;
    border: none;
    padding: 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.checkout-btn:hover {
    background: var(--checkout-primary);
    transform: translateY(-1px);
}

.checkout-btn:disabled {
    background: var(--checkout-text-light);
    cursor: not-allowed;
}

.secure-checkout {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
    color: var(--checkout-text-light);
    font-size: 0.875rem;
}

.secure-checkout i {
    color: var(--checkout-success);
}

.delivery-options {
    display: grid;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.delivery-option {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    border: 1px solid var(--checkout-border);
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s;
}

.delivery-option:hover {
    border-color: var(--checkout-primary);
}

.delivery-option.active {
    border-color: var(--checkout-primary);
    background-color: rgba(99, 102, 241, 0.05);
}

.delivery-option-content {
    flex: 1;
}

.delivery-option-title {
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.delivery-option-description {
    font-size: 0.875rem;
    color: var(--checkout-text-light);
}

.delivery-option-price {
    font-weight: 600;
}

.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 0.5rem;
}

.alert-danger {
    background-color: #FEE2E2;
    border: 1px solid #FCA5A5;
    color: #991B1B;
}

.alert-success {
    background-color: #D1FAE5;
    border: 1px solid #6EE7B7;
    color: #065F46;
}

.form-control.error {
    border-color: var(--checkout-danger);
}

.error-message {
    color: var(--checkout-danger);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.loading {
    background-color: var(--checkout-text-light);
    cursor: wait;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="checkout-container">
    <!-- Alert container for displaying messages -->
    <div id="alertContainer"></div>
    <div class="checkout-header">
        <h1 class="checkout-title">Checkout</h1>
        <p class="checkout-subtitle">Please review your order and complete payment</p>
    </div>

    <div class="checkout-grid">
        <div class="checkout-main">
            <!-- Delivery Information -->
            <div class="checkout-section">
                <h2 class="section-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Delivery Information
                </h2>
                <form id="checkoutForm">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label class="form-label" for="fullName">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" required>
                        <div class="error-message" id="fullName-error"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                        <div class="error-message" id="phone-error"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="address">Delivery Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                        <div class="error-message" id="address-error"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="instructions">Delivery Instructions (Optional)</label>
                        <textarea class="form-control" id="instructions" name="instructions" rows="3"></textarea>
                    </div>
                </form>
            </div>

            <!-- Delivery Options -->
            <div class="checkout-section">
                <h2 class="section-title">
                    <i class="fas fa-truck"></i>
                    Delivery Options
                </h2>
                <div class="delivery-options">
                    <div class="delivery-option active">
                        <input type="radio" name="delivery" value="standard" checked class="mt-1">
                        <div class="delivery-option-content">
                            <div class="delivery-option-title">Standard Delivery</div>
                            <div class="delivery-option-description">Delivery within 24 hours</div>
                        </div>
                        <div class="delivery-option-price">UGX 3,000</div>
                    </div>
                    <div class="delivery-option">
                        <input type="radio" name="delivery" value="express" class="mt-1">
                        <div class="delivery-option-content">
                            <div class="delivery-option-title">Express Delivery</div>
                            <div class="delivery-option-description">Delivery within 2-4 hours</div>
                        </div>
                        <div class="delivery-option-price">UGX 5,000</div>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="checkout-section">
                <h2 class="section-title">
                    <i class="fas fa-credit-card"></i>
                    Payment Method
                </h2>
                <div class="payment-methods">
                    <div class="payment-method active">
                        <input type="radio" name="payment_method" value="card" checked>
                        <div class="payment-method-header">
                            <div class="payment-method-radio"></div>
                            <div class="payment-method-title">Credit/Debit Card</div>
                            <div class="payment-method-icons">
                                <img src="<?= base_url('assets/images/visa.png') ?>" alt="Visa">
                                <img src="<?= base_url('assets/images/mastercard.png') ?>" alt="Mastercard">
                            </div>
                        </div>
                    </div>
                    <div class="payment-method">
                        <input type="radio" name="payment_method" value="mobile_money">
                        <div class="payment-method-header">
                            <div class="payment-method-radio"></div>
                            <div class="payment-method-title">Mobile Money</div>
                            <div class="payment-method-icons">
                                <img src="<?= base_url('assets/images/mtn.png') ?>" alt="MTN">
                                <img src="<?= base_url('assets/images/airtel.png') ?>" alt="Airtel">
                            </div>
                        </div>
                    </div>
                    <div class="payment-method">
                        <input type="radio" name="payment_method" value="cash">
                        <div class="payment-method-header">
                            <div class="payment-method-radio"></div>
                            <div class="payment-method-title">Cash on Delivery</div>
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="order-summary checkout-section">
            <h2 class="section-title">
                <i class="fas fa-shopping-cart"></i>
                Order Summary
            </h2>
            <div class="product-list">
                <?php foreach ($cart as $item): ?>
                    <div class="product-item">
                        <img src="<?= base_url($item['image_url']) ?>" alt="<?= esc($item['drug_name']) ?>" class="product-image">
                        <div class="product-info">
                            <div class="product-name"><?= esc($item['drug_name']) ?></div>
                            <div class="product-meta">Qty: <?= esc($item['quantity']) ?></div>
                        </div>
                        <div class="product-price">UGX <?= number_format($item['price'] * $item['quantity'], 2) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="summary-row">
                <span>Subtotal</span>
                <span>UGX <?= number_format($total, 2) ?></span>
            </div>
            <div class="summary-row">
                <span>Delivery Fee</span>
                <span id="deliveryFee">UGX 3,000</span>
            </div>
            <div class="summary-row">
                <span>Tax</span>
                <span>UGX <?= number_format($total * 0.18, 2) ?></span>
            </div>
            <div class="summary-row summary-total">
                <span>Total</span>
                <span id="totalAmount">UGX <?= number_format($total + 3000 + ($total * 0.18), 2) ?></span>
            </div>
            <button type="submit" class="checkout-btn" id="submitOrder">
                Complete Order
            </button>
            <div class="secure-checkout">
                <i class="fas fa-lock"></i>
                <span>Secure Checkout</span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkoutForm = document.getElementById('checkoutForm');
    const submitButton = document.getElementById('submitOrder');
    const alertContainer = document.getElementById('alertContainer');
    const deliveryFeeElement = document.getElementById('deliveryFee');
    const totalAmountElement = document.getElementById('totalAmount');
    
    // Payment method selection
    const paymentMethods = document.querySelectorAll('.payment-method');
    paymentMethods.forEach(method => {
        method.addEventListener('click', () => {
            paymentMethods.forEach(m => m.classList.remove('active'));
            method.classList.add('active');
            method.querySelector('input[type="radio"]').checked = true;
        });
    });

    // Delivery option selection
    const deliveryOptions = document.querySelectorAll('.delivery-option');
    deliveryOptions.forEach(option => {
        option.addEventListener('click', () => {
            deliveryOptions.forEach(o => o.classList.remove('active'));
            option.classList.add('active');
            option.querySelector('input[type="radio"]').checked = true;
            
            // Update delivery fee and total
            const deliveryFee = option.querySelector('input[type="radio"]').value === 'express' ? 5000 : 3000;
            const subtotal = <?= $total ?>;
            const tax = subtotal * 0.18;
            const total = subtotal + deliveryFee + tax;
            
            deliveryFeeElement.textContent = `UGX ${deliveryFee.toLocaleString()}`;
            totalAmountElement.textContent = `UGX ${total.toLocaleString()}`;
        });
    });

    // Show alert message
    function showAlert(message, type = 'error') {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type === 'error' ? 'danger' : 'success'}`;
        alert.innerHTML = message;
        alertContainer.innerHTML = '';
        alertContainer.appendChild(alert);
        
        // Scroll to alert
        alert.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Clear form errors
    function clearErrors() {
        document.querySelectorAll('.error-message').forEach(error => error.textContent = '');
        document.querySelectorAll('.form-control').forEach(input => input.classList.remove('error'));
    }

    // Show form errors
    function showErrors(errors) {
        Object.keys(errors).forEach(field => {
            const errorElement = document.getElementById(`${field}-error`);
            const inputElement = document.getElementById(field);
            if (errorElement && inputElement) {
                errorElement.textContent = errors[field];
                inputElement.classList.add('error');
            }
        });
    }

    // Handle form submission
    submitButton.addEventListener('click', async function(e) {
        e.preventDefault();
        clearErrors();
        
        // Set loading state
        submitButton.disabled = true;
        submitButton.textContent = 'Processing...';

        try {
            // Get form data
            const formData = new FormData(checkoutForm);
            
            // Add payment method and delivery option
            formData.append('payment_method', document.querySelector('input[name="payment_method"]:checked').value);
            formData.append('delivery_option', document.querySelector('input[name="delivery"]:checked').value);
            
            // Submit order
            const response = await fetch('<?= base_url('order/create') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
                showAlert('Order created successfully! Redirecting...', 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            } else {
                if (data.errors) {
                    showErrors(data.errors);
                }
                showAlert(data.message || 'An error occurred. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('An error occurred. Please try again.');
        } finally {
            // Reset button state
            submitButton.disabled = false;
            submitButton.textContent = 'Complete Order';
        }
    });
});
</script>
<?= $this->endSection() ?>

