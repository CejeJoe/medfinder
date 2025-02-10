<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Pharmacy Registration</h3>
                </div>
                <div class="card-body">
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger">
                            <?php foreach (session('errors') as $error): ?>
                                <p><?= esc($error) ?></p>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>

                    <form action="<?= base_url('register/pharmacy') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="pharmacy_name" class="form-label">Pharmacy Name</label>
                            <input type="text" class="form-control" id="pharmacy_name" name="pharmacy_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="pharmacy_address" class="form-label">Pharmacy Address</label>
                            <input type="text" class="form-control" id="pharmacy_address" name="pharmacy_address" required>
                        </div>

                        <div class="mb-3">
                            <label for="pharmacy_contact" class="form-label">Pharmacy Contact</label>
                            <input type="text" class="form-control" id="pharmacy_contact" name="pharmacy_contact" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Register Pharmacy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

