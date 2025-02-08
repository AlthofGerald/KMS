<?php

/**
 * List of sidebar navigations
 */
$sidebarNavs =
    [
        'Home',
        [
            'name' => 'Dashboard',
            'link' => '/KMS/dashboard',
            'icon' => 'ti ti-layout-dashboard'
        ],
        'Pengetahuan',
        [
            'name' => 'Tacit',
            'link' => '/KMS/tacit',
            'icon' => 'ti ti-brain'
        ],
        [
            'name' => 'Explicit',
            'link' => '/KMS/explicit',
            'icon' => 'ti ti-books'
        ],
        [
            'name' => 'Bidang Pengetahuan',
            'link' => '/KMS/bidang',
            'icon' => 'ti ti-album'
        ],

        // 'Pengetahuan Saya',
        // [
        //     'name' => 'Tacit',
        //     'link' => '/KMS/mytacit',
        //     'icon' => 'ti ti-brain'
        // ],
        // [
        //     'name' => 'Explicit',
        //     'link' => '/KMS/myexplicit',
        //     'icon' => 'ti ti-books'
        // ],
        // 'Validasi Pengetahuan',
        // [
        //     'name' => 'Belum Tervalidasi',
        //     'link' => '/KMS/unvalidated',
        //     'icon' => 'ti ti-book'
        // ],
        // 'Manajemen KMS',
        // [
        //     'name' => 'User',
        //     'link' => '/KMS/users',
        //     'icon' => 'ti ti-user-cog'
        // ],
        // [
        //     'name' => 'Kategori',
        //     'link' => '/KMS/knowledgecategory',
        //     'icon' => 'ti ti-category-2'
        // ],


    ];
if (auth()->user()->inGroup('user', 'expert', 'developer') ?? false) {
    $sidebarNavs = array_merge(
        $sidebarNavs,
        [
            'Pengetahuan Saya',
            [
                'name' => 'Tacit',
                'link' => '/KMS/mytacit',
                'icon' => 'ti ti-book'
            ],
            [
                'name' => 'Explicit',
                'link' => '/KMS/myexplicit',
                'icon' => 'ti ti-books'
            ],

        ]
    );
}

if (auth()->user()->inGroup('expert', 'developer') ?? false) {
    $sidebarNavs = array_merge(
        $sidebarNavs,
        [
            'Verifikasi Pengetahuan',
            [
                'name' => 'Belum Terverifikasi',
                'link' => 'KMS/unverified',
                'icon' => 'ti ti-book'
            ],
        ]
    );
}

if (auth()->user()->inGroup('admin', 'developer') ?? false) {
    $sidebarNavs = array_merge(
        $sidebarNavs,
        [
            'Manajemen KMS',
            [
                'name' => 'User',
                'link' => '/KMS/users',
                'icon' => 'ti ti-user-cog'
            ],
            [
                'name' => 'Kategori',
                'link' => '/KMS/knowledgecategory',
                'icon' => 'ti ti-user-cog'
            ],


        ]
    );
}

if (auth()->user()->inGroup('developer') ?? false) {
    $sidebarNavs = array_merge(
        $sidebarNavs,
        [
            'Admin',
            [
                'name' => 'Tambah Admin',
                'link' => 'KMS/admin/newadmin',
                'icon' => 'ti ti-user-cog'
            ],

        ]
    );
}
?>

<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <!-- Brand -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <div class="pt-4 mx-auto">
                <a href="<?= base_url(); ?>">
                    <h2>KMS<span class="text-primary">Dispusk</span></h2>
                </a>
            </div>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">

            <ul id="sidebarnav">
                <?php foreach ($sidebarNavs as $nav) : ?>
                    <?php if (gettype($nav) === 'string') : ?>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu"><?= $nav; ?></span>
                        </li>
                    <?php else : ?>
                        <?php if ($nav['name'] == 'Tacit') : ?>
                            <li class="sidebar-item" data-bs-placement="right" title="Pengetahuan tacit adalah jenis pengetahuan yang sulit diungkapkan secara langsung dengan kata-kata atau simbol. Ini lebih tentang intuisi, keahlian, dan pemahaman yang diperoleh melalui pengalaman langsung daripada pengetahuan yang bisa dijelaskan dengan jelas.">
                                <a class="sidebar-link" href="<?= base_url($nav['link']) ?>" aria-expanded="false">
                                    <span>
                                        <i class="<?= $nav['icon']; ?>"></i>
                                    </span>
                                    <span class="hide-menu"><?= $nav['name']; ?></span>
                                </a>
                            </li>
                        <?php elseif ($nav['name'] == 'Explicit') : ?>
                            <li class="sidebar-item" data-bs-placement="bottom" title="Pengetahuan yang sudah dikumpulkan serta diterjemahkan ke dalam suatu bentuk dokumentasi (tertulis) sehingga lebih mudah dipahami oleh orang lain, contohnya yaitu dokumen, SOP, Materi pelatihan dan sebagainya">
                                <a class="sidebar-link" href="<?= base_url($nav['link']) ?>" aria-expanded="false">
                                    <span>
                                        <i class="<?= $nav['icon']; ?>"></i>
                                    </span>
                                    <span class="hide-menu"><?= $nav['name']; ?></span>
                                </a>
                            </li>
                        <?php else : ?>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="<?= base_url($nav['link']) ?>" aria-expanded="false">
                                    <span>
                                        <i class="<?= $nav['icon']; ?>"></i>
                                    </span>
                                    <span class="hide-menu"><?= $nav['name']; ?></span>
                                </a>
                            </li>
                        <?php endif; ?>

                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->