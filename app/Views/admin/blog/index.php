<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4">Manage Blog Posts</h1>
    <a href="<?= base_url('admin/blog/create') ?>" class="btn btn-primary mb-3">Create New Post</a>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (!empty($posts)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?= esc($post['title']) ?></td>
                        <td><?= date('F j, Y', strtotime($post['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('admin/blog/edit/' . $post['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= base_url('admin/blog/delete/' . $post['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No blog posts found.</p>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

