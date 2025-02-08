<?= $this->extend('layout/page_layout') ?>

<?= $this->section('head') ?>
<title>Daftar Pengetahuan Saya</title>
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

<!-- table show content knowledge -->
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Pengetahuan Tacit Saya</h4>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row mb-3">

            <div class="d-flex justify-content-between mb-2">
                <div>
                    <a href="javascript:history.back()" class="btn btn-outline-primary">
                        <i class="ti ti-arrow-left"></i>
                        Kembali
                    </a>
                </div>
                <div>
                    <a href="<?= base_url('KMS/mytacit/new'); ?>" class="btn btn-primary">
                        <i class="ti ti-plus"></i>
                        Tambah Pengetahuan Tacit
                    </a>
                </div>
            </div>

        </div>

        <table class="table table-hover table-striped">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Bidang</th>
                    <th scope="col">kategori</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">Aksi</th>
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
                            <a href="<?= base_url("KMS/detailknowledge/{$knowledge['slug']}"); ?>">
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



                        <td>
                            <a href="<?= base_url("KMS/mytacit/{$knowledge['slug']}/edit"); ?>" class="d-block btn btn-primary w-100 mb-2">
                                <i class="ti ti-edit"></i>
                                Edit
                            </a>
                            <form action="<?= base_url("KMS/mytacit/{$knowledge['slug']}"); ?>" method="post">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure?');">
                                    <i class="ti ti-trash"></i>
                                    Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= $pager->links('knowledges', 'my_pager'); ?>
    </div>
</div>
<?= $this->endSection() ?>