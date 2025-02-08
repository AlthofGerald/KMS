<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('layout/head') ?>
    <?= $this->renderSection('head') ?>
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }

        .note-editor .dropdown-toggle::after {
            all: unset;
        }

        .note-editor .note-dropdown-menu {
            box-sizing: content-box;
        }

        .note-editor .note-modal-footer {
            box-sizing: content-box;
        }
    </style>

</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar -->
        <?= $this->include('layout/sidebar') ?>

        <!--  header -->
        <div class="body-wrapper">
            <?= $this->include('layout/header') ?>

            <div class="container-fluid d-flex flex-wrap" style="min-height: 100vh;">
                <!-- Main content -->
                <div class="w-100">
                    <?= $this->renderSection('content') ?>
                </div>

                <div class="align-self-end w-100">
                    <?= $this->include('layout/footer') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- javascript below -->

    <!-- <script src="< ?=// base_url("/assets/libs/jquery/jquery.min.js") ?>"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url("/assets/libs/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
    <!-- <script src="< ?= base_url("/assets/js/sidebarmenu.js") ?>"></script> -->
    <script src="<?= base_url("/assets/js/app.min.js") ?>"></script>
    <script src="<?= base_url("/assets/libs/simplebar/simplebar.js") ?>"></script>



    <link href="<?= base_url("/assets/summernote/summernote-lite.min.css") ?>" rel="stylesheet">
    <script src="<?= base_url("/assets/summernote/summernote-lite.min.js") ?>"></script>

    <!-- CSS below -->
</body>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            callbacks: {
                onImageUpload: function(files) {
                    for (let i = 0; i < files.length; i++) {
                        $.upload(files[i]);
                    }
                },
                onMediaDelete: function(target) {
                    $.delete(target[0].src);
                }
            },
            height: 400,
            toolbar: [
                ["style", ["style","bold", "italic", "underline", "clear"]],
                ["fontname", ["fontname"]],
                ["fontsize", ["fontsize"]],
                ["color", ["color"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["height", ["height"]],
                ["insert", ["link", "picture", "imageList", "video", "hr"]],
                ['view', ['fullscreen', 'codeview', 'help']]

            ],
            dialogsInBody: true,
        });

        $.upload = function(file) {
            let out = new FormData();
            out.append('file', file, file.name);
            $.ajax({
                method: 'POST',
                url: '<?php echo site_url('KMS/summernote') ?>',
                contentType: false,
                cache: false,
                processData: false,
                data: out,
                success: function(img) {
                    $('.summernote').summernote('insertImage', img);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        };
        $.delete = function(src) {
            $.ajax({
                method: 'delete',
                url: '<?php echo site_url('KMS/notedelete') ?>',
                cache: false,
                data: {
                    src: src
                },
                success: function(response) {
                    console.log(response);
                }

            });
        };
    });
</script>

</html>