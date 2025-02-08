<?= $this->extend('layout/page_layout') ?>

<?= $this->section('head') ?>
<title>Tambah Knowledge</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<a href="<?= base_url('KMS/mytacit'); ?>" class="btn btn-outline-primary mb-3">
    <i class="ti ti-arrow-left"></i>
    Kembali
</a>
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Tambah Pengetahuan Tacit</h4>
                <nav aria-label="breadcrumb">

                    <!-- <p>Pengetahuan explicit adalah pengetahuan yang pengetahuan telah terdokumentasi (tertulis)<br>
                        SOP, Materi program pelatihan, Artikel, dan lainnya adalah contoh dari pengetahuan explicit </p> -->

                </nav>
            </div>
        </div>
    </div>
</div>

<div class="card lg-12">
    <div class="card-body">
        
        <form action="<?= base_url('KMS/mytacit'); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="row">

                <div class="col-12 col-md-6 col-lg-12 col-xl-9">

                    <div class="mb-3">
                        <label for="knowledgetitle" class="form-label">Judul</label>
                        <input type="text" class="form-control <?php if ($validation->hasError('knowledgetitle')) : ?>is-invalid<?php endif ?>" id="knowledgetitle" name="knowledgetitle" value="<?= $oldInput['knowledgetitle'] ?? ''; ?>" required>
                        <div class="invalid-feedback">
                            <?= $validation->getError('title'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- kategori -->
                <div class="col-6 col-md-6 col-lg-4 mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-select <?php if ($validation->hasError('category')) : ?>is-invalid<?php endif ?>" aria-label="Select category" id="category" name="category" value="<?= $oldInput['category'] ?? ''; ?>" required>
                        <option>--Pilih category--</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category['idkategori']; ?>" <?= ($oldInput['category'] ?? '') == $category['idkategori'] ? 'selected' : ''; ?>><?= $category['namakategori']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('category'); ?>
                    </div>
                </div>

                <!-- BIDANG -->
                <div class="col-6 col-md-6 col-lg-4 lg-12">
                    <label for="bidang" class="form-label">Bidang</label>
                    <select class="form-select " aria-label="Select bidang" id="bidang" name="bidang" value="" required>
                        <option>--Pilih bidang--</option>
                        <option value="Umum">Bidang Umum</option>
                        <option value="Perpustakaan">Bidang Perpustakaan</option>
                        <option value="Kearsipan">Bidang Kearsipan</option>
                    </select>
                    <div class="invalid-feedback">
                    </div>
                </div>
                <!-- END BIDANG -->
            </div>
            <div class="row col-12">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12">

                    <div class=" lg-12 row">
                        <label for="isi" class="col-sm-2 col-form-label">Isi</label>
                        <textarea class="form-control summernote" name="isi" id="isi"></textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>



<?= $this->endSection() ?>