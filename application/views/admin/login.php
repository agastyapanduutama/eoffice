    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>E-LETTER BTH </title>

        <meta name="baseUrl" content="<?= base_url() ?>">

        <!-- General CSS Files -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">

        <link rel="stylesheet" href="<?= base_url() ?>assets/fontawasome/css/fontawesome.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/fontawasome/css/all.css">

        <!-- CSS Libraries -->
        <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/admin/node_modules/bootstrap-social/bootstrap-social.css"> -->

        <!-- Template CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/admin/assets/css/style.css">
        <link rel="stylesheet" href="<?= base_url() ?>assets/admin/assets/css/components.css">
    </head>

   

    <body>
        <?php

        // $this->req->print($changelog);

        ?>
        <div id="app">
            <section class="section">
                <div class="container-fluid mt-5">
                    

                            <center>
                        <div class="col-md-7 col-sm-7 col-lg-7">
                                <div class="col-6">
                                    <div class="login-brand">
                                        <img src="<?= base_url() ?>assets/logo/yayasan.png" alt="logo" height="100">
                                    </div>

                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4>Masuk</h4>
                                        </div>

                                        <div class="card-body">
                                            <form id="formLogin">
                                                <div class="form-group">
                                                    <label for="email">Email Pengguna</label>
                                                    <input id="email" type="text" class="form-control" name="email" tabindex="1" required autofocus>
                                                    <div class="invalid-feedback">
                                                        Harap isi kolom Email
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="d-block">
                                                        <label for="password" class="control-label">Kata Sandi</label>
                                                    </div>
                                                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                                    <div class="invalid-feedback">
                                                        Harap isi kolom Kata Sandi
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                                        Login
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>

                                </div>
                        </div>
                            </center>
                    </div>
                </div>
            </section>
        </div>

        <!-- General JS Scripts -->
        <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script> -->
        <script src="<?= base_url() ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
        <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.nicescroll.min.js"></script>
        <script src="<?= base_url() ?>assets/js/moment.min.js"></script>
        <script src="<?= base_url() ?>assets/admin/assets/js/stisla.js"></script>
        <script src="<?= base_url() ?>assets/admin/assets/js/stisla.js"></script>
        <script src="<?= base_url() ?>assets/modules/sweetalert.min.js"></script>
        <script src="<?= base_url() ?>assets/js/bootstrap-show-password.min.js"></script>

        <!-- JS Libraies -->

        <!-- Template JS File -->
        <script src="<?= base_url() ?>assets/admin/assets/js/scripts.js"></script>
        <script src="<?= base_url() ?>assets/admin/assets/js/custom.js"></script>

        <!-- JS Libraies -->
        <script>
            $('#password').password();
        </script>


        <script src="<?= base_url() ?>assets/js/page/admin.js"></script>
        <script src="<?= base_url() ?>assets/js/page/<?= $script ?>.js"></script>

        <!-- Page Specific JS File -->
    </body>

    </html>