<?= $this->extend('layout/page_layout') ?>

<?= $this->section('head') ?>
<title>Detail Pengetahuan</title>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Detail Pengetahuan</h4>
            </div>
        </div>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <a href="javascript:history.back()" class="btn btn-outline-primary">
                    <i class="ti ti-arrow-left"></i>
                    Kembali
                </a>
            </div>
            <div class="d-flex gap-2 justify-content-end">

                <?php if (auth()->user()->inGroup('developer', 'expert') && $knowledge['status'] == FALSE) : ?>

                    <div>
                        <form action="<?= base_url("KMS/unverified/{$knowledge['slug']}"); ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="validate" value="TRUE">
                            <button type="submit" class="btn btn-outline-success  " onclick="return confirm('Are you sure?');">
                                <i class="ti ti-checks"></i>
                                Verifikasi
                            </button>
                        </form>
                    </div>

                <?php endif; ?>

            </div>
        </div>
        <span <?php if ($knowledge['knowledgetype'] == 'tacit') {
                    echo ('class="badge bg-success-subtle text-dark fs-2 py-1 px-2 lh-sm  mt-3"');
                } else {
                    echo ('class="badge bg-primary-subtle text-dark fs-2 py-1 px-2 lh-sm  mt-3"');
                } ?>>
            <?= $knowledge['knowledgetype']; ?>
        </span>
        <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3"><?= $knowledge['bidang']; ?></span>
        <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3"><?= $knowledge['namakategori']; ?></span>
        
        <h2 class="fs-9 fw-semibold my-4"><?= "{$knowledge['knowledgetitle']}"; ?></h2>
        <div class="d-flex align-items-center gap-4">
            <div class="d-flex align-items-center gap-2">

                <i class="text-dark fs-5"></i>By, <?= $knowledge['user']; ?>
            </div>

            <div class="d-flex align-items-center fs-2 ms-auto">
                <i class="ti ti-point text-dark"></i><?php echo date('M, d-Y', strtotime($knowledge['created_at'])); ?>
            </div>
            <div class="d-flex align-items-center fs-2 "><?= $knowledge['viewcount']; ?>
                <i class="ti ti-eye text-dark"></i>
            </div>
        </div>
    </div>
    <div class="card-body border-top p-4">
        <?php if ($knowledge['knowledgetype'] == 'explicit') : ?>
            <div class="d-flex border-bottom title-part-padding px-0 mb-3 align-items-center">
                <h4 class="mb-0 fs-5">File Pengetahuan Explicit</h4>
            </div>
        <?php endif; ?>
        <div class="row">
            <?php
            if ($knowledge['file'] != NULL && $knowledge['file'] != 'default.jpg') : ?>
                <div class="col-lg-6 col-md-6">
                    <div class="card overflow-hidden">
                        <div class="d-flex flex-row">
                            <div class="p-3">
                                <h3 class="text-info mb-0 fs-4"><?= $knowledge['file'] ?></h3>
                                <span class="text-muted d-block">Download file</span>
                            </div>
                            <div class="p-3 bg-info-subtle d-flex align-items-center ms-auto">
                                <h3 class="text-info box mb-0">
                                    <a href="<?= base_url("uploads/{$knowledge['file']}"); ?>" download>
                                        <i class="ti ti-download gap-4"></i>
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

            <?php
            if ($knowledge['gambar'] != NULL && $knowledge['gambar'] != 'default.jpg') : ?>
                <div class="col-lg-6 col-md-6">
                    <div class="card overflow-hidden">
                        <div class="d-flex flex-row">
                            <div class="p-3">
                                <h3 class="text-info mb-0 fs-4"><?= $knowledge['gambar'] ?></h3>
                                <span class="text-muted d-block">Download Gambar</span>

                            </div>
                            <div class="p-3 bg-info-subtle d-flex align-items-center ms-auto">
                                <h3 class="text-info box mb-0">
                                    <a href="<?= base_url("uploads/{$knowledge['gambar']}"); ?>" download>
                                        <i class="ti ti-download gap-4"></i>
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            if ($knowledge['video'] != NULL && $knowledge['video'] != 'default.jpg') : ?>
                <div class="col-lg-6 col-md-6">
                    <div class="card overflow-hidden">
                        <div class="d-flex flex-row">
                            <div class="p-3">
                                <h3 class="text-info mb-0 fs-4"><?= $knowledge['video'] ?></h3>
                                <span class="text-muted d-block">Download Video</span>

                            </div>
                            <div class="p-3 bg-info-subtle d-flex align-items-center ms-auto">
                                <h3 class="text-info box mb-0">
                                    <a href="<?= base_url("uploads/{$knowledge['video']}"); ?>" download>
                                        <i class="ti ti-download gap-4"></i>
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
        <br>

        <p><?= $knowledge['knowledgecontent']; ?></p>
        <br>
        <hr>

    </div>
</div>




<div class="card">
    <div class="card-body">
        <h4 class="mb-4 fw-semibold"></h4>

        <form action="<?= base_url('KMS/addComment'); ?>" method="post">

            <input type="hidden" name="idknowledge" value="<?= $knowledge['idknowledge']; ?>">
            <input type="hidden" name="replyid" value="0">

            <textarea class="form-control mb-4" name="commentcontent" placeholder="Kirim Komentar...." rows="5"></textarea>
            <button class="btn btn-primary">Post Comment</button>
        </form>


        <div class="d-flex align-items-center gap-3 mb-4 mt-7 pt-8">
            <h4 class="mb-0">Comments</h4>
            <span class="badge bg-primary-subtle text-primary fs-4 fw-semibold px-6 py-8 rounded"><!--total comment --></span>
        </div>


        <div class="position-relative">

            <!-- main comment -->
            <?php echo $comment; ?>
            <!-- end main comment -->

        </div>




        <!-- add a new comment -->







    </div>
</div>



<?= $this->endSection() ?>