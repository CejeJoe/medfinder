<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= $title ?></h1>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/testimonials/edit/' . $testimonial['id']) ?>" method="post">
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="3" required><?= old('content', $testimonial['content']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Rating</label>
            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required value="<?= old('rating', $testimonial['rating']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Testimonial</button>
    </form>
</div>
<?= $this->endSection() ?>

