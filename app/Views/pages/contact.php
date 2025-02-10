<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Hero Section -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Get in Touch</h1>
                <p class="lead text-muted">We're here to help and answer any questions you might have.</p>
            </div>

            <div class="row g-4">
                <!-- Contact Form -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h2 class="h4 mb-4 text-primary">Send us a Message</h2>
                            <form action="<?= base_url('contact/submit') ?>" method="post">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                                <div class="mb-4">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary px-4 py-2">
                                    Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h2 class="h4 mb-4 text-primary">Contact Information</h2>
                            
                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-geo-alt text-primary fs-4"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="h6 mb-1">Address</h3>
                                    <p class="mb-0">123 MedFinder Street<br>Health City, HC 12345</p>
                                </div>
                            </div>

                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-envelope text-primary fs-4"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="h6 mb-1">Email</h3>
                                    <p class="mb-0">info@medfinder.com</p>
                                </div>
                            </div>

                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-telephone text-primary fs-4"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="h6 mb-1">Phone</h3>
                                    <p class="mb-0">(123) 456-7890</p>
                                </div>
                            </div>

                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-clock text-primary fs-4"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="h6 mb-1">Business Hours</h3>
                                    <p class="mb-0">
                                        Monday - Friday: 9:00 AM - 5:00 PM<br>
                                        Saturday: 10:00 AM - 2:00 PM<br>
                                        Sunday: Closed
                                    </p>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h3 class="h6 mb-3">Follow Us</h3>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-primary rounded-circle">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="#" class="btn btn-outline-info rounded-circle">
                                    <i class="bi bi-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-danger rounded-circle">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>