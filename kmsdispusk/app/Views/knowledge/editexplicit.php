<?= $this->extend('layout/page_layout') ?>

<?= $this->section('head') ?>
<title>Update Explicit</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<a href="<?= base_url('KMS/myexplicit'); ?>" class="btn btn-outline-primary mb-3">
    <i class="ti ti-arrow-left"></i>
    Kembali
</a>
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Edit Pengetahuan Explicit</h4>
                <nav aria-label="breadcrumb">

                    <!-- <p>Pengetahuan explicit adalah pengetahuan yang pengetahuan telah terdokumentasi (tertulis)<br>
                        SOP, Materi program pelatihan, Artikel, dan lainnya adalah contoh dari pengetahuan explicit </p> -->

                </nav>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        
        <form action="<?= base_url("KMS/myexplicit/{$knowledge['slug']}/update"); ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="row">

                <div class="col-12 col-md-6 col-lg-8 col-xl-9">

                    <div class="mb-3">
                        <label for="knowledgetitle" class="form-label">Judul</label>
                        <input type="text" class="form-control <?php if ($validation->hasError('knowledgetitle')) : ?>is-invalid<?php endif ?>" id="knowledgetitle" name="knowledgetitle" value="<?= $oldInput['knowledgetitle'] ?? $knowledge['knowledgetitle']; ?>" required>
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
                    <select class="form-select <?php if ($validation->hasError('category')) : ?>is-invalid<?php endif ?>" aria-label="Select category" id="category" name="category" value="<?= $oldInput['category'] ?? $knowledge['idkategori']; ?>" required>
                        <option>--Pilih category--</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category['idkategori']; ?>" <?= ($oldInput['category'] ?? $knowledge['idkategori']) == $category['idkategori'] ? 'selected' : ''; ?>><?= $category['namakategori']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('category'); ?>
                    </div>
                </div>

                <!-- BIDANG -->
                <div class="col-6 col-md-6 col-lg-4 mb-3">
                    <label for="bidang" class="form-label">Bidang</label>
                    <select class="form-select " aria-label="Select bidang" id="bidang" name="bidang" value="<?= $oldInput['bidang'] ?? $knowledge['bidang']; ?>" required>
                        <?php
                        $bidang = ['Umum', 'Perpustakaan', 'Kearsipan'];
                        foreach ($bidang as $bidang) : ?>
                            <option value="<?= $bidang; ?>" <?= ($oldInput['bidang'] ?? $knowledge['bidang']) == $bidang ? 'selected' : ''; ?>>Bidang <?= $bidang; ?></option>
                        <?php endforeach; ?>
                        <!-- <option>--Pilih bidang--</option>
                        <option value="Umum">Bidang Umum</option>
                        <option value="Perpustakaan">Bidang Perpustakaan</option>
                        <option value="Kearsipan">Bidang Kearsipan</option> -->
                    </select>
                    <div class="invalid-feedback">
                    </div>
                </div>
                <!-- END BIDANG -->
            </div>


            <div class="mb-3">
                <label for="file" class="form-label">File</label>
                <input type="hidden" name="filelama" value="<?= $knowledge['file']; ?>">
                <input class="form-control" type="file" id="file" name="file">
                <div class="invalid-feedback">
                    <?= $validation->getError('file'); ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="video" class="form-label">Video</label>
                <input type="hidden" name="videolama" value="<?= $knowledge['video']; ?>">
                <input class="form-control" type="file" id="video" name="video" accept="video/*">
                <div class="invalid-feedback">
                    <?= $validation->getError('video'); ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="hidden" name="gambarlama" value="<?= $knowledge['gambar']; ?>">
                <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*">
                <div class="invalid-feedback">
                    <?= $validation->getError('gambar'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 col-lg-8 col-xl-9">

                    <div class="mb-3 row">
                        <label for="isi" class="col-sm-2 col-form-label">Isi</label>
                        <textarea class="form-control summernote" name="isi" id="isi"><?= $oldInput['isi'] ?? $knowledge['knowledgecontent']; ?></textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>