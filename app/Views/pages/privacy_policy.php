<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Hero Section -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Privacy Policy</h1>
                <p class="lead text-muted">Last updated: <?= date('F d, Y') ?></p>
            </div>

            <!-- Policy Sections -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Information Collection -->
                        <div class="col-12">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-circle p-3">
                                        <i class="bi bi-collection text-primary fs-4"></i>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="h4 mb-3 text-primary">Information We Collect</h2>
                                    <p class="text-muted">We collect information you provide directly to us, such as when you:</p>
                                    <ul class="text-muted">
                                        <li>Create an account</li>
                                        <li>Place an order</li>
                                        <li>Contact us for support</li>
                                        <li>Subscribe to our newsletter</li>
                                    </ul>
                                    <p class="text-muted">This may include your name, email address, phone number, delivery address, and payment information.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Information Usage -->
                        <div class="col-12">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-circle p-3">
                                        <i class="bi bi-gear text-primary fs-4"></i>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="h4 mb-3 text-primary">How We Use Your Information</h2>
                                    <p class="text-muted">We use the information we collect to:</p>
                                    <ul class="text-muted">
                                        <li>Provide and maintain our services</li>
                                        <li>Process your orders</li>
                                        <li>Communicate with you</li>
                                        <li>Personalize your experience</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Information Sharing -->
                        <div class="col-12">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-circle p-3">
                                        <i class="bi bi-share text-primary fs-4"></i>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="h4 mb-3 text-primary">Information Sharing and Disclosure</h2>
                                    <p class="text-muted">We do not sell your personal information. We may share your information with:</p>
                                    <ul class="text-muted">
                                        <li>Third-party service providers who assist in our operations</li>
                                        <li>Payment processing services</li>
                                        <li>Delivery services</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Data Security -->
                        <div class="col-12">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-circle p-3">
                                        <i class="bi bi-shield-check text-primary fs-4"></i>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="h4 mb-3 text-primary">Data Security</h2>
                                    <p class="text-muted">We implement appropriate technical and organizational measures to protect your personal information against unauthorized or unlawful processing, accidental loss, destruction, or damage.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Your Rights -->
                        <div class="col-12">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-circle p-3">
                                        <i class="bi bi-person-check text-primary fs-4"></i>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="h4 mb-3 text-primary">Your Rights</h2>
                                    <p class="text-muted">You have the right to:</p>
                                    <ul class="text-muted">
                                        <li>Access your personal information</li>
                                        <li>Correct your personal information</li>
                                        <li>Delete your personal information</li>
                                        <li>Restrict or object to certain processing of your data</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-12">
                            <div class="d-flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-circle p-3">
                                        <i class="bi bi-envelope text-primary fs-4"></i>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="h4 mb-3 text-primary">Contact Us</h2>
                                    <p class="text-muted">If you have any questions about this Privacy Policy, please contact us at:</p>
                                    <p class="text-muted mb-0">Email: privacy@medfinder.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>