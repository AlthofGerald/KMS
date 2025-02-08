<!--  Header Start -->
<style>
    @media only screen and (max-width: 768px) {
        #navBtn {
            display: none;
        }
    }
</style>
<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end gap-2" id="headerCollapse">

                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover position-relative" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img alt="" width="35" height="35" class="rounded-circle border border-primary" style="background-color: white;">
                        <i class="ti ti-user position-absolute top-50 start-50 translate-middle text-primary"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" style="min-width: 300px;" aria-labelledby="drop2">
                        <div class="message-body">
                            <?php
                            $userGroup = auth()->user()->getGroups()[0];
                            $user = auth()->user();
                            $userAttributes = $user->toArray();
                            ?>
                            <div class="mx-3 mt-2">
                                <h5>Profil</h5>
                                <span>name: <b><?= auth()->user()->username; ?></b></span><br>
                                <span>email: <b><?= auth()->user()->email; ?></b></span><br>
                                <span>level: <?php if ($userGroup === 'superadmin') : ?>
                                        <span class="badge bg-success rounded-3 fw-semibold text-black"><?= $userGroup; ?></span>
                                    <?php elseif ($userGroup === 'admin') : ?>
                                        <span class="badge bg-primary rounded-3 fw-semibold"><?= $userGroup; ?></span>
                                    <?php else : ?>
                                        <span class="badge bg-black rounded-3 fw-semibold"><?= $userGroup; ?></span>
                                    <?php endif; ?></span>
                            </div>
                            <a href="<?= base_url("KMS/profil/{$userAttributes['id']}/edit"); ?>" class="btn btn-outline-secondary mx-3 mt-2 d-block" method="post">Edit Profil</a>
                            <a href="<?= base_url('logout'); ?>" class="btn btn-outline-danger mx-3 mt-2 d-block">Logout</a>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </nav>
</header>
<!--  Header End -->