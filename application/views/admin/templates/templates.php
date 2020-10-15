<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="baseUrl" content="<?= base_url() ?>">
    <meta name="menu" content="<?= (isset($menu)) ? $menu : null ?>">
    <meta name="token" content="<?= $this->session->userdata('token') ?>">
    <meta name="upk" content="<?= $this->session->userdata('upk') ?>">

    <title>E - Office | <?= $title ?></title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/fontawasome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/fontawasome/css/all.css">

    <!-- CSS Libraries -->
    <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/admin/node_modules/prismjs/themes/prism.css"> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/datatables.min.css" />


    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/modules/iziToast.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/assets/css/components.css">

    <!-- Tagify -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/tagify/dist/tagify.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/placeholder-loading.min.css">


    <!-- Summernote -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/summernote/summernote-bs4.css">

    <style type="text/css">
        html {
            scroll-behavior: smooth;
        }

        .tagify__dropdown.users-list .tagify__dropdown__item {
            padding: .5em .7em;
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 0 1em;
            grid-template-areas: "avatar name"
                "avatar email";
        }

        .tagify__dropdown.users-list .tagify__dropdown__item:hover .tagify__dropdown__item__avatar-wrap {
            transform: scale(1.2);
        }

        .tagify__dropdown.users-list .tagify__dropdown__item__avatar-wrap {
            grid-area: avatar;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            background: #EEE;
            transition: .1s ease-out;
        }

        .tagify__dropdown.users-list img {
            width: 100%;
            vertical-align: top;
        }

        .tagify__dropdown.users-list strong {
            grid-area: name;
            width: 100%;
            align-self: center;
        }

        .tagify__dropdown.users-list span {
            grid-area: email;
            width: 100%;
            font-size: .9em;
            opacity: .6;
        }

        .tagify__dropdown.users-list .addAll {
            border-bottom: 1px solid #DDD;
            gap: 0;
        }


        /* Tags items */
        .tagify__tag {
            white-space: nowrap;
        }

        .tagify__tag:hover .tagify__tag__avatar-wrap {
            transform: scale(1.6) translateX(-10%);
        }

        .tagify__tag .tagify__tag__avatar-wrap {
            width: 16px;
            height: 16px;
            white-space: normal;
            border-radius: 50%;
            margin-right: 5px;
            transition: .12s ease-out;
        }

        .tagify__tag img {
            width: 100%;
            vertical-align: top;
        }

        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: #555;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 4px;
        }

        #myBtn:hover {
            background-color: #00b7c2;
        }

        .dropdown-list .dropdown-list-content:not(.is-end):after {
            height: 0px;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: transparent;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #6777EF;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #6777EF;
        }
    </style>

</head>

