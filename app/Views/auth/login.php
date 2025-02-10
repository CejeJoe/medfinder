<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>Login<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Login to MedFinder</h2>
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                <form action="<?= base_url('/authenticate') ?>" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <a href="<?= base_url('login/google') ?>" class="btn btn-google">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" class="me-2">
                        Login with Google
                    </a>
                </div>
                <p class="mt-3 text-center">Don't have an account? <a href="<?= base_url('register') ?>">Register here</a></p>
            </div>
        </div>
    </div>
</div>
<?= $this->section("styles")?>
<style>
.btn-google {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #4285F4;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    font-weight: 500;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.btn-google img {
    width: 20px;
    height: 20px;
}

.btn-google:hover {
    background-color: #357ae8;
}
</style>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
