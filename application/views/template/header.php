<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo base_url() . "/favicon/" ?>apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url() . "/favicon/" ?>apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url() . "/favicon/" ?>apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url() . "/favicon/" ?>apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo base_url() . "/favicon/" ?>apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo base_url() . "/favicon/" ?>apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo base_url() . "/favicon/" ?>apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo base_url() . "/favicon/" ?>apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="<?php echo base_url() . "/favicon/" ?>favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="<?php echo base_url() . "/favicon/" ?>favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="<?php echo base_url() . "/favicon/" ?>favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?php echo base_url() . "/favicon/" ?>favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="<?php echo base_url() . "/favicon/" ?>favicon-128.png" sizes="128x128" />
    <meta name="application-name" content="&nbsp;" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="mstile-310x310.png" />
    <link rel="stylesheet" media="all" href="<?php echo base_url() . "/public/css/hamburgers.min.css?v=" . rand() ?>">
    <link rel="stylesheet" media="all" href="<?php echo base_url() . "/public/css/wtf-forms.css?v=" . rand() ?>">
    <link rel="stylesheet" media="all" href="<?php echo base_url() . "/public/css/main.css?v=" . rand() ?>">
    <link rel="stylesheet" media="all" href="<?php echo base_url() . "/public/css/animate.css?v=" . rand() ?>">
    <script type="text/javascript" src="<?php echo base_url() . "/public/js/jquery.min.js?v=" . rand() ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . "/public/js/main.js?v=" . rand() ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . "/public/js/wow.min.js?v=" . rand() ?>"></script>
    <script type="text/javascript">
        //loadingpage();
    </script>
    <title>Blog Template</title>
    <meta name="description" content="Blog" />
</head>

<body>

    <!-- <div id="page-preload"><img src="<?php //echo base_url('public/images/logo--black.png') 
                                            ?>" class='logo-preload'></div> -->

    <header class='header'>
        <div class='header__container'>
            <div class='menu menu--mobile'>
                <?php
                if (sizeof($menu) > 0) {
                ?>
                    <ul class='level-1'>
                        <?php
                        foreach ($menu as $voice) {
                        ?>
                            <li class='voice'>
                                <a href='/<?= $voice['cat_slug'] ?>'><?= $voice['cat_name'] ?></a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                <?php
                }
                ?>
            </div>
            <div class="hamburger">
                <div class="hamburger-box">
                    <div class="hamburger-inner"></div>
                </div>
            </div>
            <div class='logo'>
                <a href="/">
                    <img src="<?php echo base_url('public/images/logo.png') ?>" />
                </a>
            </div>
            <div class='menu'>
                <?php
                if (sizeof($menu) > 0) {
                ?>
                    <ul class='level-1'>
                        <?php
                        foreach ($menu as $voice) {
                        ?>
                            <li class='voice'>
                                <a href='/<?= $voice['cat_slug'] ?>'><?= $voice['cat_name'] ?></a>
                            </li>
                        <?php
                        }
                        ?>
                        <li class='voice'>
                            <a href='/login'><img src="<?php echo base_url('public/images/ico-login.png') ?>" /></a>
                        </li>
                    </ul>
                <?php
                }
                ?>
            </div>
        </div>
    </header>