<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <h1>Frequently Asked Questions</h1>
    <div class="accordion mt-4" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    How does MedFinder work?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    MedFinder allows you to search for medications and compare prices across different pharmacies. Simply enter the name of the medication you're looking for, and we'll show you where it's available and at what price.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Is a prescription required to order medications?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    For prescription medications, yes. You'll need to provide a valid prescription from your healthcare provider when placing an order. Over-the-counter medications can be ordered without a prescription.
                </div>
            </div>
        </div>
        <!-- Add more FAQ items as needed -->
    </div>
</div>
<?= $this->endSection() ?>