<body class="layout-3">
    <button onclick="topFunction()" id="myBtn" class="btn btn-primary" title="Go to top"><i class="fas fa-long-arrow-alt-up"></i></button>
    <div>
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>

            <br>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="<?= base_url('admin/dashboard') ?>" class="navbar-brand sidebar-gone-hide">
                </a>
                <?php
                if ($this->session->userdata('upk') == 0) { ?>
                    <img src='<?= base_url('uploads/config/' . $this->req->getLogo()) ?>' width='3%'>";
                <?php } else { ?>
                    <img src='<?= base_url('uploads/config/' . $this->req->getLogoUpk()) ?>' width='3%'>";
                <?php }
                ?>

                <div class="nav-collapse">
                    <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
                        <i class="fas fa-bars"></i>
                    </a>
                    <ul class="navbar-nav">

                    </ul>
                    <ul class="navbar-nav">
                        <li class="dropdown nav-item">
                            <?php
                            if ($this->session->userdata('level') <= 2) : ?>
                                <a href="#" data-toggle="dropdown" class="nav-item nav-link dropdown-toggle nav-link-lg nav-link-user">
                                    <div class="d-lg-inline-block d-md-inline-block d-sm-inline-block d-xs-inline-block"><i class="fas fa-table"> </i> Master Data</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">

                                    <?php if ($this->session->userdata('level') == 1) : ?>
                                        <a href="#" class="dropdown-item has-icon">
                                            Master Admin
                                        </a>
                                        <a href="<?= base_url('admin/yayasan/set/identitas') ?>" class="dropdown-item has-icon" id="menu-yayasan">
                                            <i class="fas fa-landmark"></i> Identitas Yayasan
                                        </a>
                                        <a href="<?= base_url('admin/jabatan') ?>" class="dropdown-item has-icon" id="menu-jabatan">
                                            <i class="fas fa-user-check"></i> Jabatan
                                        </a>
                                        <a href="<?= base_url('admin/upk') ?>" class="dropdown-item has-icon" id="menu-upk">
                                            <i class="fas fa-building"></i> UPK
                                        </a>
                                        <a href="<?= base_url('admin/pegawai') ?>" class="dropdown-item has-icon" id="menu-pegawai">
                                            <i class="fas fa-users"></i> Pegawai
                                        </a>
                                        <a href="<?= base_url('admin/user/upk') ?>" class="dropdown-item has-icon" id="menu-user">
                                            <i class="fas fa-user"></i> Admin UPK
                                        </a>
                                    <?php endif ?>

                                    <?php if ($this->session->userdata('level') == 2) : ?>
                                        <a href="#" class="dropdown-item has-icon" id="menu-yayasan">
                                            Master UPK
                                        </a>

                                        <a href="<?= base_url('admin/pengaturan/web') ?>" class="dropdown-item has-icon" id="menu-pengaturan">
                                            <i class="fas fa-images"></i> Identitas UPK
                                        </a>
                                        <a href="<?= base_url('admin/pengaturan/format/surat') ?>" class="dropdown-item has-icon" id="menu-format">
                                            <i class="fas fa-hashtag"></i> Format Nomor Surat
                                        </a>
                                        <a href="<?= base_url('admin/jenis') ?>" class="dropdown-item has-icon" id="menu-jenis">
                                            <i class="fas fa-mail-bulk"></i> Jenis Surat
                                        </a>
                                        <a href="<?= base_url('admin/aksi') ?>" class="dropdown-item has-icon" id="menu-aksi">
                                            <i class="fas fa-exclamation-triangle"></i> Aksi Surat
                                        </a>
                                        <a href="<?= base_url('admin/sifat') ?>" class="dropdown-item has-icon" id="menu-sifat">
                                            <i class="fas fa-exclamation-circle"></i> Sifat Surat
                                        </a>
                                        <!--   <a href="<?= base_url('admin/tujuan') ?>" class="sumputken dropdown-item has-icon" id="menu-tujuan">
                                            <i class="fas fa-shipping-fast"></i> Tujuan Surat
                                        </a>
                                        <a href="<?= base_url('admin/status') ?>" class="dropdown-item has-icon" id="menu-status">
                                            <i class="fas fa-paper-plane"></i> Status Surat
                                        </a>
                                        <a href="<?= base_url('admin/akses') ?>" class="sumputken  dropdown-item has-icon" id="menu-akses">
                                            <i class="fas fa-key"></i> Akses Pengajuan Surat
                                        </a> -->
                                        <a href="<?= base_url('admin/jabatan') ?>" class="dropdown-item has-icon" id="menu-jabatan">
                                            <i class="fas fa-user-check"></i> Jabatan
                                        </a>

                                        <!-- <a href="<?= base_url('admin/satuan') ?>" class="dropdown-item has-icon"
                                    id="menu-satuan">
                                    <i class="fas fa-tags"></i> Satuan
                                </a> -->
                                        <a href="<?= base_url('admin/staf') ?>" class="dropdown-item has-icon" id="menu-staf">
                                            <i class="fas fa-user-shield"></i> Staf UPK
                                        </a>
                                        <a href="<?= base_url('admin/adminsurat') ?>" class="dropdown-item has-icon" id="menu-admin-persuratan">
                                            <i class="fas fa-user-cog"></i> Admin Persuratan
                                        </a>
                                    <?php endif ?>


                                </div>
                        </li>
                    <?php endif ?>
                    <?php if ($this->session->userdata('level') > 2) : ?>
                       
                        
                     

                        <li class="dropdown nav-item">
                            <a href="#" data-toggle="dropdown" class="nav-item nav-link dropdown-toggle nav-link-lg nav-link-user active">
                                <div class="d-lg-inline-block d-md-inline-block d-sm-inline-block d-xs-inline-block"><i class="fas fa-envelope"> </i> Surat
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item has-icon" id="menu-yayasan">
                                        Approval Surat
                                </a>
                                <a href="<?= base_url('admin/verifikasi') ?>" class="dropdown-item has-icon" id="menu-masuk">
                                    <i class="fas fa-check-circle"></i> Surat Keluar Eksternal
                                </a>
                                <a href="<?= base_url('admin/verifikasi/internal') ?>" class="dropdown-item has-icon" id="menu-masuk">
                                    <i class="fas fa-check-circle"></i> Surat Keluar Internal
                                </a>
                                <a href="#" class="dropdown-item has-icon" id="menu-yayasan">
                                        Persuratan Internal
                                </a>
                                <!-- <?php var_dump($this->session->userdata('level')) ?> -->
                                <?php if ($this->session->userdata('level') == 3) : ?>

                                    <a href="<?= base_url('admin/surat/masuk/internal') ?>" class="dropdown-item has-icon" id="menu-internal">
                                        <i class="fas fa-reply"></i> Persuratan Internal
                                    </a>
                                    <a href="<?= base_url('admin/surat/internal/keluar') ?>" class="dropdown-item has-icon" id="menu-internal">
                                        <i class="fas fa-reply"></i> Surat Keluar Internal
                                    </a>
                                    <a href="<?= base_url('admin/surat/masuk/user') ?>" class="dropdown-item has-icon" id="menu-masuk">
                                        <i class="fas fa-reply"></i> Surat Masuk
                                    </a>
                                <?php endif ?>
                                
                                <?php if ($this->session->userdata('level') == 4) : ?>
                                    
                                    <a href="<?= base_url('admin/surat/masuk/adminsurat') ?>" class="dropdown-item has-icon" id="menu-masuk">
                                        <i class="fas fa-reply"></i> Surat Masuk
                                    </a>

                                    <a href="<?= base_url('admin/surat/masuk') ?>" class="dropdown-item has-icon" id="menu-masuk">
                                        <i class="fas fa-reply"></i> Terima Surat Masuk 
                                    </a>


                                <?php endif ?>
                                <a href="<?= base_url('admin/surat/keluar') ?>" class="dropdown-item has-icon" id="menu-keluar">
                                    <i class="fas fa-share"></i> Buat Surat Keluar
                                </a>
                            </div>
                        </li>


                    <?php endif ?>

                    <li class="dropdown nav-item">
                        <a href="#" data-toggle="dropdown" class="nav-item nav-link dropdown-toggle nav-link-lg nav-link-user active">
                            <div class="d-lg-inline-block d-md-inline-block d-sm-inline-block d-xs-inline-block"><i class="fas fa-envelope"> </i> Arsip Surat
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?= base_url('admin/arsip/masuk') ?>" class="dropdown-item has-icon" id="menu-arsip-masuk">
                                <i class="fas fa-sign-in-alt"></i> Surat Masuk
                            </a>

                            <a href="<?= base_url('admin/arsip/keluar') ?>" class="dropdown-item has-icon" id="menu-keluar">
                                <i class="fas fa-sign-out-alt"></i> Surat Keluar
                            </a>
                        </div>
                    </li>
                    <!-- <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-inbox"></i> Arsip Surat
                                Masuk</a></li>
                        <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-shipping-fast"> </i> Arsip
                                Surat Keluar</a></li> -->
                    </ul>
                </div>



                <ul class="navbar-nav navbar-right ml-auto">
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg " id="bell"><i class="far fa-bell"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Notifikasi
                                <!-- <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div> -->
                            </div>
                            <input type="hidden" id="dataNotif">
                            <div class="dropdown-list-content dropdown-list-icons" id="notifNa">

                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="<?= base_url('admin/notifikasi') ?>">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>

                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="<?= base_url() ?>assets/admin/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, <?= $this->session->userdata('nama_user') ?>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?= base_url('admin/profile') ?>" id="menu-profile" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profil
                            </a>
                            <?php if ($this->session->userdata('level') == 2) : ?>
                                <a href="<?= base_url('admin/pengaturan/web') ?>" class="dropdown-item has-icon">
                                    <i class="fas fa-cog"></i> Pengaturan
                                </a>
                            <?php endif ?>
                            <div class="dropdown-divider"></div>
                            <a href="#" id="btnKeluar" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Keluar
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <!-- <div class="card"> -->
                    <!-- <div class="card-body"> -->
                    <?php require_once 'content.php' ?>
                    <!-- </div> -->
                    <!-- </div> -->


                </section>

                <form class="modal-part" id="modal-login-part">
                    <p>This login form is taken from elements with <code>#modal-login-part</code> id.</p>
                    <div class="form-group">
                        <label>Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Email" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </div>
                            </div>
                            <input type="password" class="form-control" placeholder="Password" name="password">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" id="remember-me">
                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                        </div>
                    </div>
                </form>

                <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Modal body text goes here.</p>
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="main-footer">
                    <div class="footer-left">
                        <!-- Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a> -->
                    </div>
                    <div class="footer-right">
                        <!-- 2.3.0 -->
                    </div>
                </footer>
            </div>
        </div>

        <!-- General JS Scripts -->
        <script src="<?= base_url() ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
        <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.nicescroll.min.js"></script>
        <script src="<?= base_url() ?>assets/js/moment.min.js"></script>
        <script src="<?= base_url() ?>assets/admin/assets/js/stisla.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/js/datatables.min.js"></script>
        <!-- JS Libraies -->
        <script src="<?= base_url() ?>assets/jstree/dist/jstree.js"></script>

        <!-- <script src="<?= base_url() ?>assets/admin/node_modules/prismjs/prism.js"></script> -->
        <!-- JS Libraies -->

        <!-- Tagify -->
        <script src="<?= base_url() ?>assets/tagify/dist/tagify.min.js"></script>
        <script src="<?= base_url() ?>assets/tagify/dist/jQuery.tagify.min.js"></script>
        <script src="<?= base_url() ?>assets/js/autosize.min.js"></script>
        <!-- Sweet Alert -->
        <script src="<?= base_url() ?>assets/modules/iziToast.min.js"></script>
        <script src="<?= base_url() ?>assets/modules/sweetalert.min.js"></script>

        <!-- CK Editor -->
        <!-- <script src="<?= base_url() ?>assets/ckeditor/ckeditor.js"></script> -->


        <!-- Summernote -->
        <script src="<?= base_url() ?>assets/summernote/summernote-bs4.js"></script>

        <!-- Template JS File -->
        <script src="<?= base_url() ?>assets/admin/assets/js/scripts.js"></script>
        <script src="<?= base_url() ?>assets/admin/assets/js/custom.js"></script>
        <script src="<?= base_url() ?>assets/admin/assets/js/page/bootstrap-modal.js"></script>
        <!-- <script src="<?= base_url() ?>assets/socket.io/dist/socket.io.js"></script> -->
        <script src="<?= base_url() ?>assets/js/page/admin.js"></script>
        <script src="<?= base_url() ?>assets/js/moment.js"></script>
        <script src="<?= base_url() ?>assets/js/moment-locale.js"></script>
        <script src="<?= base_url() ?>assets/js/page/<?= (isset($script)) ? $script : "" ?>.js"></script>

        <script>
            $('.summernote').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    // ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            });


            // var textareaValue = $('.summernote').summernote('code');
        </script>


        <script>
            //Get the button
            var mybutton = document.getElementById("myBtn");

            // When the user scrolls down 20px from the top of the document, show the button
            window.onscroll = function() {
                scrollFunction()
            };

            function scrollFunction() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    mybutton.style.display = "block";
                } else {
                    mybutton.style.display = "none";
                }
            }

            // When the user clicks on the button, scroll to the top of the document
            function topFunction() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            }
        </script>


        <!-- bs-custom-file-input -->
        <!-- <script src="<?= base_url() ?>assets/cust/bs-custom-file-input.min.js"></script> -->

</body>

</html>