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
<div class="card">
  <div class="card-body">
    <div class="row mb-3">

      <div class="d-flex justify-content-between mb-2">
        <h5 class="card-title fw-semibold mb-4">Pengetahuan Tacit Saya</h5>
        <div>
          <a href="<?= base_url('KMS/knowledgecategory/new'); ?>" class="btn btn-primary">
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
          <th scope="col">Sumber</th>
          <th scope="col">kategori</th>
          <th scope="col">Tipe</th>
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
              <a href="<?= base_url('/'); #base_url("admin/books/{$book['slug']}"); 
                        ?>">
                <p class="text-primary-emphasis text-decoration-underline"><b><?= "{$knowledge['knowledgetitle']}"; ?></b></p>

              </a>
            </td>
            <td><?= $knowledge['iduser']; ?></td>
            <td><?= $knowledge['idkategori']; ?></td>
            <td>Tacit </td>

          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
</div>
<?= $this->endSection() ?>