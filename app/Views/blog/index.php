<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4 text-primary">Latest Blog Posts</h1>
    <div class="row">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= base_url($post['image'] ?? 'assets/images/placeholder-blog.jpg') ?>" class="card-img-top" alt="<?= esc($post['title']) ?>">
                        <div class="card-body d-flex flex-column">
                            <h2 class="card-title h5"><?= esc($post['title']) ?></h2>
                            <p class="card-text flex-grow-1"><?= word_limiter(strip_tags($post['content']), 20) ?></p>
                            <a href="<?= base_url('blog/' . $post['slug']) ?>" class="btn btn-primary mt-auto">Read More</a>
                        </div>
                        <div class="card-footer text-muted">
                            <small>Posted on <?= date('F j, Y', strtotime($post['created_at'])) ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>No blog posts found.
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Pagination -->
    <div class="mt-4">
        <?//= $pager->links() ?>
    </div>
</div>
<?= $this->endSection() ?>

