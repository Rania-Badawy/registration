<?php $query = $this->db->query("select * from setting")->row_array(); ?>
<?php
if (!$this->session->userdata('language')) {
    $this->session->set_userdata('language', 'arabic');
}
?>
<?php
$this->session->set_userdata('previous_page', uri_string());
$lang_word = 'AR';
$bootstrap = $this->session->userdata('bootstrap');
$style_loc = $this->session->userdata('style_loc');
if ($this->session->userdata('language') == 'english') {

    $lang_word = 'Ar';
    $style_loc = 'style.css';
    $bootstrap = 'bootstrap.css';
} else if ($this->session->userdata('language') == 'Arabic') {

    $lang_word = 'En';
    $style_loc = 'style_ltr.css';
    $bootstrap = 'bootstrap_ltr.css';
}
$Lang      = $this->session->userdata('language');
$school_data = $this->db->query("select ID from school_details ")->row_array();
if ($school_id) {
    $data['school_id']          = $school_id;
} else {
    $data['school_id']          = $school_data['ID'];
    $school_id                  = $school_data['ID'];
}
$data['sub_id']         = $sub_id;

$get_school_setting     = $this->db->query(" SELECT * FROM contact_us ")->row_array();
?>
<!DOCTYPE html>
<html lang="<?= ($this->session->userdata('language') == 'english') ? 'en' : 'ar' ?>">
<?php
$title        = $title ? $title : $query['SchoolName'];
$description  = $description ? $description : lang('description');
$key_word     = $key_word ? $key_word : lang('keywords');

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" Cache-Control: public>
    <meta name="description" content="<?= $description ?>">
    <meta name="keywords" content="<?= $key_word ?>">
    <meta name="author" content="<?= lang('author') ?>">
    <title><?= $title; ?></title>
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo']; ?>" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" /> -->
    <?php if ($query['ApiDbname'] == 'SchoolAccNonBisha') { ?>
        <link href="<?php echo base_url(); ?>assets/css/home_new_noon.css" rel="stylesheet">
    <?php } else { ?>
        <link href="<?php echo base_url(); ?>assets/css/home_new.css" rel="stylesheet">
    <?php } ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php if ($this->session->userdata('language') == 'english') { ?>
        <link href="<?php echo base_url(); ?>assets/css/homeltr_new.css" rel="stylesheet">
    <?php }
    ?>

    <?php if (
        substr($_SERVER['REQUEST_URI'], 0, 40) === "/home_new/student_register/register_form" || substr($_SERVER['REQUEST_URI'], 0, 40) === "/home_new/Student_register/register_form"
        || substr($_SERVER['REQUEST_URI'], 0, 28) === "/home_new/home/GetFatherDocs" || substr($_SERVER['REQUEST_URI'], 0, 28) === "/home/student_register/index" ||
        substr($_SERVER['REQUEST_URI'], 0, 29) === "/home/emp_application/index/0" || substr($_SERVER['REQUEST_URI'], 0, 26) === "/home/emp_application/show" ||
        substr($_SERVER['REQUEST_URI'], 0, 22) === "/home/student_register"
    ) {
    } else { ?>
        <script src="<?php echo base_url(); ?>assets_new/home_css/js/tornado.min.js"></script>
    <?php } ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/newSlide.css" />
    <?php if($query['ApiDbname'] == 'SchoolAccElinjaz'){?>
       <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KZ7ZR42M');</script>
        <!-- End Google Tag Manager -->
         <!-- Hotjar Tracking Code for Site 5072502 (name missing) -->
        <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:5072502,hjsv:6};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
    <?php } ?>
    <?php if($query['ApiDbname'] == 'SchoolAccAlfadeelah'){?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-RKJSL9XMG4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-RKJSL9XMG4');
    </script>
    <?php } ?>
