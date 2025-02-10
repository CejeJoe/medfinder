<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Notifications<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>Notifications</h2>
    <?php if (empty($notifications)): ?>
        <p>No notifications found.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($notifications as $notification): ?>
                <li class="list-group-item <?= $notification['is_read'] ? '' : 'list-group-item-primary' ?>">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?= esc($notification['message']) ?></h5>
                        <small><?= date('Y-m-d H:i:s', strtotime($notification['created_at'])) ?></small>
                    </div>
                    <p class="mb-1">Type: <?= esc($notification['type']) ?></p>
                    <?php if (!$notification['is_read']): ?>
                        <button class="btn btn-sm btn-secondary mark-as-read" data-id="<?= $notification['id'] ?>">Mark as Read</button>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
<?= $this->section('scripts')?>
<script>
$(document).ready(function() {
    $('.mark-as-read').on('click', function() {
        var notificationId = $(this).data('id');
        var button = $(this);
        $.ajax({
            url: '<?= base_url('notifications/markAsRead') ?>/' + notificationId,
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    button.closest('li').removeClass('list-group-item-primary');
                    button.remove();
                }
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>

