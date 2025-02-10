<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>System Settings<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">General Settings</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="siteName" class="form-label">Site Name</label>
                        <input type="text" class="form-control" id="siteName" value="MedFinder">
                    </div>
                    <div class="mb-3">
                        <label for="siteDescription" class="form-label">Site Description</label>
                        <textarea class="form-control" id="siteDescription" rows="3">Find medications easily with MedFinder</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="contactEmail" class="form-label">Contact Email</label>
                        <input type="email" class="form-control" id="contactEmail" value="contact@medfinder.com">
                    </div>
                    <div class="mb-3">
                        <label for="timezone" class="form-label">Timezone</label>
                        <select class="form-select" id="timezone">
                            <option value="UTC">UTC</option>
                            <option value="America/New_York">America/New_York</option>
                            <option value="Europe/London">Europe/London</option>
                            <option value="Asia/Tokyo">Asia/Tokyo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save General Settings</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Email Settings</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="smtpHost" class="form-label">SMTP Host</label>
                        <input type="text" class="form-control" id="smtpHost">
                    </div>
                    <div class="mb-3">
                        <label for="smtpPort" class="form-label">SMTP Port</label>
                        <input type="number" class="form-control" id="smtpPort">
                    </div>
                    <div class="mb-3">
                        <label for="smtpUser" class="form-label">SMTP Username</label>
                        <input type="text" class="form-control" id="smtpUser">
                    </div>
                    <div class="mb-3">
                        <label for="smtpPass" class="form-label">SMTP Password</label>
                        <input type="password" class="form-control" id="smtpPass">
                    </div>
                    <div class="mb-3">
                        <label for="emailFromAddress" class="form-label">From Email Address</label>
                        <input type="email" class="form-control" id="emailFromAddress">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Email Settings</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">System Information</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        PHP Version
                        <span class="badge bg-primary rounded-pill"><?= phpversion() ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        CodeIgniter Version
                        <span class="badge bg-primary rounded-pill"><?= \CodeIgniter\CodeIgniter::CI_VERSION ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Database Driver
                        <span class="badge bg-primary rounded-pill"><?= $db->DBDriver ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Server Software
                        <span class="badge bg-primary rounded-pill"><?= $_SERVER['SERVER_SOFTWARE'] ?></span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Maintenance Mode</h5>
            </div>
            <div class="card-body">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="maintenanceMode">
                    <label class="form-check-label" for="maintenanceMode">Enable Maintenance Mode</label>
                </div>
                <p class="text-muted mt-2">When enabled, the site will display a maintenance message to visitors.</p>
                <button class="btn btn-warning mt-2">Enter Maintenance Mode</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

