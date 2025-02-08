<?= $this->extend('layout/page_layout') ?>
<?= $this->section('head') ?>
<title>Dashboard</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- total summaries -->
<div class="row">

    <div class="col-lg-6 col-md-6">
        <a href="<?= base_url('KMS/dashboard') ?>">
            <div class="card border-start border-info">
                <div class="card-body" ddata-bs-toggle="tooltip">
                    <div class="d-flex align-items-center">
                        <div>
                            <h4 class="card-title fs-7"><?= count($totalKnowledge); ?></h4>
                            <p class="card-title text-info">Pengetahuan</p>
                        </div>
                        <div class="ms-auto">
                            <span class="text-info display-6">
                                <i class="ti ti-book-2"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="card border-end border-primary">
            <div class="card-body">
                <div class="d-flex  align-items-center">
                    <div>
                        <h4 class="card-title fs-7">3</h4>
                        <p class="card-title text-primary">Bidang</p>
                    </div>
                    <div class="ms-auto">
                        <span class="text-primary display-6">
                            <i class="ti ti-album"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-3">

            <div class="col-10 col-lg-5">
                <h5 class="card-title fw-semibold mb-3">
                    Cari seluruh Pengetahuan
                </h5>
            </div>

            <div class="col-12 col-lg-7">

                <div>
                    <form action="" method="get">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" value="<?= $search ?? ''; ?>" placeholder="Cari pengetahuan" aria-label="Cari Pengetahuan" aria-describedby="searchButton">
                            <button class="btn btn-outline-secondary" type="submit" id="searchButton" name="submit">Cari</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
<?php if (empty($knowledge)) : ?>

    <div class="col-lg-6 d-flex align-items-center m-auto">
        <a href="javascript:void(0)" class="card text-bg-danger text-white w-100 card-hover">
            <div class="card-body m-auto">
                <div class="mt-1">
                    <h4 class="card-title mb-1 text-white">
                        Pengetahuan tidak ditemukan !
                    </h4>
                </div>
            </div>
        </a>
    </div>

<?php endif; ?>
<div class="row">
    <!-- show all knowledge -->
    <?php foreach ($knowledge as $knowledge) : ?>

        <div class="col-lg-6">
            <div class="card overflow-hidden hover-img">

                <div class="card-body p-4 ">

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
            var maxLength = 100; // Change this to your desired length
            if (text.length > maxLength) {
                element.textContent = text.substr(0, maxLength) + '...';
            }
        });
    });
</script>
<?= $this->endSection() ?>