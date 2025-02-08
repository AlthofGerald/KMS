<?= $this->extend('layout/page_layout') ?>
<?= $this->section('head') ?>
<title>KMS Dispusk Pagar Alam</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Pengetahuan <?= $Type; ?></h4>
                <nav aria-label="breadcrumb">

                    <!-- <p>Pengetahuan explicit adalah pengetahuan yang pengetahuan telah terdokumentasi (tertulis)<br>
                        SOP, Materi program pelatihan, Artikel, dan lainnya adalah contoh dari pengetahuan explicit </p> -->

                </nav>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- show all knowledge -->
    <?php foreach ($knowledge as $knowledge) : ?>

        <div class="col-lg-6">
            <div class="card overflow-hidden hover-img">

                <div class="card-body p-4">

                    <span <?php if ($knowledge['knowledgetype'] == 'tacit') {
                                echo ('class="badge bg-success-subtle text-dark fs-2 py-1 px-2 lh-sm  mt-3"');
                            } else {
                                echo ('class="badge bg-primary-subtle text-dark fs-2 py-1 px-2 lh-sm  mt-3"');
                            } ?>>
                        <?= $knowledge['knowledgetype']; ?>
                    </span>
                    <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3"><?= $knowledge['bidang']; ?></span>
                    <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3"><?= $knowledge['namakategori']; ?></span>
                    <a class="d-block my-4 fs-5 text-dark fw-semibold link-primary" href="<?= base_url("KMS/detailknowledge/{$knowledge['slug']}"); ?>"><?= $knowledge['knowledgetitle']; ?></a>
                    <div class="mb-3 text-limit-js">
                        <?= $knowledge['knowledgecontent']; ?>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center gap-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="text-dark fs-5"></i>By, <?= $knowledge['user']; ?>
                        </div>

                        <div class="d-flex align-items-center fs-2 ms-auto">
                            <i class="ti ti-point text-dark"></i><?php echo date('M, d-Y', strtotime($knowledge['created_at'])); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?= $pager->links('knowledges', 'my_pager'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var elements = document.querySelectorAll('.text-limit-js');
        elements.forEach(function(element) {
            var text = element.textContent;
            var maxLength = 150; // Change this to your desired length
            if (text.length > maxLength) {
                element.textContent = text.substr(0, maxLength) + '...';
            }
        });
    });
</script>
<?= $this->endSection() ?>