<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Data Tanah Pemerintah Kota Palangka Raya</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/app/css/bootstrap.css" />

    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Raleway:400,700&display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?= base_url() ?>public/app/css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="<?= base_url() ?>public/app/css/responsive.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url() ?>public/admin/vendors/mapboxgl/mapbox-gl.css">
</head>

<body>
    <div class="lds-circle">
        <div></div>
    </div>
    <div class="hero_area">
        <!-- header section strats -->
        <header class="header_section">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container">
                    <div class="navbar-collapse" id="">
                        <ul class="navbar-nav justify-content-between">
                            <div class="User_option">
                                <li class="">
                                    <a class="mr-4" href="login">
                                        Login
                                    </a>
                                </li>
                            </div>
                        </ul>
                        <div class="custom_menu-btn">
                            <button onclick="openNav()">
                                <span class="s-1">
                                </span>
                                <span class="s-2">
                                </span>
                                <span class="s-3">
                                </span>
                            </button>
                        </div>
                        <div id="myNav" class="overlay">
                            <div class="overlay-content">
                                <a href="login">Login</a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- end header section -->
        <!-- slider section -->
        <section class="slider_section ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 offset-md-1">
                        <div class="detail-box">
                            <h1>
                                <span> Data Tanah</span> <br>
                                Pemkot Palangka Raya
                            </h1>
                            <p>
                                Website data kepemilikan tanah pemerintah kota palangka raya
                            </p>
                            <div class="btn-box">
                                <a href="" class="">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end slider section -->
    </div>

    {CONTENT}
    <!-- info section -->
    <section class="info_section ">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="info_contact">
                        <h5>
                            About Us
                        </h5>
                        <div>
                            <div class="img-box">
                                <img src="<?= base_url() ?>public/app/images/location.png" width="18px" alt="">
                            </div>
                            <p>
                                Address
                            </p>
                        </div>
                        <div>
                            <div class="img-box">
                                <img src="<?= base_url() ?>public/app/images/phone.png" width="12px" alt="">
                            </div>
                            <p>
                                +01 1234567890
                            </p>
                        </div>
                        <div>
                            <div class="img-box">
                                <img src="<?= base_url() ?>public/app/images/mail.png" width="18px" alt="">
                            </div>
                            <p>
                                demo@gmail.com
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info_info">
                        <h5>
                            Information
                        </h5>
                        <p>
                            ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                        </p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info_form ">
                        <div class="social_box">
                            <a href="">
                                <img src="<?= base_url() ?>public/app/images/fb.png" alt="">
                            </a>
                            <a href="">
                                <img src="<?= base_url() ?>public/app/images/twitter.png" alt="">
                            </a>
                            <a href="">
                                <img src="<?= base_url() ?>public/app/images/linkedin.png" alt="">
                            </a>
                            <a href="">
                                <img src="<?= base_url() ?>public/app/images/youtube.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end info_section -->

    <!-- footer section -->
    <section class="container-fluid footer_section ">
        <div class="container">
            <p>
                &copy; <span id="displayYear"></span> All Rights Reserved By
                <a href="https://html.design/">KP 2022</a>
            </p>
        </div>
    </section>
    <!-- end  footer section -->


    <script type="text/javascript" src="<?= base_url() ?>public/app/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>public/app/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>public/admin/vendors/mapboxgl/mapbox-gl.js"></script>


    <script>
        const base_url = `<?= base_url() ?>`;
    </script>
    <script type="text/javascript" src="<?= base_url() ?>public/app/js/custom.js"></script>
    <script>

    </script>
</body>


</html>