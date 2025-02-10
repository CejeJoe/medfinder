<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4">Customer Support</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Submit a Support Ticket</h5>
                    <form action="<?= base_url('support/submit-ticket') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Ticket</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Contact Information</h5>
                    <p><strong>Phone:</strong> +1234567890</p>
                    <p><strong>Email:</strong> support@medfinder.com</p>
                    <p><strong>Working Hours:</strong> Monday to Friday, 9 AM - 5 PM</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

