<?= $this->extend('layout/page_layout') ?>

<?= $this->section('head') ?>
<title>Pengetahuan Belum Terverifikasi</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('msg')) : ?>
    <div class="pb-2">
        <div class="alert <?= (session()->getFlashdata('error') ?? false) ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('msg') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

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

<!-- table show content knowledge -->
<div class="card">
    <div class="card-body">

        <table class="table table-hover table-striped">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Bidang</th>
                    <th scope="col">kategori</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tanggal Diupload</th>

                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php $i = 1 + ($itemPerPage * ($currentPage - 1)) ?>
                <?php if (empty($knowledge)) : ?>
                    <tr>
                        <td class="text-center" colspan="7"><b>Tidak ada data</b></td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($knowledge as $knowledge) : ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                        <td>
                            <a href="<?= base_url("KMS/detailknowledge/{$knowledge['slug']}"); #base_url("admin/books/{$book['slug']}"); 
                                        ?>">
                                <p class="text-primary-emphasis text-decoration-underline"><b><?= "{$knowledge['knowledgetitle']}"; ?></b></p>
                            </a>
                        </td>
                        <td><?= $knowledge['bidang']; ?></td>
                        <td><?= $knowledge['namakategori']; ?></td>
                        <?php if ($knowledge['status'] == FALSE) {
                            echo ('<td>Belum Diverifikasi</td>');
                        } else {
                            echo ('<td>Terverifikasi</td>');
                        } ?>
                        <td><?php echo date('M, d-Y', strtotime($knowledge['created_at'])); ?></td>


                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
<?= $pager->links('knowledges', 'my_pager'); ?>
    </div>
</div>
<?= $this->endSection() ?>