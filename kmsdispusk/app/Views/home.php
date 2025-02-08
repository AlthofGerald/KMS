<head>
    <link rel="stylesheet" href="<?= base_url("assets/css/styles.min.css"); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/home.css'); ?>">
    <link rel="shortcut icon" type="image/png" href="<?= base_url('uploads/1173497524.png') ?>" />
</head>

<body class="position-relative">
    <!--  Body Wrapper -->
    <div class="background">
    </div>

    <div class="page-wrapper" id="main-wrapper">
        <!--  Main wrapper -->

        <div class="body-wrapper position-relative ">
            <div class="overflow-hidden" style="
  margin-left: auto;
  margin-right: auto;
  width: 30%;">
                <div class="container px-12">
                    <img src="<?= base_url('uploads/dashboard.png'); ?>" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy">
                </div>
            </div>
            <?= $this->renderSection('back') ?>
            <div class="container col-xxl-8 px-4 py-5" style="min-height: 100vh;">
                <!-- Main content -->

                <div class="px-4 pt-5 my-5 text-center border-bottom">
                    <h1 class="display-4 fw-bold text-body-emphasis">Knowledge Management System<span class="text-primary"><br>Dinas Perpustakaan dan Kearsipan Kota Pagar Alam</span></h1>
                    <div class="col-lg-8 mx-auto">
                        <p class="lead mb-8">Berbagi pengetahuan di perpustakaan dan kearsipan adalah investasi dalam pertumbuhan sumber daya manusia. Mari kita jadi pelopor dalam membuka pintu menuju masa depan yang lebih cerdas dan berdaya saing.</p>
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
                            <a href="<?= base_url('login'); ?>" class="btn btn-primary btn-lg px-4 me-sm-3">Login KMS Dispusk</a>
                            <a href="http://103.150.92.125/" class="btn btn-outline-secondary btn-lg px-4">Website Dispusk</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Scripts -->


    <!-- Extra scripts -->
    <script src="<?= base_url("/assets/libs/jquery/dist/jquery.min.js") ?>"></script>
    <script src="<?= base_url("/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js") ?>"></script>
    <script src="<?= base_url("/assets/js/sidebarmenu.js") ?>"></script>
    <script src="<?= base_url("/assets/js/app.min.js") ?>"></script>
    <script src="<?= base_url("/assets/libs/apexcharts/dist/apexcharts.min.js") ?>"></script>
    <script src="<?= base_url("/assets/libs/simplebar/dist/simplebar.js") ?>"></script>
    <script src="<?= base_url("/assets/js/dashboard.js") ?>"></script>
</body>