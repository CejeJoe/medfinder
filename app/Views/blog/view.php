<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <article>
                <header class="mb-4">
                    <h1 class="fw-bolder mb-1"><?= esc($post['title']) ?></h1>
                    <div class="text-muted fst-italic mb-2">Posted on <?= date('F j, Y', strtotime($post['created_at'])) ?> by <?= esc($post['author_id']) ?></div>
                    <div class="badge bg-secondary text-decoration-none link-light">Health</div>
                </header>
                
                <figure class="mb-4">
                    <img class="img-fluid rounded" src="<?= base_url($post['image'] ?? 'assets/images/placeholder-blog.jpg') ?>" alt="<?= esc($post['title']) ?>">
                </figure>
                
                <section class="mb-5">
                    <?= $post['content'] ?>
                </section>
            </article>
            
            <div class="mt-4">
                <a href="<?= base_url('blog') ?>" class="btn btn-primary"><i class="fas fa-arrow-left me-2"></i>Back to Blog</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

