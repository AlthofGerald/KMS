<?= $this->extend('layout/page_layout') ?>
<?= $this->section('head') ?>
<title>Dashboard</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- total summaries -->
<div class="row">

    <div class="col-lg-4 col-md-4" id="submit-button" name="submit">
        <form action="" method="get" id="my-form">
            <input type="hidden" name="bidang" value="Perpustakaan">
            <div class="card border-start border-info">
                <div class="card-body" ddata-bs-toggle="tooltip">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="card-title text-info">Perpustakaan</p>
                        </div>
                        <div class="ms-auto">
                            <span class="text-info display-6">
                                <i class="ti ti-book"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-lg-4 col-md-4" id="submit-button2" name="submit">
        <form action="" method="get" id="my-form2">
            <input type="hidden" name="bidang" value="Kearsipan">
            <div class="card border-top border-info">
                <div class="card-body" ddata-bs-toggle="tooltip">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="card-title text-info">Kearsipan</p>
                        </div>
                        <div class="ms-auto">
                            <span class="text-info display-6">
                                <i class="ti ti-books"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- 
     -->

    <div class="col-lg-4 col-md-4" id="submit-button3" name="submit">
        <form action="" method="get" id="my-form3">
            <input type="hidden" name="bidang" value="Umum">
            <div class="card border-end border-info">
                <div class="card-body" ddata-bs-toggle="tooltip">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="card-title text-info">Umum</p>
                        </div>
                        <div class="ms-auto">
                            <span class="text-info display-6">
                                <i class="ti ti-building-community"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--  -->

</div>
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Bidang Pengetahuan <?= $search; ?></h4>
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
                            <i class="text-dark fs-5"></i>Author, <?= $knowledge['user']; ?>
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
    document.getElementById("submit-button").addEventListener("click", function() {
        document.getElementById("my-form").submit();
    });
    document.getElementById("submit-button2").addEventListener("click", function() {
        document.getElementById("my-form2").submit();
    });
    document.getElementById("submit-button3").addEventListener("click", function() {
        document.getElementById("my-form3").submit();
    });
</script>
<?= $this->endSection() ?>