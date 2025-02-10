<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= $title ?></h1>
    <a href="<?= base_url('admin/testimonials/add') ?>" class="btn btn-primary mb-3">Add New Testimonial</a>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Content</th>
                <th>Rating</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($testimonials as $testimonial): ?>
                <tr>
                    <td><?= $testimonial['id'] ?></td>
                    <td>
                        <?= $testimonial['user_name'] ?>
                        <?php if ($testimonial['user_image']): ?>
                            <img src="<?= base_url('uploads/profile_images/' . $testimonial['user_image']) ?>" alt="User Image" class="img-thumbnail" style="width: 50px; height: 50px;">
                        <?php endif; ?>
                    </td>
                    <td><?= substr($testimonial['content'], 0, 100) . '...' ?></td>
                    <td><?= $testimonial['rating'] ?></td>
                    <td><?= $testimonial['created_at'] ?></td>
                    <td>
                        <a href="<?= base_url('admin/testimonials/edit/' . $testimonial['id']) ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="<?= base_url('admin/testimonials/delete/' . $testimonial['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this testimonial?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>

