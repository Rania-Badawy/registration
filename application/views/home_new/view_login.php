<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <!-- Required Meta Tags -->
    <meta name="language" content="ar">
    <meta http-equiv="x-ua-compatible" content="text/html" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="The Description of This Page Goes Right Here and its !Important" />
    <meta name="keywords" content="keywords,goes,here,for,this,web,site,its,!important,and,keep,it,dynamic" />
    <!-- Other Meta Tags -->
    <?php $query = $this->db->query("SELECT `Logo`,`SchoolName`, `SchoolEnName` FROM `setting` ")->row_array(); ?>
    <?php if ($this->session->userdata('language') != 'english') { ?>
    <title><?php echo $query['SchoolName'] ?></title>
    <?php } else { ?>
    <title><?php echo $query['SchoolEnName'] ?></title>
    <?php } ?>
    <meta name="robots" content="index, follow" />
    <meta name="copyright" content="Sitename Goes Here">
    <link rel="shortcut icon" type="image/png"
        href="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo'] ?>">
    <!-- Fetching Fonts for Speed -->
    <link rel="preload" href="fonts/tornado-icons.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="fonts/DINNextLTW23-Bold.woff" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="fonts/DINNextLTW23-Medium.woff" as="font" type="font/woff" crossorigin>
    <link rel="preload" href="fonts/DINNextLTW23-Regular.woff" as="font" type="font/woff" crossorigin>
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>login/css/tornado-icons.css" media="all">
    <?php if ($this->session->userdata('language') != 'english') { ?>
    <link href="<?php echo base_url(); ?>login/css/tornado-rtl.css" rel="stylesheet" />
    <?php } else { ?>
    <link href="<?php echo base_url(); ?>login/css/tornado.css" rel="stylesheet" />
    <?php } ?>
</head>
<style>
        .password-icon {
            position: absolute;
            /* left: 10px; */
            cursor: pointer;
            padding: 7px;
                }
    </style>
<body>
    <!-- Site Wraper -->
    <div class="login-page">
        <div class="container">
            <div class="row no-gutter full-vh row-reverse align-center-y">
                <!-- Login Block -->
                <div class="login-block col-12 col-m-6 col-l-4 form-ui">
                    <div class="content-box">
                        <!-- Icon -->
                        <form id="login_form" method="post" class="login100-form ">
                            <i class="icon"><img
                                    src="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo'] ?>"
                                    alt=""></i>
                            <!-- Title -->
                            <h4 class="tx-align-center secondary mb15"><?php echo lang('br_login_home'); ?></h4>
                            <?php if ($this->session->flashdata('msg')) { ?>
                            <div class="alert danger tx-align-center"><?php echo $this->session->flashdata('msg'); ?>
                            </div> 
                            <?php } ?>
                            <hr class="max210 block-center mb15">
                            <!-- Form Control -->
                            <label for=""><?php echo lang('br_User_Name'); ?></label>
                            <div class="control-icon ti-user">
                                <input type="text" class="validate input100" name="username" id="icon_prefix-2"
                                minlength="4" maxlength="50" value="<?php echo set_value('username'); ?>" required>
                            </div>
                            <!-- Form Control -->
                            <label for=""><?php echo lang('br_Password'); ?></label>
                            <div class="control-icon ti-lock" style="display: flex;justify-content: flex-end;">
                            <i class="ti-eye password-icon" onclick="myFunction()"></i>
                                <input class="input100" type="password" name="password" id="icon_prefix-3"
                                minlength="4" maxlength="50" value="<?php echo set_value('password'); ?>" required >
                                
                            </div>

                            <!--<center><div>-->
                            <!--<div class="g-recaptcha" data-sitekey="6Le10sIeAAAAAGiSrgaZhT-KGuGrSPvDG3tdivrF" data-callback="enableUserBtn"></div>-->
                            <!--</div></center>-->
                            <!--<br>id="enableUserBtn"-->
                            <!-- Button -->
                            <button type="submit"
                                class="btn primary block-lvl mb"><?php echo lang('br_login_home'); ?></button>
                            <!-- Link -->
                        </form>
                        <a class="tx-align-center block-lvl"
                            href="<?= site_url('home/login/reset_pass') ?>"><?php echo lang('br_reset_pass'); ?></a>
                    </div>
                </div>
                <!-- // Login Block -->
            </div>
        </div>
    </div>
    <!-- // Site Wraper -->

    <!-- Required JS Files -->
    <script src="<?php echo base_url(); ?>assets_new/js/tornado.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
    function myFunction() {
        var passwordInput = document.getElementById('icon_prefix-3');
        var eyeIcon = document.querySelector('.password-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('ti-eye');
            eyeIcon.classList.add('ti-eye-off');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('ti-eye-off');
            eyeIcon.classList.add('ti-eye');
        }
    }

    document.getElementById("enableUserBtn").disabled = true;

    function enableUserBtn() {
        document.getElementById("enableUserBtn").disabled = false;
    }
    </script>
</body>

</html>