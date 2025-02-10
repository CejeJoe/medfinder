<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Hero Section -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">About MedFinder</h1>
                <p class="lead text-muted">Your trusted platform for finding medications and connecting with local pharmacies.</p>
            </div>

            <!-- Main Content -->
            <div class="row g-4">
                <!-- Vision Section -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-eye text-primary fs-1 me-3"></i>
                                <h2 class="h4 mb-0 text-primary">Our Vision</h2>
                            </div>
                            <p class="mb-0">We envision a world where everyone has easy access to the medications they need, when they need them. By bridging the gap between patients and pharmacies, we aim to reduce the stress and uncertainty often associated with finding and purchasing prescription drugs.</p>
                        </div>
                    </div>
                </div>

                <!-- Mission Section -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-bullseye text-primary fs-1 me-3"></i>
                                <h2 class="h4 mb-0 text-primary">Our Mission</h2>
                            </div>
                            <p class="mb-0">MedFinder is committed to improving access to healthcare by streamlining the process of locating and purchasing prescription drugs. We strive to make medication access simple, transparent, and efficient for everyone.</p>
                        </div>
                    </div>
                </div>

                <!-- How It Works -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="h4 mb-4 text-primary">How It Works</h2>
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                                            <i class="bi bi-search text-primary fs-2"></i>
                                        </div>
                                        <h3 class="h6 mb-2">Search</h3>
                                        <p class="small text-muted">Search for your medication using our user-friendly interface</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                                            <i class="bi bi-graph-up text-primary fs-2"></i>
                                        </div>
                                        <h3 class="h6 mb-2">Compare</h3>
                                        <p class="small text-muted">Compare prices and availability across multiple local pharmacies</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                                            <i class="bi bi-cart-check text-primary fs-2"></i>
                                        </div>
                                        <h3 class="h6 mb-2">Order</h3>
                                        <p class="small text-muted">Choose the best option and place your order directly</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                                            <i class="bi bi-box-seam text-primary fs-2"></i>
                                        </div>
                                        <h3 class="h6 mb-2">Receive</h3>
                                        <p class="small text-muted">Pick up your medication or have it delivered</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Our Commitment -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="h4 mb-4 text-primary">Our Commitment</h2>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <i class="bi bi-check-circle text-primary fs-4 me-3"></i>
                                        <div>
                                            <h3 class="h6 mb-2">Accurate Information</h3>
                                            <p class="small text-muted mb-0">Providing up-to-date information on drug availability and pricing</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <i class="bi bi-shield-check text-primary fs-4 me-3"></i>
                                        <div>
                                            <h3 class="h6 mb-2">Privacy & Security</h3>
                                            <p class="small text-muted mb-0">Ensuring the protection of personal and medical information</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <i class="bi bi-arrow-repeat text-primary fs-4 me-3"></i>
                                        <div>
                                            <h3 class="h6 mb-2">Continuous Improvement</h3>
                                            <p class="small text-muted mb-0">Regularly updating our platform based on user feedback</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <i class="bi bi-shop text-primary fs-4 me-3"></i>
                                        <div>
                                            <h3 class="h6 mb-2">Local Support</h3>
                                            <p class="small text-muted mb-0">Supporting local pharmacies and promoting fair competition</p>
                                        </div>
                                    </div>
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