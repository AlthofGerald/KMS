<?= $this->extend('layout/page_layout') ?>

<?= $this->section('head') ?>
<title><?= lang('Auth.register') ?></title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>



<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold">Register User</h5>

        <?php if (session('error') !== null) : ?>
            <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
        <?php elseif (session('errors') !== null) : ?>
            <div class="alert alert-danger" role="alert">
                <?php if (is_array(session('errors'))) : ?>
                    <?php foreach (session('errors') as $error) : ?>
                        <?= $error ?>
                        <br>
                    <?php endforeach ?>
                <?php else : ?>
                    <?= session('errors') ?>
                <?php endif ?>
            </div>
        <?php endif ?>

        <form action="<?= base_url('KMS/users') ?>" method="post">


            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="my-3">

                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required />
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="my-3">
                        <label for="email" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required />

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="my-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required />

                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="my-3">
                        <label for="password_confirm" class="form-label">Konfirmasi password</label>
                        <input type="password" class="form-control" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required />
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>