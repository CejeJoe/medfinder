<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Add New Drug<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/drugs') ?>">Drugs</a></li>
            <li class="breadcrumb-item active">Add New Drug</li>
        </ol>
    </nav>

    <!-- Back Button -->
    <div class="mb-4">
        <a href="<?= base_url('admin/drugs') ?>" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i> Back to Drugs
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Add New Drug</h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/drugs/add') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Basic Information -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Drug Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="generic_name" class="form-label">Generic Name</label>
                        <input type="text" class="form-control" id="generic_name" name="generic_name">
                    </div>

                    <div class="col-md-6">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="manufacturer" class="form-label">Manufacturer</label>
                        <input type="text" class="form-control" id="manufacturer" name="manufacturer">
                    </div>
                </div>

                <!-- Medical Information -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="dosage" class="form-label">Dosage</label>
                        <input type="text" class="form-control" id="dosage" name="dosage">
                    </div>

                    <div class="col-md-6">
                        <label for="form" class="form-label">Form</label>
                        <select class="form-select" id="form" name="form">
                            <option value="tablet">Tablet</option>
                            <option value="capsule">Capsule</option>
                            <option value="syrup">Syrup</option>
                            <option value="injection">Injection</option>
                            <option value="cream">Cream</option>
                            <option value="ointment">Ointment</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="side_effects" class="form-label">Side Effects</label>
                        <textarea class="form-control" id="side_effects" name="side_effects" rows="2"></textarea>
                    </div>

                    <div class="col-12">
                        <label for="contraindications" class="form-label">Contraindications</label>
                        <textarea class="form-control" id="contraindications" name="contraindications" rows="2"></textarea>
                    </div>
                </div>

                <!-- Pricing and Status -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price (UGX)</label>
                        <div class="input-group">
                            <span class="input-group-text">UGX</span>
                            <input type="number" class="form-control" id="price" name="price" required step="0.01">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="expiry_date" class="form-label">Expiry Date</label>
                        <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                    </div>

                    <div class="col-md-12">
                        <label for="image_url" class="form-label">Drug Image</label>
                        <input type="file" class="form-control" id="image_url" name="image_url" accept="image/*">
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1">
                            <label class="form-check-label" for="is_featured">Featured Drug</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="prescription_required" name="prescription_required" value="1">
                            <label class="form-check-label" for="prescription_required">Prescription Required</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="out_of_stock">Out of Stock</option>
                        </select>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex gap-2 justify-content-end">
                    <button type="reset" class="btn btn-light">Reset</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Save Drug
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image Preview
    const imageInput = document.getElementById('image_url');
    imageInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // You could add image preview functionality here if desired
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Form Validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>

