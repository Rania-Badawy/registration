<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <!-- Required Meta Tags -->
    <meta name="language" content="ar">
    <meta http-equiv="x-ua-compatible" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="<?= lang('description') ?>">
    <meta name="keywords" content="<?= lang('keywords') ?>">
    <meta name="author" content="<?= lang('author') ?>">
    <?php $query = $this->db->query("select * from setting")->row_array(); ?>
    <?php if ($this->session->userdata('language') != 'english') { ?>
    <title><?php echo $query['SchoolName'] ?></title>
    <?php } else { ?>
    <title><?php echo $query['SchoolEnName'] ?></title>
    <?php } ?>

    <meta name="copyright" content=" شركة الحلول الخبيرة ">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo'] ?>">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_new/home_css/css/tornado-icons.css" media="all">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_new/home_css/css/tornado-rtl.css" media="all">

    <style>
    <?php $query=$this->db->query("select * from setting")->row_array();

    ?> :root {
        --main-color: <?php echo $query['main-color'] ?>;
        --main-color2: <?php echo $query['main-color2'] ?>;
    }

    .news-bar {
        overflow: hidden;
        height: 45px;
    }

    .btns a {
        height: fit-content !important;
    }

    .portal-page .content .btns {
        max-width: 520px;
    }

    .portal-page .content .btns .btn.login {
        width: 45% !important;
    }

    .portal-page .content .btns .btn.Gstd {
        width: 48% !important;
    }

    .portal-page .content .btns .btn {
        margin: 5px 3px;
    }

    .secend {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
    }

    .secend a {
        flex-grow: 1;
    }

    .swidth {
        max-width: 138px;
        display: inline-block;
    }

    .bg-slider-outer .item::after,
    .bg-slider-outer .item::before {
        background-image: unset !important;
    }

    .item.bgImg {
        background-position: unset !important;
    }

    .portal-page .content .btns .btn.warning {
        color: #FFF;
    }

    .content h2,
    .content h1 {
        color: var(--main-color2) !important;
    }

    .btn.login.ti-user.success {
        background: var(--main-color2) !important;
    }

    

    .logo_intro{
        width: 15%;
        margin: auto;
        padding: 2%;
        border-radius: 50%;
    }
    
    @media only screen and (max-width: 600px) {
        .logo_intro{
            width: 35% !important;
        }
    }
    body, html {
  height: 100%;
}

     body {
         background-image: url("<?php echo base_url() ?>assets/background1.jpg");
         background-color: #cccccc;
          height: 100%;
          background-position: center;
          background-repeat: no-repeat;
          background-size: cover;
        }
    </style>
</head>
<div class="langandlogin" style="position: absolute;top:60px;right: 10px;z-index: 1">
            <?php
            $langSession =$this->session->userdata('language');
            switch ($langSession) {
                case 'arabic':
            ?><a style="margin-left: 20px" href="<?php echo site_url('home_new/home/set_lang/L/1'); ?>"
                data-toggle="tooltip" data-placement="right"
                title="<?php echo $lang_word; ?>"><?= lang('en_english');
                                                               echo " "; ?>
                <img src="<? echo base_url('intro/images/icons/lung.png'); ?>" style="width: 40px;height:40px;"  />
                <label style="display: inline-block;">English</label></a> <?php

                                                                                    break;
                                                                                case 'english':
                                                                                    ?><a style="margin-left: 20px"
                href="<?php echo site_url('home/home/set_lang/L/2'); ?>" data-toggle="tooltip" data-placement="right"
                title="<?php echo $lang_word; ?>"><?= lang('en_english');
                               echo " "; ?>
                    <img src="<?php echo base_url('intro/images/icons/lung.png'); ?>" style="width: 40px;height:40px;"  />
                    <label style="display: inline-block;">عربي</label></a><?php
                                                                                    break;
                                                                                default:
                                                                                    ?><a style="margin-left: 20px"
                href="<?php echo site_url('home/home/set_lang/L/3'); ?>" data-toggle="tooltip" data-placement="right"
                title="<?php echo $lang_word; ?>"><?= lang('en_english');
                                     echo " "; ?>
                <img src="<?php echo base_url('intro/images/icons/lung.png'); ?>" style="width: 40px;height:40px;" /></a><?php
                                                                            }
                                                                                    ?>

</div>
<body>
    
    <!-- Portal -->
    <div class="portal-page flexbox align-center-x align-center-y">
        
        <div class="bg-slider">
            <!-- item -->
            <div class="item" data-src="img/slide.jpg"></div>
            <!-- item -->
            <div class="item" data-src="img/slide2.jpg"></div>
            <!-- item -->
            <div class="item" data-src="img/slide3.jpg"></div>
        </div>

        <!-- Content Wraper -->
        <div class="container">
            <div class="content">
                <!-- Logo -->
                <div class="logo_intro">

                    <?php if ($query['ApiDbname'] == 'SchoolAccAndalos') { ?>
                    <img src="<?php echo base_url(); ?>intro/images/school_logo/introandalus.png" alt="" class="logo"
                        style="width: 900px;">
                    <?php } else { ?>
                    <img src="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo']; ?>" alt=""
                        class="logo">
                    <?php } ?>
                </div>
                <!-- Buttons -->
                <div class="btns flexbox align-center-x align-between">

                    <a href="<?php echo site_url('home/login'); ?>"
                        class="btn login ti-user success"><?php echo lang('login'); ?></a>

                    <div class="secend">
                
                    
                        <?php
                        
                        $reg = $this->db->query("select * from school_details ")->row_array();
                        
                        if ($query['Registration'] == 1) {
                            if ($reg['reg_type'] == 1) {
                                
                                    $reg_type = site_url('home/student_register/index');
                                    
                            } elseif ($reg['reg_type'] == 2) {
                               
                                    $reg_type = site_url('home/student_register/register_form');
                
                            }
                        ?>
                        <a class="btn ti-user-graduate lastDiv" href="<?php echo $reg_type ?>"
                            style="width:100%"><?php echo lang('am_new_student_rgst'); ?></a>
                        <?php } ?>
            
                    </div>
                </div>
                <!-- // Buttons -->
            </div>
        </div>
        <!-- // Content Wraper -->
    </div>
    <!-- // Portal -->

    <!-- Required JS Files -->
    <script src="<?php echo base_url(); ?>assets_new/home_css/js/tornado.min.js"></script>
  
</body>

</html>