<?= $this->extend('layout/admin') ?>

<?= $this->section('title') ?>Add Inventory Item<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Add Inventory Item</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">New Item Details</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('pharmacy/inventory/add') ?>" method="post">
                <div class="form-group">
                    <label for="drug_search">Search Drug</label>
                    <input type="text" class="form-control" id="drug_search" placeholder="Start typing to search...">
                    <input type="hidden" id="drug_id" name="drug_id" required>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="featured" name="featured">
                    <label class="form-check-label" for="featured">Featured Item</label>
                </div>
                <button type="submit" class="btn btn-primary">Add Item</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
$(document).ready(function() {
    $("#drug_search").on('input', function() {
        var query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: "<?= base_url('api/search') ?>",
                dataType: "json",
                data: {
                    q: query
                },
                success: function(data) {
                    var results = data.exact_matches.concat(data.suggestions);
                    var suggestions = results.map(function(item) {
                        return {
                            label: item.name + ' (' + item.generic_name + ')',
                            value: item.name,
                            id: item.id
                        };
                    });
                    $("#drug_search").autocomplete({
                        source: suggestions,
                        minLength: 1,
                        select: function(event, ui) {
                            $("#drug_id").val(ui.item.id);
                        }
                    }).autocomplete("search", query);
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>