</head>
<style>
    <? if ($query['ApiDbname'] == 'SchoolAccRowadAlgamaa') {
    ?>#seetingsBtn {
        display: none;
    }

    <?
    }

    ?><?php if ($query['ApiDbname'] == 'SchoolAccAlzahraa') {
    ?>.social-links i {
        border: 2px solid var(--main-color2);
        color: var(--main-color2);
    }

    <?php
    }

    if ($query['ApiDbname'] == 'SchoolAccAbnaAlriyada') {
    ?>.pattern {
        display: none;
    }

    .navbar-links.hiddenLinks {
        display: none;
    }

    .langandlogin span,
    .langandlogin i {
        color: white;
    }

    .navbar .nav-btn {
        display: block;
        position: absolute;
        top: 30px;
        right: 0;
    }

    .navbar img {
        display: inline-block;
        margin: 0 30px;
    }

    .navbar {
        background: <?php echo $query['head_color'] ?> !important;
        border-bottom: 1px solid <?php echo $query['head_color'] ?> !important;
    }

    .colorlink {
        color: white !important;
    }

    <?php
    } else {
    ?>.pattern {
        background-color: #3bb78f;
        background-image: linear-gradient(315deg,
                #ebf8fe 0%, #ebf8fe 74%);
    }

    .content {
        background: url("../../assets/upload_home/1.png");
        background-size: cover;
        background-repeat: no-repeat;
        padding-bottom: 10px;
    }

    <?
    }

    ?> :root {
        --main-color: <?php echo $query['main-color'] ?>;
        --main-color2: <?php echo $query['main-color2'] ?>;
    }
</style>
<?php if ($query['ApiDbname'] == 'SchoolAccTabuk') { ?>
    <style>
        .fixedNav ul li {
            width: 100px;
            height: 50px;
            text-align: center;
            line-height: 0;
        }

        .fixedNav ul li b {
            display: block;
            font-size: 11px;
        }

        .fixedIcon ul li:hover,
        .fixedNav ul li:hover {
            width: unset;
        }

        .fSpanbtn {
            display: none;
        }

        .content {
            padding-bottom: 100px !important;
        }

        @media screen and (max-width: 500px) {
            .content {
                margin-right: 1px;
            }

            .navbar {
                max-height: 85px;
                min-height: 85px;
                padding: 0 0 10px !important
            }

            .spanOpen {
                display: block;
            }

            .openDiv h1 {
                line-height: 1.7;
                margin-bottom: 50px;
            }

            .upper {
                top: 90px !important
            }

            .fixedNav ul {
                display: flex;
                justify-content: center;
                background-color: #fff
            }

            .navbar-links.hiddenLinks,
            .fixedIcon.hiddenLinks,
            .fixedNav.hiddenLinks {
                display: block;
            }

            .fNavbtn,
            .Iconbtn,
            .nav-btn,
            .fSpanbtn,
            .fNavbtn {
                display: none !important;
            }

            .openDiv {
                margin-top: 220px !important;
            }

            .langandlogin {
                right: 70px;
                position: absolute;
                left: unset
            }

            .fixedNav.hiddenLinks {
                position: fixed;
                top: 130px;
                width: 100%;
            }

            .fixedNav ul li b {
                display: block;
                font-size: 11px;
                width: 75px;
                word-wrap: break-word;
                margin: auto;
                line-height: 10px;
            }

            .fixedNav ul li {
                width: 80px;
                height: 65px;
                text-align: center;
                line-height: 0;
            }

            .fixedIcon {
                right: 0;
                top: 250px
            }

            .carousel-item.active iframe {
                width: 90% !important;
            }

            .carousel.main .carousel-item {
                width: 280px !important
            }

            .adsi {
                margin-right: 30px;
            }
        }
    </style>
<?php } ?>

<body dir="<?= ($this->session->userdata('language') == 'english') ? 'ltr' : 'rtl' ?>">
<?php if($query['ApiDbname'] == 'SchoolAccElinjaz'){?>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KZ7ZR42M"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    <?php } ?>
   
    <?php if ($query['ApiDbname'] != 'SchoolAccTabuk') { ?>
        <i class="fa fa-bars Iconbtn"></i>
        <div class="fixedIcon hiddenLinks">
            <ul>
                <?php if ($get_school_setting['facebooklink']) { ?>
                    <a target="_blank" href="<?php echo $get_school_setting['facebooklink']; ?>">
                        <li class="facebook">
                            <img src="<?php echo base_url(); ?>intro/images/social/facebook.png" style="height:30px;" />
                        </li><span class="iconDes">Facebook</span>
                    </a>
                <?php }
                if ($get_school_setting['twitterlink']) { ?>
                    <a target="_blank" href="<?php echo $get_school_setting['twitterlink']; ?>">
                        <li class="twitter">
                            <img src="<?php echo base_url(); ?>intro/images/social/twitter.png" style="height:30px;" />
                        </li>
                        <span class="iconDes">Twitter</span>
                    </a>
                <?php }
                if ($get_school_setting['youtube']) { ?>
                    <a target="_blank" href="<?php echo $get_school_setting['youtube']; ?>">
                        <li class="youtube">
                            <img src="<?php echo base_url(); ?>intro/images/social/youtube.png" style="height:30px;" />
                        </li>
                        <span class="iconDes">Youtube</span>
                    </a>
                <?php }
                if ($get_school_setting['instagramLink']) { ?>
                    <a target="_blank" href="<?php echo $get_school_setting['instagramLink']; ?>">
                        <li class="instagram">
                            <img src="<?php echo base_url(); ?>intro/images/social/insta.png" style="height:30px;" />
                        </li>
                        <span class="iconDes">Instagram</span>
                    </a>
                <?php }
                if ($get_school_setting['google-plus']) { ?>
                    <a target="_blank" href="<?php echo $get_school_setting['google-plus']; ?>">
                        <li class="google-plus"><i class="fa fa-google-plus"></i></li>
                        <span class="iconDes">Google Plus</span>
                    </a>
                <?php }
                if ($get_school_setting['tiktok']) { ?>
                    <a target="_blank" href="<?php echo $get_school_setting['tiktok']; ?>">
                        <li class="tiktok"><img src="<?php echo base_url(); ?>intro/images/social/tictok.png" style="height:30px;" /></li>
                        <span class="iconDes">Tiktok</span>
                    </a>
                <?php }
                if ($get_school_setting['linkedin']) { ?>
                    <a target="_blank" href="<?php echo $get_school_setting['linkedin']; ?>">
                        <li class="tiktok"><img src="<?php echo base_url(); ?>intro/images/social/linkedin.png" style="height:30px;" /></li>
                        <span class="iconDes">linkedin</span>
                    </a>
                <?php }
                if ($get_school_setting['web_page']) { ?>
                    <a target="_blank" href="<?php echo $get_school_setting['web_page']; ?>">
                        <li class="webpage"><i class="fa fa-globe"></i></li>
                        <?php if ($query['ApiDbname'] == 'SchoolAccTabuk') { ?>
                            <span class="iconDes">Location</span>
                        <?php } else { ?>
                            <span class="iconDes">School Page</span>
                        <?php } ?>
                    </a>
                    <?php }
                if ($get_school_setting['snapchat']) {
                    $LinkArray = $get_school_setting['snapchat'];
                    $Links = explode('||', $LinkArray);
                    $url = $Links[0];
                    $Link = explode(',', $url);
                    $Name = $Links[1];
                    $LinkName = explode(',', $Name);

                    if ($Link[1]) {
                    ?>
                        <div class="myDIVSnap">
                            <a target="_blank" data-toggle="dropdown" data-hover="dropdown" class="snapIcon">
                                <li class="snap"><img src="<?php echo base_url(); ?>intro/images/social/snap.png" style="height:30px;" /></li>
                                <span class="iconDes">Snapchat</span>
                            </a>
                            <div class="hideSnap">
                                <?php foreach ($Link as $key => $val) { ?>
                                    <div>
                                        <a href="<?php echo $val ?>" target="_blank"><?php echo $LinkName[$key] ?></a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } else {
                        if ($url) { ?>

                            <a href="<?php echo $url ?>" target="_blank">
                                <li class="snap"><img src="<?php echo base_url(); ?>intro/images/social/snap.png" style="height:30px;" /></li><span class="iconDes">Snapchat</span>
                            </a>

                <?php }
                    }
                } ?>


            </ul>
        </div>
        <!-- News Bar -->
    <?php } ?>
    <div class="navbar">
        <button class="nav-btn"><i class="fa fa-bars"></i></button>

        
        <div>
            <ul class="navbar-links hiddenLinks">
                <li>
                    <img src="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo']; ?>" style="height:65px;border-radius: 5px;margin: 0 20px;" />
                </li>
                <li class="nav-link">
                    <a class="colorlink" href="<?php if ($query['homeLink']) {
                                                    echo $query['homeLink'];
                                                } else {
                                                    echo site_url('');
                                                } ?>"><i class="fa fa-home " style="font-size: 18px;"></i></a>
                </li>
               

                                </ul>

                            </a>
                        </li>
               
            </ul>
        </div>

        <div>
           
        </div>


        <div class="langandlogin">
            <?php
            $langSession = $this->session->userdata('language');
            switch ($langSession) {
                case 'arabic':
            ?><a style="margin-left: 20px" href="<?php echo site_url('home/home/set_lang/L/1'); ?>" data-toggle="tooltip" data-placement="right" title="<?php echo $lang_word; ?>"><?= lang('en_english');
                                                                                                                                                                                        echo " "; ?>
                        <img src="<? echo base_url('intro/images/icons/lung.png'); ?>" style="width: 40px;height:40px;margin-left:50px;margin-right: 50px" /></a> <?php

                                                                                                                                                                    break;
                                                                                                                                                                case 'english':
                                                                                                                                                                    ?><a style="margin-left: 20px" href="<?php echo site_url('home/home/set_lang/L/2'); ?>" data-toggle="tooltip" data-placement="right" title="<?php echo $lang_word; ?>"><?= lang('en_english');
                                                                                                                                                                                                                                                            echo " "; ?>
                        <img src="<?php echo base_url('intro/images/icons/lung.png'); ?>" style="width: 40px;height:40px;margin-left:50px;margin-right: 50px" /></a><?php
                                                                                                                                                                    break;
                                                                                                                                                                default:
                                                                                                                                                                    ?><a style="margin-left: 20px" href="<?php echo site_url('home/home/set_lang/L/3'); ?>" data-toggle="tooltip" data-placement="right" title="<?php echo $lang_word; ?>"><?= lang('en_english');
                                                                                                                                                                                                                                                            echo " "; ?>
                        <img src="<?php echo base_url('intro/images/icons/lung.png'); ?>" style="width: 40px;height:40px;margin-left:50px;margin-right: 50px" /></a><?php
                                                                                                                                                            }
                                                                                                                                                                    ?>

            <!--<a id="login" style="margin-left: 20px" href="<?php echo site_url('home/login'); ?>"><span style="font-size: 13px;"><?php echo lang('am_login');
                                                                                                                                    echo " " ?></span><i class="fa fa-user" style="font-size: 18px;"></i></a>-->

        </div>

    </div>

    <script>
        function get_school_main(schoolid) {

            window.location = "<?php echo site_url('home_new/home/index'); ?>/" + schoolid;

        }
        const navButton = document.querySelector(".nav-btn");
        const navbarLinks = document.querySelector(".navbar-links");
        navButton.addEventListener("click", function() {
            navbarLinks.classList.toggle("hiddenLinks");
        });


        const IconButton = document.querySelector(".Iconbtn");
        const iconsLinks = document.querySelector(".fixedIcon");
        IconButton.addEventListener("click", function() {
            iconsLinks.classList.toggle("hiddenLinks");
        });
        let style = document.createElement('style');
        let position = 'left';
        style.innerHTML = `
            @keyframes moving {
                0%{
                    ${position}: -${document.querySelector('.upper p').offsetWidth + 10}px;
                }
                100%{
                    ${position}: 100%;
                }
            }`
        document.head.append(style);
    </script>

    <?php if ($query['ApiDbname'] == 'SchoolAccTabuk') { ?>
        <script>
            const fIconButton = document.querySelector(".fNavbtn");
            const ficonsLinks = document.querySelector(".fixedNav");
            fIconButton.addEventListener("click", function() {
                ficonsLinks.classList.toggle("hiddenLinks");
            });

            const fSpanbtn = document.querySelector(".fSpanbtn");
            const ficonsspans = document.querySelectorAll("b.iconDes");
            fSpanbtn.addEventListener("click", function() {
                for (var i = 0; i < ficonsspans.length; i++) {
                    ficonsspans[i].classList.toggle("hideSpan");
                }
                this.classList.toggle('fa-chevron-right');
                this.classList.toggle('fa-chevron-left');
            });
        </script>
    <?php } ?>



    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Article",
            "image": "<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo']; ?>",
            "headline": "<?= $query['SchoolName']; ?> ",
            "description": "<?= lang('description') ?>"
        }
    </script>