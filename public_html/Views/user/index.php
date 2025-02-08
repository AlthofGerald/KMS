<?= $this->extend('layout/page_layout') ?>

<?= $this->section('head') ?>
<title>Data Admin</title>
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

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <h5 class="card-title fw-semibold mb-4">Data Pengguna</h5>
            <div>
                <a href="<?= base_url('KMS/users/newuser'); ?>" class="btn btn-primary">
                    <i class="ti ti-plus"></i>
                    Tambah User Baru
                </a>
            </div>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <h5 class="card-title fw-semibold mb-4"></h5>
            <div>
                <a href="<?= base_url('KMS/expert/newexpert'); ?>" class="btn btn-primary">
                    <i class="ti ti-plus"></i>
                    Tambah Expert Baru
                </a>
            </div>
        </div>
        <table class="table table-hover table-striped">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tanggal dibuat</th>
                    <th scope="col" class="text-center">Group</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php $i = 1 + ($itemPerPage * ($currentPage - 1)) ?>
                <?php $i = 1 + ($itemPerPage * ($currentPage - 1)) ?>
                <?php if (empty($users)) : ?>
                  <tr>
                    <td class="text-center" colspan="7"><b>Tidak ada data</b></td>
                  </tr>
                <?php endif; ?>
                <?php foreach ($users as $user) : ?>
                    <?php
                    $userAttributes = $user->toArray();
                    $userIdentities = $user->identities[0]->toArray();
                    $userGroup = $user->getGroups()[0];
                    ?>
                    <?php if ($userGroup != 'developer') { ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td>
                                <b><?= $userAttributes['username']; ?></b>
                            </td>
                            <td>
                                <b><?= $userIdentities['secret']; ?></b>
                            </td>
                            <td>
                                <?= $userAttributes['created_at']; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($userGroup === 'superadmin') : ?>
                                    <span class="badge bg-success rounded-3 fw-semibold text-black"><?= $userGroup; ?></span>
                                <?php elseif ($userGroup === 'admin') : ?>
                                    <span class="badge bg-primary rounded-3 fw-semibold"><?= $userGroup; ?></span>
                                <?php else : ?>
                                    <span class="badge bg-black rounded-3 fw-semibold"><?= $userGroup; ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <!-- action button -->

                                <div class="d-flex justify-content-center gap-2">
                                    <!-- update -->
                                    <?php $user = auth()->user();
                                    if ($user->inGroup('developer', 'admin') && ($userGroup != 'developer')) {
                                        // do something
                                    ?>
                                        <a href="<?= base_url("KMS/users/{$userAttributes['id']}/edit"); ?>" class="btn btn-primary mb-2">
                                            <i class="ti ti-edit"></i>
                                            Edit
                                        </a>
                                        <!-- delete -->
                                        <form action="<?= base_url("KMS/users/{$userAttributes['id']}"); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');">
                                                <i class="ti ti-trash"></i>
                                                Delete
                                            </button>
                                        </form>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                <?php endforeach; ?>
            </tbody>
        </table>
        <?= $pager->links('users', 'my_pager'); ?>
    </div>
</div>
<?= $this->endSection() ?>