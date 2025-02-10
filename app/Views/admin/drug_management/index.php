<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Drug Management<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Drug Management</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Drug Management</h1>
        <div class="btn-group">
            <a href="<?= base_url('admin/drugs/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Drug
            </a>
            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?= base_url('admin/drugs/categories') ?>">Manage Categories</a></li>
                <li><a class="dropdown-item" href="<?= base_url('admin/drugs/pending') ?>">View Pending Approvals</a></li>
                <li><a class="dropdown-item" href="<?= base_url('admin/drugs/upload-image') ?>">Upload Drug Image</a></li>
                <li><a class="dropdown-item" href="<?= base_url('admin/drugs/bulk-upload') ?>">Bulk Upload</a></li>
            </ul>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-4">
                    <label for="categoryFilter" class="form-label">Category</label>
                    <select class="form-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="statusFilter" class="form-label">Status</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" placeholder="Search drugs...">
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($drugs as $drug): ?>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?= $drug['id'] ?>">
                                </div>
                            </td>
                            <td><?= $drug['id'] ?></td>
                            <td>
                                <img src="<?= base_url('uploads/drugs/' . ($drug['image'] ?? 'default.jpg')) ?>" 
                                     alt="<?= $drug['name'] ?>" 
                                     class="rounded"
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold"><?= $drug['name'] ?></div>
                                <div class="small text-muted"><?= $drug['sku'] ?? 'No SKU' ?></div>
                            </td>
                            <td><?= $drug['category'] ?></td>
                            <td>
                                <?php
                                $statusClass = [
                                    'active' => 'success',
                                    'inactive' => 'danger',
                                    'pending' => 'warning'
                                ][$drug['status']] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?= $statusClass ?>">
                                    <?= ucfirst($drug['status']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('admin/drugs/edit/' . $drug['id']) ?>">
                                                <i class="fas fa-edit me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('admin/drugs/view/' . $drug['id']) ?>">
                                                <i class="fas fa-eye me-2"></i> View
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger" 
                                               href="<?= base_url('admin/drugs/delete/' . $drug['id']) ?>"
                                               onclick="return confirm('Are you sure you want to delete this drug?')">
                                                <i class="fas fa-trash me-2"></i> Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing <span class="fw-semibold">1</span> to 
                    <span class="fw-semibold">10</span> of 
                    <span class="fw-semibold"><?= $total_drugs ?></span> entries
                </div>
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all functionality
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('tbody .form-check-input');

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Filter functionality
    const searchInput = document.getElementById('search');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const category = categoryFilter.value;
        const status = statusFilter.value;

        document.querySelectorAll('tbody tr').forEach(row => {
            const nameCell = row.querySelector('td:nth-child(4)');
            const categoryCell = row.querySelector('td:nth-child(5)');
            const statusCell = row.querySelector('td:nth-child(7)');

            const matchesSearch = nameCell.textContent.toLowerCase().includes(searchTerm);
            const matchesCategory = !category || categoryCell.textContent === category;
            const matchesStatus = !status || statusCell.textContent.toLowerCase() === status;

            row.style.display = matchesSearch && matchesCategory && matchesStatus ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', applyFilters);
    categoryFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>

