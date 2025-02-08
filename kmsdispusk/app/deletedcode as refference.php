<!-- table show content knowledge -->
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
                            <button class="btn btn-outline-secondary" type="submit" id="searchButton">Cari</button>
                        </div>
                    </form>
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