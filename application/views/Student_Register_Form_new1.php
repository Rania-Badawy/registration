<?php $query = $this->db->query("select * from setting")->row_array(); ?>
<?php
$home_theme = $query['home_theme'];
if ($home_theme) {
    include('home_new/' . $home_theme . '/header.php');
} else {
    include('home_new/header.php');
}
?>
<?php $queryCode = $this->db->query("SELECT `country_code`,time_zone FROM `school_details` GROUP BY `country_code`")->row_array(); ?>

<!--//header-->
<?php if ($this->session->userdata('language') != 'english') { ?>
    <title><?= lang('am_RegistrationForm') ?></title>
<?php } else { ?>
    <title><?= lang('am_RegistrationForm') ?></title>
<?php } ?>
<link rel="icon" type="images/x-icon" href="<?= base_url() ?>intro/images/school_logo/<?php echo $query['Logo'] ?>" />

<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap -->
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">

<!-- theme rtl -->
<?php if ($this->session->userdata('language') != 'english') { ?>
    <link href="<?php echo base_url(); ?>css/rtl.css" rel="stylesheet">
<?php } else { ?>
    <link href="<?php echo base_url(); ?>css/ltr.css" rel="stylesheet">
<?php } ?>
<!-- default theme -->
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>breakingNews/breakingNews.css" rel="stylesheet">
<!-- default theme -->
<link href="<?php echo base_url(); ?>css/themes/<?php echo $query['home_theme'] ?>" rel="stylesheet">
<!-- style for radio checkbox  -->
<link href="<?php echo base_url(); ?>css/build.css" rel="stylesheet">

<!-- font-awesome -->
<link href="<?php echo base_url(); ?>css/font-awesome.css" rel="stylesheet">

<!-- font-awesome -->
<link href="<?php echo base_url(); ?>css/font-awesome-animation.css" rel="stylesheet">
<!-- animate -->
<link href="<?php echo base_url(); ?>css/animate.css" rel="stylesheet">

<!-- chocolat -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/chocolat.css" type="text/css" media="screen" charset="utf-8" />

<!-- Owl Carousel Assets -->
<link href="<?php echo base_url(); ?>css/owl.carousel.css" rel="stylesheet">

<!-- bootstrap-dropdownhover -->
<link href="<?php echo base_url(); ?>css/bootstrap-dropdownhover.css" rel="stylesheet">

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/featherlight.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/register_style.css" />
<!-- Modernizr -->
<script src="<?php echo base_url(); ?>js/modernizr.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-2.1.1.js"></script>
<script src="<?php echo base_url(); ?>js/sweetalert2.js"></script>
<!--///////////-->

<?php //print_r($get_levels);die;  
?>
<div style="color:red" id="recaptchaMsg"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<?php $settingQuery = $this->db->query("select * from setting")->row_array(); ?>
<?php $setting = $this->db->query("SELECT * FROM `form_setting` WHERE form_type = 1")->result(); ?>
<?php $SchoolName  = ($this->session->userdata('language') == 'english') ? $query['SchoolEnName'] : $query['SchoolName']; ?>
<link href="https://fonts.cdnfonts.com/css/neo-sans-arabic?styles=50556,50562" rel="stylesheet">

<style>
    <?php if ($this->ApiDbname == "SchoolAcclittlecaterpillars") { ?>.register_form_content .control-label,
    .panel_regist_all .panel-regist {
        color: #000;
    }

    <?php } ?>.row,
    .flexbox,
    .flex-box,
    .flexbox.container,
    .flex-box.container,
    .form-repeater .repeater-item,
    .form-group,
    .modal-box .modal-content .modal-footer,
    #lightbox-modal .modal-content,
    .secondary-header,
    #plan-table table .table tbody td {
        display: block !important;
    }

    .tab-content {
        display: block !important;
    }

    .datepicker.dropdown-menu {
        top: 717.309px;
        left: 373.889px;
        RIGHT: auto;
    }

    #input-wrapper .wrapper_lable {
        z-index: 99;
        line-height: 25px;
        padding: 1px;
        margin: 3px 80% 0px 0px;
        direction: ltr;
        width: fit-content;
        border-right: groove;
        position: absolute;
    }

    #input-wrapper label {
        margin-top: 40px;
    }

    #input-wrapper input {
        text-indent: 45px;
        direction: ltr;
        position: absolute;
    }

    .btn_regist,
    .btn_regist_Previous,
    input.btn_regist {
        background: var(--main-color);
        color: #fff;
    }

    .btn_regist_Previous {
        float: right;
    }

    .hedddin {
        display: none;
    }

    body {
        margin: 0;
        font-family: 'Neo Sans Arabic', sans-serif;
        font-weight: 300;
        font-size: 1.25rem;
    }

    .datepicker-days {
        width: 200px;
        display: table-footer-group;
        direction: ltr;
    }

    .datepicker.dropdown-menu {
        min-width: 200px !important;
        margin-top: 19px;
    }

    .table-condensed {
        width: 100%;
    }

    form,
    p {
        margin: 10px;
    }

    p.note {
        font-size: 1rem;
        color: red;
    }

    input,
    textarea {
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 4px;
        font-family: 'Lato';
        width: 300px;
        margin-top: 10px;
    }

    label {
        width: 300px;
        font-weight: bold;
        display: inline-block;
        margin-top: 20px;
    }

    label span {
        font-size: 1rem;
    }

    label.error {
        color: red;
        font-size: 1rem;
        display: block;
        margin-top: 5px;
        position: absolute;
    }

    input.error,
    textarea.error {
        border: 1px dashed red;
        font-weight: 300;
        color: red;
    }

    [type="submit"],
    [type="reset"],
    button,
    html [type="button"] {
        margin-left: 0;
        border-radius: 0;
        background: black;
        color: white;
        border: none;
        font-weight: 300;
        padding: 10px 0;
        line-height: 1;
    }

    <?php if ($setting[43]->display == 1) {
    ?>.nav-tabs>li {
        width: 25%;
    }

    <?php
    }

    ?>@media(max-width:992px) {
        .nav-tabs>li {
            width: 50%;
        }
    }

    @media(max-width:600px) {
        .nav-tabs>li {
            width: 100%;
        }

        .nav-tabs.nav-tabs-ddds {
            font-size: 16px;
            overflow: hidden;
        }

        #input-wrapper .wrapper_lable {
            margin: 0 86% 0px 0px;
        }
    }

    .top-bar,
    .nav-bar,
    footer {
        display: none;
    }

    .tab-content span.danger {
        color: red;
    }

    .tab-content .btn-primary,
    .tab-content .btn-primary:active,
    .tab-content .btn-primary:hover,
    .tab-content .btn-primary:focus,
    .tab-content .btn-primary:hover:focus {
        color: #fff;
        background-color: #1f64a4;
        border-color: #1f64a4;
        font-family: 'Neo Sans Arabic', sans-serif !important;
    }

    .tab-content .btn-danger,
    .tab-content .btn-danger:active,
    .tab-content .btn-danger:hover,
    .tab-content .btn-danger:focus,
    .tab-content .btn-danger:hover:focus {
        color: #fff;
        background-color: #a9122a;
        border-color: #a9122a;
    }

    .nav-tabs.nav-tabs-ddds>li a {
        padding: 5px 0;
        width: 100%;
        height: 70px;
        margin: 20px auto;
        border-radius: 0;
        text-align: center;
        line-height: 70px;
        border: 0;
        color: #333 !important;
        font-family: 'sukar', sans-serif !important;
        ;
    }

    h5,
    label {
        font-size: 17px !important;
    }

    .container-dd {
        margin-top: 180px
    }

    .nav-tabs.nav-tabs-ddds>li {
        float: right;
    }

    .nav-tabs.nav-tabs-ddds>li.active {
        background-color: var(--main-color) !important;
    }

    .nav-tabs.nav-tabs-ddds>li.active a {
        color: #fff !important;
        background-color: transparent !important;
    }

    .nav-tabs.nav-tabs-ddds {
        border: 1px solid #ddd;
        padding: 0px;
        font-family: 'Neo Sans Arabic', sans-serif !important;
        font-size: 19px;
    }

    .nav-tabs li.active:after {
        border-bottom-color: #fff !important;
    }

    <?php if ($this->ApiDbname == "SchoolAccAdvanced" || $this->ApiDbname == "SchoolAccJeelAlriyada") {
    ?>.navbar {
        display: none;
    }

    <?php
    }

    ?>.list-group-item-text {
        text-align: center
    }

    <?php if ($lang != 'english') {
    ?>.container-dd {
        direction: rtl !important;
        min-height: 900px;
    }

    .nav-tabs.nav-tabs-ddds>li {
        float: right !important;
    }

    <?php
    } else {
    ?>.container-dd {
        direction: ltr !important;
    }

    .nav-tabs.nav-tabs-ddds>li {
        float: left !important;
    }

    .btn_regist {
        float: right;
    }

    .btn_regist_Previous {
        float: left;
    }

    <?php
    }

    ?>.lang_st {
        text-decoration: none;
        background: #2a3b66;
        height: 30px;
        display: inline-block;
        width: 120px;
        text-align: center;
        line-height: 30px;
        color: #fff;
        border-radius: 10px;
        text-decoration: none;
    }

    .lang_st:hover {
        text-decoration: none;
        color: #FFF;
    }

    #SchoolData,
    .news-bar {
        display: none;
    }

    #school_id {
        visibility: hidden;
        opacity: 0;
    }

    .title_register h5 {
        color: #000;
    }

    .parent {
        background-color: #f9f9f9;
        padding-bottom: 25px;
        padding-top: 10px;
        padding-right: 30px
    }

    .steps {
        display: flex;
        justify-content: space-between;
        margin-top: 60px;
        position: relative;
    }

    .steps>div.step {
        width: 20%;
    }

    .stepTitle {
        display: flex;
        justify-content: space-evenly;
    }

    .step span {
        display: inline-block;
        width: 35px;
        height: 35px;
        text-align: center;
        line-height: 35px;
        color: #fff;
        font-weight: bold;
        border-radius: 4px;
    }

    .step:first-of-type span {
        background: #8ada57;
    }

    .step:nth-of-type(2) span {
        background: #e1a914;
    }

    .step:nth-of-type(3) span {
        background: #5a6dc9;
    }

    .step:nth-of-type(4) span {
        background: #3dbcab;
    }

    .done,
    .dtwo,
    .dthree {
        border-top: 2px dotted gray;
        position: absolute;
        right: 15%;
        top: -40px;
        border-right: 2px dotted gray;
        border-left: 2px dotted gray;
        width: 295px;
        height: 40px;
    }

    .dtwo {
        border-top: 0;
        border-bottom: 2px dotted gray;
        right: 42%;
        top: 37px;
        height: 60px;
    }

    .dthree {
        left: 45px;
        height: 40px;
        right: unset;
    }

    .mainP {
        text-align: center;
        margin-bottom: 15px;
        color: #1e9ea1;
        font-size: 20px;
        font-weight: bold;
    }

    .step ul li {
        list-style-type: circle !important;
        font-size: 13px;
        max-width: 140px;
    }

    .step ul ::marker {
        color: #1e9ea1
    }

    @media screen and (max-width: 600px) {
        .upper {
            top: 50px;
        }

        .fixedNav.hiddenLinks {
            top: 90px;
        }

        .done,
        .dtwo,
        .dthree {
            width: 105px;
        }

        .done {
            right: 17%;
        }

        .dtwo {
            right: 44%;
        }

        .dthree {
            left: 5px;
        }

        .dtwo {
            height: 50px;
        }

        .steps ul {
            margin: 0;
            padding: 0;
        }

        .step {
            width: 22%;
        }

        .container-dd {
            padding: 25px 15px;
        }

        .step ul li {
            font-size: 7px;
        }

        .parent {
            padding-right: 10px
        }
    }
</style>
<?php if ($lang == 'english') { ?>
    <style>
        .done,
        .dtwo,
        .dthree {
            left: 15%;
            right: unset;
        }

        .done {
            width: 305px
        }

        .dtwo {
            left: 43%;
            right: unset;
            width: 290px;
        }

        .dthree {
            right: 53px;
            left: unset;
            width: 280px;
        }

        .mainP {
            text-align: center;
            margin-bottom: 15px;
            color: #1e9ea1;
            font-size: 25px;
            /*font-weight: bold;*/
        }

        .parent {
            padding-left: 10px;
            padding-right: unset
        }
    </style>
<?php } ?>
<div class="loading_div" id="loadingDiv"></div>
<?php $query = $this->db->query("select * from setting")->row_array(); ?>
<div class="container container-dd">
    <div class="row">
    <?php if ($this->ApiDbname == "SchoolAccAdvanced" || $this->ApiDbname == "SchoolAccSinwan" || $this->ApiDbname == "SchoolAccJeelAlriyada") { ?>
        <div class="col-md-12" >
           
                <?php
            $langSession = $this->session->userdata('language');
            switch ($langSession) {
                case 'arabic':
            ?><a style="margin-left: 20px" href="<?php echo site_url('home_new/home/set_lang/L/1'); ?>" data-toggle="tooltip" data-placement="right" title="<?php echo $lang_word; ?>"><?= lang('en_english');
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
           
        </div>
 <?php } ?>



        <a target="_blank" class="btn" href="<?= base_url('home/student_register/check_code/' . $lang) ?>" style="float: left;background: var(--main-color);color: #fff;width: fit-content"><?php echo lang('am_new_student_Check_Code'); ?></a>
        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
            <img src="<?= base_url() ?>intro/images/school_logo/<?php echo $query['Logo'] ?>" class="mt-20" width="120" />
            <? if ($settingQuery['ApiDbname'] == 'SchoolAccTanmia') { ?>
            <div>    
                <a href="tel:920007686">الرقم الموحد 920007686</a>
            </div>
            <?php } ?>
            <? if ($settingQuery['ApiDbname'] == 'SchoolAccAndalos') { ?>
                <img src="<?= base_url() ?>intro/images/school_logo/andalus_alamya.png" class="mt-20" width="80" />
                <img src="<?= base_url() ?>intro/images/school_logo/logo2.png" class="mt-20" width="120" />
                <? } ?>
            <h3 style="margin-bottom: 35px;"><?= lang('am_RegistrationForm') ?></h3>
        </div>
    </div>
    <ul class="nav nav-tabs nav-tabs-ddds" <?php if ($this->ApiDbname != "SchoolAccExpert") { ?> style="display:none !important" <?php } ?>>
        <li class="active">
            <a href="#tab1" data-toggle="tab">
                <h4 class="list-group-item-heading btnNext"><?= lang('am_frist_stap') ?></h4>
                <p class="list-group-item-text"> <?= lang('am_father_information') ?></p>
            </a>
        </li>
        <li>
            <a href="#tab2" data-toggle="tab">
                <h4 class="list-group-item-heading btnNext"><?= lang('am_frist_second'); ?></h4>
                <p class="list-group-item-text"> <?= lang('am_student_information'); ?></p>

            </a>
        </li>
        <?php if ($setting[43]->display == 1) { ?>
            <li>
                <a href="#tab4" data-toggle="tab">
                    <h4 class="list-group-item-heading btnNext"><?= lang('am_third_step'); ?></h4>
                    <p class="list-group-item-text"> <?= lang('am_student_psy'); ?> </p>

                </a>
            </li>
        <?php } ?>
        <li>
            <a href="#tab3" data-toggle="tab">
                <h4 class="list-group-item-heading btnNext">
                    <?php if ($setting[43]->display == 0) {
                        echo lang('am_third_step');
                    } else {
                        echo lang('am_forth_step');
                    } ?>
                </h4>
                <p class="list-group-item-text"> <?= lang('am_Registration'); ?> </p>

            </a>
        </li>
    </ul>
    <?php if ($this->ApiDbname == "SchoolAccTabuk") { ?>
        <p class="mainP"><?php echo lang('er_step_registration') ?> <?php echo $SchoolName ?></p>
        <div class="parent">
            <div class="steps">
                <div class="step">
                    <div class="stepTitle">

                        <h5 style="color: #8ada57;"><?= lang('am_Registration'); ?></h5>
                        <span>1</span>
                    </div>
                    <div>
                        <ul>
                            <li><?= lang('er_fill_form'); ?> </li>
                        </ul>
                    </div>
                </div>
                <div class="step">
                    <div class="stepTitle">
                        <h5 style="color: #e1a914;"><?= lang('er_interview_exam'); ?></h5>
                        <span>2</span>
                    </div>
                    <div>
                        <ul>
                            <li><?= lang('er_message_father'); ?></li>
                            <li> <?= lang('er_Conduct_interview_exam'); ?></li>
                        </ul>
                    </div>
                </div>
                <div class="step">
                    <div class="stepTitle">
                        <h5 style="color: #5a6dc9;"> <?= lang('er_Contract_fees'); ?></h5>
                        <span>3</span>
                    </div>
                    <div>
                        <ul>
                            <li><?= lang('er_Signing_contracts'); ?> </li>
                            <li><?= lang('er_Payment_fees'); ?> </li>
                            <li> <?= lang('er_student_file'); ?> </li>
                        </ul>
                    </div>
                </div>
                <div class="step">
                    <div class="stepTitle">
                        <h5 style="color: #3dbcab;"><?= lang('er_final_accept'); ?> </h5>
                        <span>4</span>
                    </div>
                    <div>
                        <ul>
                            <li><?= lang('er_Receive_message'); ?> </li>
                        </ul>
                    </div>
                </div>

                <div class="done"></div>
                <div class="dtwo"></div>
                <div class="dthree"></div>
            </div>
        </div>
    <?php } ?>
    <?php if ($this->session->flashdata('ErrorAdd')) { ?>
        <div class="alert alert-danger" style="font-size: x-large; text-align: center;">
            <?php
            echo $this->session->flashdata('ErrorAdd'); ?>
        </div>
    <?php } else if ($this->session->flashdata('SuccessAdd')) { ?>
        <div class="alert alert-success" style="font-size: x-large; text-align: center;">
            <?php echo $this->session->flashdata('SuccessAdd'); ?>
        </div>
    <?php } ?>
    <?php if ($this->session->flashdata('Failuer') != "") { ?>
        <div class="alert alert-danger" style="font-size: x-large; text-align: center;">

            <div class="alert danger"><?php echo $this->session->flashdata('Failuer'); ?> </div>
        </div>
    <?php } ?>



    <form action="<?= site_url('home/student_register/NewRegister'); ?>" method="post" id="registration-form" style="margin:25px 10px" autocomplete="off">
        <div class="tab-content">
            <!--    Tab1    -->
            <div class="tab-pane active" id="tab1">
                <div class="col-xs-12 p-0">
                    <div class="col-md-12 p-0">
                        <div class="row">
                            <div class="col-xs-12 title_register">
                                <h5><i class="fa fa-house-chimney-user" aria-hidden="true"></i><?= lang('am_basic_data') ?></h5>
                            </div>
                            <?php if ($setting[20]->display == 1) { ?>
                                <div class="form-group col-md-12 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-2 col-sm-12 col-xs-12"> <?= lang('student_name') ?> <span class="danger">*</span></label>
                                    <div class="col-md-10 col-sm-12 col-xs-12 p-0" style="display: flex;">
                                        <div class="col-md-4" style="padding: 0;">
                                            <input type="text" id="name<?= $addStudentValue ?>" placeholder="<?= lang('student_name') ?>" name="name[<?= $addStudentValue ?>]" <?php if ($this->ApiDbname == "SchoolAccAdvanced" || $this->ApiDbname == "SchoolAccTanmia") { ?> onblur="showAlert();" <?php } ?> onkeyup="checkLnag($(this), 'ar');" maxlength="12" value="<?= set_value('name[]'); ?>" onkeyup="$('#std'+<?= $addStudentValue ? $addStudentValue : 0 ?>).html($(this).val()+' '+$('#parent_name').val());" class="form-control" required>
                                        </div>
                                        <div class="col-md-4" style="padding: 0;">
                                            <input type="text" id="name2" placeholder="<?= lang('father_name') ?>" name="name2" onkeyup="checkLnag($(this), 'ar');" maxlength="12" value="<?= set_value('name2'); ?>" onkeyup="$('#std'+<?= $addStudentValue ? $addStudentValue : 0 ?>).html($(this).val()+' '+$('#parent_name').val());" class="form-control" required>
                                        </div>
                                        <div class="col-md-4" style="padding: 0;">
                                            <input type="text" id="name3" placeholder="<?= lang('grandba_name') ?>" name="name3" onkeyup="checkLnag($(this), 'ar');" maxlength="12" value="<?= set_value('name3'); ?>" onkeyup="$('#std'+<?= $addStudentValue ? $addStudentValue : 0 ?>).html($(this).val()+' '+$('#parent_name').val());" class="form-control" required>
                                        </div>
                                        <?php if ($setting[115]->display == 1) { ?>
                                            <div class="col-md-4" style="padding: 0;">
                                                <input type="text" id="name4" placeholder="<?= lang('grandba_name2') ?>" name="name4" onkeyup="checkLnag($(this), 'ar');" maxlength="12" value="<?= set_value('name4'); ?>" onkeyup="$('#std'+<?= $addStudentValue ? $addStudentValue : 0 ?>).html($(this).val()+' '+$('#parent_name').val());" class="form-control" <?php if ($setting[115]->required ==  1) {
                                                                                                                                                                                                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                                                                                                                                                                                                        } ?>>
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-4" style="padding: 0;">
                                            <input type="text" id="name5" placeholder="<?= lang('family_name') ?>" name="name5" onkeyup="checkLnag($(this), 'ar');" maxlength="12" value="<?= set_value('name5'); ?>" onkeyup="$('#std'+<?= $addStudentValue ? $addStudentValue : 0 ?>).html($(this).val()+' '+$('#parent_name').val());" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[1]->display == 1) { ?>
                                <div class="form-group col-md-12 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-2 col-sm-12 col-xs-12"><?php echo lang('student_name_en'); ?><?php if ($setting[1]->required == 1) {
                                                                                                                                        echo '<span class="danger">*</span>';
                                                                                                                                    } ?></label>
                                    <div class="col-md-10 col-sm-12 col-xs-12 p-0" style="display: flex;">
                                        <div class="col-md-4" style="padding: 0;">
                                            <input type="text" id="frist_name_eng<?= $addStudentValue ?>" placeholder="<?= lang('student_name') ?>" name="frist_name_eng[<?= $addStudentValue ?>]" maxlength="12" onkeyup="checkLnag($(this), 'en');" value="<?= set_value('frist_name_eng[]'); ?>" class="form-control" <?php if ($setting[1]->required == 1) {
                                                                                                                                                                                                                                                                                                                                echo 'required';
                                                                                                                                                                                                                                                                                                                            } ?>>
                                        </div>
                                        <div class="col-md-4" style="padding: 0;">
                                            <input type="text" id="frist_name_eng2" placeholder="<?= lang('father_name') ?>" name="frist_name_eng2" maxlength="12" onkeyup="checkLnag($(this), 'en');" value="<?= set_value('frist_name_eng2'); ?>" class="form-control" <?php if ($setting[1]->required == 1) {
                                                                                                                                                                                                                                                                                echo 'required';
                                                                                                                                                                                                                                                                            } ?>>
                                        </div>
                                        <div class="col-md-4" style="padding: 0;">
                                            <input type="text" id="frist_name_eng3" placeholder="<?= lang('grandba_name') ?>" name="frist_name_eng3" maxlength="12" onkeyup="checkLnag($(this), 'en');" value="<?= set_value('frist_name_eng3'); ?>" class="form-control" <?php if ($setting[1]->required == 1) {
                                                                                                                                                                                                                                                                                echo 'required';
                                                                                                                                                                                                                                                                            } ?>>
                                        </div>
                                        <?php if ($setting[115]->display == 1) { ?>
                                            <div class="col-md-4" style="padding: 0;">
                                                <input type="text" id="frist_name_eng4" placeholder="<?= lang('grandba_name2') ?>" name="frist_name_eng4" maxlength="12" onkeyup="checkLnag($(this), 'en');" value="<?= set_value('frist_name_eng4'); ?>" class="form-control" <?php if ($setting[1]->required == 1 && $setting[115]->required == 1) {
                                                                                                                                                                                                                                                                                    echo 'required';
                                                                                                                                                                                                                                                                                } ?>>
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-4" style="padding: 0;">
                                            <input type="text" id="frist_name_eng5" placeholder="<?= lang('family_name') ?>" name="frist_name_eng5" maxlength="12" onkeyup="checkLnag($(this), 'en');" value="<?= set_value('frist_name_eng5'); ?>" class="form-control" <?php if ($setting[1]->required == 1) {
                                                                                                                                                                                                                                                                                echo 'required';
                                                                                                                                                                                                                                                                            } ?>>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[22]->display == 1) { ?>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('br_student_NumberID') ?> <span class="danger">*</span></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="student_NumberID" name="student_NumberID[<?= $addStudentValue ?>]" value="<?= set_value('student_NumberID[]'); ?>" <?php if ($this->ApiDbname == "SchoolAccAdvanced") { ?> maxlength="10" <?php } else { ?> maxlength="14" <?php } ?> minlength="10" class="arabicNumbers form-control" required>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[2]->display == 1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('br_father_NumberID') ?><span class="danger">*</span></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="ParentNumberID" name="ParentNumberID" value="<?= set_value('ParentNumberID'); ?>" <?php if ($this->ApiDbname == "SchoolAccAdvanced") { ?> maxlength="10" <?php } else { ?> maxlength="14" <?php } ?> minlength="10" class="form-control arabicNumbers" required>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[5]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('am_Nationality') ?>
                                        <?php if ($setting[5]->required ==  1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <select id="parent_national_ID" name="parent_national_ID" class="form-control" <?php if ($setting[5]->required ==  1) {
                                                                                                                            echo 'required';
                                                                                                                        } ?>>
                                            <option value=""><?= lang('am_select') ?></option>

                                            <?php
                                            if ($settingQuery['ApiDbname'] != 'SchoolAccMadac') {

                                                foreach ($get_nationality as $item) {

                                            ?>

                                                    <option value="<?= $item->NationalityId; ?>" <?php echo set_select('parent_national_ID', $item->NationalityName, (!empty($data) && $data == $item->NationalityName ? TRUE : FALSE)); ?>>
                                                        <?= $item->NationalityName; ?></option>
                                                <?php }
                                            } else {

                                                $nationality = $this->db->query("SELECT * FROM `name_space` WHERE `HR_ID` = " . $item->NationalityId . " AND `Parent_ID` = 1")->result();
                                                foreach ($nationality as $na) {
                                                    if ($_SESSION['language'] == 'arabic') {
                                                        $name = $na->Name;
                                                    } else {
                                                        $name = $na->Name_En;
                                                    }
                                                ?>

                                                    <option value="<?= $item->NationalityId; ?>" <?php echo set_select('parent_national_ID', $name, (!empty($data) && $data == $name ? TRUE : FALSE)); ?>>
                                                        <?= $name; ?></option>

                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[6]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('father_mobile') ?>
                                        <span class="danger">*</span></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0" id="input-wrapper">

                                        <label class="wrapper_lable" for="number"><?= $queryCode['country_code'] ?></label>
                                        <input type="text" id="parent_mobile" name="parent_mobile" value="<?= set_value('parent_mobile'); ?>" <?php  if($queryCode['time_zone']=='Asia/Riyadh'){ ?>maxlength="9" <?php }else{?>maxlength="11"<?php } ?> minlength="9" class="form-control arabicNumbers zero" required>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[3]->display == 1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('br_fa_Email') ?><?php if ($setting[3]->required == 1) {
                                                                        echo '<span class="danger">*</span>';
                                                                    } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_email" name="parent_email" value="<?= set_value('parent_email'); ?>" maxlength="50" class="form-control" <?php if ($setting[3]->required ==  1) {
                                                                                                                                                                                    echo 'required';
                                                                                                                                                                                } ?>>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 title_register">
                                <h5><i class="fa fa-user" aria-hidden="true"></i><?= lang('am_father_data') ?></h5>
                            </div>
                            <input type="hidden" id="Reg_ID" name="Reg_ID" value="<?= $Reg_ID; ?>" class="form-control">
                            <input type="hidden" id="ApiDbname" name="ApiDbname" value="<?= $ApiDbname; ?>" class="form-control">

                            <?php if ($setting[48]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('am_number_type') ?><?php if ($setting[48]->required == 1) {
                                                                            echo '<span class="danger">*</span>';
                                                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <select class="form-control" id="parent_type_Identity" name="parent_type_Identity" <?php if ($setting[48]->required ==  1) {
                                                                                                                                echo 'required';
                                                                                                                            } ?>>
                                            <?php
                                            if ($get_identities) {
                                                foreach ($get_identities as $identity) {
                                            ?>
                                                    <option value="<?= $identity->Value ?>">
                                                        <?= $_SESSION['language'] == 'arabic' ? $identity->Text : $identity->TextEn ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[49]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('am_number_identity') ?>
                                        <?php if ($setting[49]->required == 1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_source_identity" name="parent_source_identity" value="<?= set_value('parent_source_identity'); ?>" maxlength="50" class="form-control" <?php if ($setting[49]->required ==  1) {
                                                                                                                                                                                                                    echo 'required';
                                                                                                                                                                                                                } ?>>
                                    </div>
                                </div>
                            <?php } ?>
                            <script type="text/javascript" src="<?php echo base_url(); ?>datepicker/js/bootstrap-datepicker.js"></script>
                            <link rel="stylesheet" href="<?php echo base_url(); ?>datepicker/css/datepicker.css" type="text/css" />
                            <?php if ($setting[97]->display == 1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('br_BirhtDate') ?><?php if ($setting[97]->required == 1) {
                                                                        echo '<span class="danger">*</span>';
                                                                    } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="father_brith_date" name="father_brith_date" value="<?= set_value('father_brith_date'); ?>" class="form-control" <?php if ($setting[97]->required == 1) {
                                                                                                                                                                                    echo 'required';
                                                                                                                                                                                } ?>>

                                    </div>
                                </div>
                            <?php } ?>





                            <?php if ($setting[4]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('am_EducationalQualification') ?>
                                        <?php if ($setting[4]->required ==  1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <select class="form-control" id="parent_educational_qualification" name="parent_educational_qualification" <?php if ($setting[4]->required == '1') {
                                                                                                                                                        echo 'required';
                                                                                                                                                    } ?>>
                                            <option value=""><?= lang('am_select') ?></option>
                                           
                                            <?php
                                            if ($get_educations) {
                                                foreach ($get_educations as $education) {

                                            ?>

                                                    <option value="<?= $education->Value ?>">
                                                        <?php if ($lang == 'arabic') {
                                                            echo $education->Text;
                                                        } else {
                                                            echo $education->TextEn;
                                                        } ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <!--New-->
                            <?php if ($setting[58]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('am_parent_religion') ?>
                                        <?php if ($setting[58]->required ==  1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <select id="par_religion" name="par_religion" class="form-control" <?php if ($setting[58]->required ==  1) {
                                                                                                                echo 'required';
                                                                                                            } ?>>
                                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                                            <?php
                                            if ($religion) {
                                                foreach ($religion as $rel) {
                                                    if ($settingQuery['ApiDbname'] == 'SchoolAccMadac') { ?>
                                                        <option value="<?= $rel->Value ?>">
                                                            <?php if ($rel->Text == 1) {
                                                                echo lang('Muslim');
                                                            } else {
                                                                echo lang('not_Muslim');
                                                            } ?>
                                                        </option>
                                                    <?php } else { ?>
                                                        <option value="<?= $rel->Value ?>"><?= $rel->Value ?></option>
                                            <?php    }
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[7]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?php if ($this->ApiDbname == "SchoolAccDigitalCulture") {
                                            echo lang('br_discount_code');
                                        } else {
                                            echo lang('na_mobile_2');
                                        } ?>
                                        <?php if ($setting[7]->required ==  1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0" <?php if ($this->ApiDbname != "SchoolAccDigitalCulture") { ?> id="input-wrapper" <?php } ?>>
                                        <?php if ($this->ApiDbname != "SchoolAccDigitalCulture") { ?> <label class="wrapper_lable" for="number"><?= $queryCode['country_code'] ?></label>
                                        <?php } ?>
                                        <input type="text" id="parent_mobile2" name="parent_mobile2" value="<?= set_value('parent_mobile2'); ?>" <?php if ($this->ApiDbname != "SchoolAccDigitalCulture") { ?> <?php  if($queryCode['time_zone']=='Asia/Riyadh'){ ?>maxlength="9" <?php }else{?>maxlength="11"<?php } ?> minlength="9" class="arabicNumbers form-control zero" <?php } else { ?> class="form-control" <?php } ?> <?php if ($setting[7]->required ==  1) {
                                                                                                                                                                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                                                                                                                                                                        } ?>>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($setting[8]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('am_phone_home') ?>
                                        <?php if ($setting[8]->required ==  1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_phone" name="parent_phone" value="<?= set_value('parent_phone'); ?>" maxlength="14" minlength="7" class="arabicNumbers form-control" <?php if ($setting[8]->required ==  1) {
                                                                                                                                                                                                                echo 'required';
                                                                                                                                                                                                            } ?>>
                                    </div>
                                </div>
                            <?php } ?>
                           

                            <?php if ($setting[9]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('am_Work_Phone') ?><?php if ($setting[9]->required ==  1) {
                                                                                                                                echo '<span class="danger">*</span>';
                                                                                                                            } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_phone2" name="parent_phone2" value="<?= set_value('parent_phone2'); ?>" maxlength="14" minlength="7" class="arabicNumbers form-control" <?php if ($setting[9]->required ==  1) {
                                                                                                                                                                                                                    echo 'required';
                                                                                                                                                                                                                } ?>>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($setting[10]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('am_The_job') ?>
                                        <?php if ($setting[10]->required ==  1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_profession" name="parent_profession" value="<?= set_value('parent_profession'); ?>" maxlength="50" class="form-control" <?php if ($setting[10]->required ==  1) {
                                                                                                                                                                                                    echo 'required';
                                                                                                                                                                                                } ?>>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($setting[11]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('br_work_Address') ?>
                                        <?php if ($setting[11]->required ==  1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input id="parent_work_address" name="parent_work_address" value="<?= set_value('parent_work_address'); ?>" maxlength="255" class="form-control" <?php if ($setting[11]->required ==  1) {
                                                                                                                                                                            echo 'required';
                                                                                                                                                                        } ?>>
                                    </div>
                                </div>
                            <?php } ?>
                            <!--////new-->
                            <?php if ($setting[56]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?php echo lang('am_emergency_number'); ?>
                                        <?php if ($setting[56]->required ==  1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="emergency_number" name="emergency_number" value="<?= set_value('emergency_number'); ?>" <?php if ($this->ApiDbname != "SchoolAccDigitalCulture") { ?> maxlength="14" minlength="7" <?php } ?> class="form-control arabicNumbers" <?php if ($setting[56]->required ==  1) {
                                                                                                                                                                                                                                                                                                    echo 'required';
                                                                                                                                                                                                                                                                                                } ?>>
                                    </div>
                                </div>
                            <?php } ?>
                            <!--////new-->
                            <?php if ($setting[50]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('Fathers_certificate_picture') ?>
                                        <?php if ($setting[50]->required == 1) {
                                            echo '<span class="danger">*</span>';
                                        } ?>
                                    </label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input name="father_upload" type="file" id="father_upload" onchange="upload_file2($(this), 'father_certificate')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[50]->required ==  1) {
                                                                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                                                                        } ?>>
                                        <input type="hidden" name="father_certificate" id="father_certificate" <?php if ($setting[50]->required ==  1) {
                                                                                                                    echo 'required';
                                                                                                                } ?>>
                                    </div>
                                </div>
                                <!--////new-->
                            <?php }
                            if ($setting[51]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content ">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('Fathers_ID_photo') ?><?php if ($setting[51]->required == 1) {
                                                                                                                                    echo '<span class="danger">*</span>';
                                                                                                                                } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input name="father_national_upload" type="file" id="father_national_upload" onchange="upload_file2($(this), 'father_national_id')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[51]->required ==  1) {
                                                                                                                                                                                                                                                                echo 'required';
                                                                                                                                                                                                                                                            } ?>>
                                        <input type="hidden" name="father_national_id" id="father_national_id" <?php if ($setting[51]->required ==  1) {
                                                                                                                    echo 'required';
                                                                                                                } ?>>
                                    </div>
                                </div>
                            <?php }
                            if ($setting[66]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content ">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('Fathers_ID_photo2') ?><?php if ($setting[66]->required == 1) {
                                                                                                                                    echo '<span class="danger">*</span>';
                                                                                                                                } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input name="father_national_upload2" type="file" id="father_national_upload2" onchange="upload_file2($(this), 'father_national_id2')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[66]->required ==  1) {
                                                                                                                                                                                                                                                                    echo 'required';
                                                                                                                                                                                                                                                                } ?>>
                                        <input type="hidden" name="father_national_id2" id="father_national_id2" <?php if ($setting[66]->required ==  1) {
                                                                                                                        echo 'required';
                                                                                                                    } ?>>
                                    </div>
                                </div>
                                <!--////new-->
                            <?php }
                            if ($setting[52]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content ">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('Fathers_birth_certificate') ?><?php if ($setting[52]->required == 1) {
                                                                                                                                            echo '<span class="danger">*</span>';
                                                                                                                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input name="father_brith_upload" type="file" id="father_brith_upload" onchange="upload_file2($(this), 'father_brith_certificate')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[52]->required ==  1) {
                                                                                                                                                                                                                                                                echo 'required';
                                                                                                                                                                                                                                                            } ?>>
                                        <input type="hidden" name="father_brith_certificate" id="father_brith_certificate" <?php if ($setting[52]->required ==  1) {
                                                                                                                                echo 'required';
                                                                                                                            } ?>>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php $query_mother = $this->db->query("SELECT * FROM `form_setting` WHERE `form_type` = 1 and type='M' and display=1 ")->result();
                            if (!empty($query_mother)) {
                            ?>
                                <div class="col-xs-12 title_register mt-20">
                                    <h5><i class="fa fa-female" aria-hidden="true"></i><?php if ($this->ApiDbname == "SchoolAccDigitalCulture") {
                                                                                            echo lang('am_another_contact');
                                                                                        } else {
                                                                                            echo lang('am_mother_data');
                                                                                        } ?>
                                    </h5>
                                </div>
                            <?php } ?>
                            <?php if ($setting[12]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('am_name') ?>
                                        <?php if ($setting[12]->required == 1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" name="mother_name" value="<?= set_value('mother_name'); ?>" onkeyup="checkLnag($(this), 'ar');" class="form-control" <?php if ($setting[12]->required ==  1) {
                                                                                                                                                                                    echo 'required';
                                                                                                                                                                                } ?>>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[68]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('am_name_eng') ?>
                                        <?php if ($setting[68]->required == 1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" name="mother_name_eng" onkeyup="checkLnag($(this), 'en');" value="<?= set_value('mother_name_eng'); ?>" class="form-control" <?php if ($setting[68]->required ==  1) {
                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                        } ?>>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($setting[47]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('am_ID_Number') ?>
                                        <?php if ($setting[47]->required == 1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="MotherNumberID" name="MotherNumberID" value="<?= set_value('MotherNumberID'); ?>" maxlength="14" minlength="10" class="form-control arabicNumbers" <?php if ($setting[47]->required ==  1) {
                                                                                                                                                                                                                        echo 'required';
                                                                                                                                                                                                                    } ?>>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($setting[13]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('am_mother_educationa') ?>
                                        <?php if ($setting[13]->required == 1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <select class="form-control" name="mother_educational_qualification" <?php if ($setting[13]->required ==  1) {
                                                                                                                    echo 'required';
                                                                                                                } ?>>
                                            <option value=""><?= lang('am_select') ?></option>
                                            <?php
                                            if ($get_educations) {

                                                foreach ($get_educations as $education) {
                                            ?>
                                                    <option value="<?= $education->Value ?>">
                                                        <?php if ($lang == 'arabic') {
                                                            echo $education->Text;
                                                        } else {
                                                            echo $education->TextEn;
                                                        } ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <!--new-->
                            <?php if ($setting[57]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('am_mother_religion') ?>
                                        <?php if ($setting[57]->required ==  1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <select id="moth_religion" name="moth_religion" class="form-control" <?php if ($setting[57]->required ==  1) {
                                                                                                                    echo 'required';
                                                                                                                } ?>>
                                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                                            <?php
                                            if ($religion) {
                                                foreach ($religion as $rel) {
                                                    if ($settingQuery['ApiDbname'] == 'SchoolAccMadac') { ?>
                                                        <option value="<?= $rel->Value ?>">
                                                            <?php if ($rel->Text == 1) {
                                                                echo lang('Muslim');
                                                            } else {
                                                                echo lang('not_Muslim');
                                                            } ?>
                                                        </option>
                                                    <?php } else { ?>
                                                        <option value="<?= $rel->Value ?>"><?= $rel->Value ?></option>
                                            <?php    }
                                                }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[14]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('am_The_job') ?><?php if ($setting[14]->required ==  1) {
                                                                        echo '<span class="danger">*</span>';
                                                                    } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_profession_mather" name="parent_profession_mather" value="<?= set_value('parent_profession'); ?>" maxlength="50" class="form-control" <?php if ($setting[14]->required ==  1) {
                                                                                                                                                                                                                echo 'required';
                                                                                                                                                                                                            } ?>>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($setting[15]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('am_mother_work') ?><?php if ($setting[15]->required ==  1) {
                                                                            echo '<span class="danger">*</span>';
                                                                        } ?>
                                    </label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" name="mother_work" class="form-control" minlength="5" <?php if ($setting[15]->required ==  1) {
                                                                                                                        echo 'required';
                                                                                                                    } ?>>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($setting[16]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('na_mobile') ?><?php if ($setting[16]->required ==  1) {
                                                                    echo '<span class="danger">*</span>';
                                                                } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0" id="input-wrapper">
                                        <label class="wrapper_lable" for="number"><?= $queryCode['country_code'] ?></label>
                                        <input type="text" name="mother_mobile" value="<?= set_value('mother_mobile'); ?>" class="arabicNumbers form-control zero" <?php  if($queryCode['time_zone']=='Asia/Riyadh'){ ?>maxlength="9" <?php }else{?>maxlength="11"<?php } ?> minlength="9" <?php if ($setting[16]->required == 1) {
                                                                                                                                                                                                    echo 'required';
                                                                                                                                                                                                } ?>>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($setting[17]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('am_mother_work_phone') ?><?php if ($setting[17]->required ==  1) {
                                                                                echo '<span class="danger">*</span>';
                                                                            } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" name="mother_work_phone" class="arabicNumbers form-control" maxlength="11" minlength="7" <?php if ($setting[17]->required ==  1) {
                                                                                                                                                        echo 'required';
                                                                                                                                                    } ?>>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if ($setting[18]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('am_mother_email') ?><?php if ($setting[18]->required ==  1) {
                                                                            echo '<span class="danger">*</span>';
                                                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" name="mother_email" class="form-control" <?php if ($setting[18]->required ==  1) {
                                                                                                        echo 'required';
                                                                                                    } ?>>
                                    </div>
                                </div>

                                <!--new-->
                            <?php }
                            if ($setting[53]->display ==  1) {
                            ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content ">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('mother_certificate_picture') ?><?php if ($setting[53]->required ==  1) {
                                                                                                                                            echo '<span class="danger">*</span>';
                                                                                                                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input name="mother_certificate_upload" type="file" id="mother_certificate_upload" onchange="upload_file2($(this), 'mother_certificate')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[53]->required ==  1) {
                                                                                                                                                                                                                                                                    echo 'required';
                                                                                                                                                                                                                                                                } ?>>
                                        <input type="hidden" name="mother_certificate" id="mother_certificate" <?php if ($setting[53]->required ==  1) {
                                                                                                                    echo 'required';
                                                                                                                } ?>>
                                    </div>
                                </div>
                                <!--new-->
                            <?php }
                            if ($setting[54]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content ">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('mother_ID_photo') ?><?php if ($setting[54]->required ==  1) {
                                                                                                                                echo '<span class="danger">*</span>';
                                                                                                                            } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input name="mother_national_upload" type="file" id="mother_national_upload" onchange="upload_file2($(this), 'mother_national_id')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[54]->required ==  1) {
                                                                                                                                                                                                                                                                echo 'required';
                                                                                                                                                                                                                                                            } ?>>
                                        <input type="hidden" name="mother_national_id" id="mother_national_id" <?php if ($setting[54]->required ==  1) {
                                                                                                                    echo 'required';
                                                                                                                } ?>>
                                    </div>
                                </div>
                            <?php }
                            if ($setting[67]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content ">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('mother_ID_photo2') ?><?php if ($setting[67]->required ==  1) {
                                                                                                                                    echo '<span class="danger">*</span>';
                                                                                                                                } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input name="mother_national_upload2" type="file" id="mother_national_upload2" onchange="upload_file2($(this), 'mother_national_id2')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[54]->required ==  1) {
                                                                                                                                                                                                                                                                    echo 'required';
                                                                                                                                                                                                                                                                } ?>>
                                        <input type="hidden" name="mother_national_id2" id="mother_national_id2" <?php if ($setting[67]->required ==  1) {
                                                                                                                        echo 'required';
                                                                                                                    } ?>>
                                    </div>
                                </div>
                                <!--new-->
                            <?php }
                            if ($setting[55]->display ==  1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content ">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"><?= lang('mother_birth_certificate') ?><?php if ($setting[55]->required ==  1) {
                                                                                                                                            echo '<span class="danger">*</span>';
                                                                                                                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input name="mother_brith_upload" type="file" id="mother_brith_upload" onchange="upload_file2($(this), 'mother_brith_certificate')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[55]->required ==  1) {
                                                                                                                                                                                                                                                                echo 'required';
                                                                                                                                                                                                                                                            } ?>>
                                        <input type="hidden" name="mother_brith_certificate" id="mother_brith_certificate" <?php if ($setting[55]->required ==  1) {
                                                                                                                                echo 'required';
                                                                                                                            } ?>>
                                    </div>
                                </div>



                            <?php }
                            if ($setting[19]->display == 1) { ?>
                                <div class="col-xs-12 title_register mt-20">
                                    <h5><i class="fa fa-database" aria-hidden="true"></i><?= lang('am_general_data') ?></h5>
                                </div>
                                
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" style="font-size: 11px;"><?= lang('am_how_school') ?>
                                        <?php if ($setting[19]->required == 1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <select id="how_school" name="how_school" class="form-control" <?php if ($setting[19]->required ==  1) {
                                                                                                            echo 'required';
                                                                                                        } ?>>
                                            <option value=""><?= lang('am_select') ?></option>
                                            <?php foreach ($get_how_school as $item_how_school) { ?>
                                                <option value="<?= $item_how_school->ID; ?>" <?php echo set_select('how_school', $item_how_school->Name, (!empty($data) && $data == $item_how_school->Name ? TRUE : FALSE)); ?>>
                                                    <?= $item_how_school->Name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[44]->display == 1 || $setting[45]->display == 1 || $setting[46]->display == 1) { ?>
                                <div class="col-xs-12 title_register mt-20">
                                    <h5><i class="fa fa-database" aria-hidden="true"></i><?= lang('Communication') ?></h5>
                                    <h8 class="subtitle-regist"><?= lang('Communication_hint') ?></h8>
                                </div>
                                <div class="clearfix"></div>
                                <br>
                            <?php } ?>
                            <?php if ($setting[44]->display == 1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" style="font-size: 11px;"><?php if ($this->ApiDbname == "SchoolAccUniversitySchools") {
                                                                                                                            echo lang('Educational_affairs');
                                                                                                                        } else {
                                                                                                                            echo lang('Academic_Issues');
                                                                                                                        } ?>
                                        <?php if ($setting[44]->required == 1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <select id="Academic_Issues" name="Academic_Issues" class="form-control" <?php if ($setting[44]->required ==  1) {
                                                                                                                        echo 'required';
                                                                                                                    } ?>>
                                            <option value=""><?= lang('am_select') ?></option>
                                            <option value="1"><?= lang('father only') ?></option>
                                            <option value="2"><?= lang('only mother') ?></option>
                                            <option value="3"><?= lang('both') ?></option>
                                            <option value="4"><?= lang('other') ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[45]->display == 1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" style="font-size: 11px;"><?= lang('Admin_Issues') ?>
                                        <?php if ($setting[45]->required == 1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <select id="Admin_Issues" name="Admin_Issues" class="form-control" <?php if ($setting[45]->required ==  1) {
                                                                                                                echo 'required';
                                                                                                            } ?>>
                                            <option value=""><?= lang('am_select') ?></option>
                                            <option value="1"><?= lang('father only') ?></option>
                                            <option value="2"><?= lang('only mother') ?></option>
                                            <option value="3"><?= lang('both') ?></option>
                                            <option value="4"><?= lang('other') ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[46]->display == 1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12" style="font-size: 11px;"><?= lang('Finance_Issues') ?>
                                        <?php if ($setting[46]->required == 1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <select id="Finance_Issues" name="Finance_Issues" class="form-control" <?php if ($setting[46]->required ==  1) {
                                                                                                                    echo 'required';
                                                                                                                } ?>>
                                            <option value=""><?= lang('am_select') ?></option>
                                            <option value="1"><?= lang('father only') ?></option>
                                            <option value="2"><?= lang('only mother') ?></option>
                                            <option value="3"><?= lang('both') ?></option>
                                            <option value="4"><?= lang('other') ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="clearfix"></div>
                            <?php if ($this->ApiDbname == "SchoolAccAtlas") { ?>
                                <h5 style="color:red" class="subtitle-regist"><?= lang('am_res_studentExit') ?></h5>
                            <?php } else { ?>
                                <h5 style="color:red" class="subtitle-regist" <?php if ($this->ApiDbname == "SchoolAccDigitalCulture") { ?>hidden <?php } ?>>
                                    <?= lang('am_Responsible_son_head') ?></h5>
                            <?php } ?>
                            <div class="clearfix"></div>
                            <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content" <?php if ($this->ApiDbname == "SchoolAccDigitalCulture") { ?>style="visibility: hidden !important;" <?php } ?>>
                                <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                    <?= lang('am_Name_manager') ?><span class="danger">*</span> </label>
                                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                    <input type="text" id="person_name" name="person_name" value="<?= set_value('person_name'); ?>" maxlength="50" class="form-control" onkeyup="checktext($(this));">
                                </div>
                            </div>
                            <input type="hidden" name="DbName" id="DbName" value="<?php echo $this->ApiDbname; ?>">
                            <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content" <?php if ($this->ApiDbname == "SchoolAccDigitalCulture") { ?>style="visibility: hidden !important;" <?php } ?>>
                                <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                    <?= lang('am_number_id_manager') ?> <span class="danger">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                    <input type="text" id="person_NumberID" name="person_NumberID" value="<?= set_value('person_NumberID'); ?>" <?php if ($this->ApiDbname == "SchoolAccAdvanced") { ?> maxlength="10" <?php } else { ?> maxlength="14" <?php } ?> minlength="10" class="arabicNumbers form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content" <?php if ($this->ApiDbname == "SchoolAccDigitalCulture") { ?>style="visibility: hidden !important;" <?php } ?>>
                                <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                    <?= lang('am_number_manager') ?> <span class="danger">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12 p-0" id="input-wrapper">
                                    <label class="wrapper_lable" for="number"><?= $queryCode['country_code'] ?></label>
                                    <input type="text" id="person_mobile" name="person_mobile" value="<?= set_value('person_mobile'); ?>" <?php  if($queryCode['time_zone']=='Asia/Riyadh'){ ?>maxlength="9" <?php }else{?>maxlength="11"<?php } ?> minlength="9" class="arabicNumbers form-control">
                                </div>
                            </div>
                            <?php if ($setting[70]->display == 1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('Responsible_character') ?>
                                        <?php if ($setting[70]->required == 1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0" id="">
                                        <input type="text" id="person_relative" name="person_relative" value="<?= set_value('person_relative'); ?>" maxlength="50" class="form-control" <?php if ($setting[70]->required ==  1) {
                                                                                                                                                                                            echo 'required';
                                                                                                                                                                                        } ?>>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($setting[71]->display == 1) { ?>
                                <div class="form-group col-md-4 col-sm-12 col-xs-12 register_form_content">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('kg_picture') ?>
                                        <?php if ($setting[71]->required == 1) {
                                            echo '<span class="danger">*</span>';
                                        } ?></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0" id="">
                                        <input name="kg_picture1" type="file" id="kg_picture1" onchange="upload_file2($(this), 'kg_picture')" accept="image/*,.pdf" class="form-control" style="padding-top:5px !important" <?php if ($setting[71]->required ==  1) {
                                                                                                                                                                                                                                echo 'required';
                                                                                                                                                                                                                            } ?>>
                                        <input type="hidden" name="kg_picture" id="kg_picture" <?php if ($setting[71]->required ==  1) {
                                                                                                    echo 'required';
                                                                                                } ?>>

                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-12 text-left mt-20 p-0">
                        <a class="btn btnNext btn_regist"><?= lang('am_Next') ?></a>
                    </div>
                </div>
            </div>
            <!--    Tab2    -->
            <div class="tab-pane" id="tab2">
                <div class="col-xs-12 p-0">
                    <div id="load_student_data"><?= $this->load->view('Student_Register_Form_LoadData') ?></div>
                    <div class="col-md-12 text-left mt-20 p-0">
                        <a class="btn btnPrevious btn_regist_Previous"><?= lang('am_previous') ?></a>
                        <a class="btn btnNext btn_regist"> <?= lang('am_Next') ?> </a>
                    </div>
                </div>
            </div>
            <!--    Tab3    -->
            <div class="tab-pane" id="tab4">
                <div class="col-xs-12 p-0">
                    <div id="load_student_psy"><?= $this->load->view('Student_Register_Form_Psy') ?></div>
                    <div class="col-md-12 text-left mt-20 p-0">
                        <a class="btn btnPrevious btn_regist_Previous"><?= lang('am_previous') ?></a>
                        <a class="btn btnNext btn_regist"> <?= lang('am_Next') ?></a>
                    </div>
                </div>
            </div>
            <!--    Tab4    -->
            <div class="tab-pane" id="tab3">
                <div class="col-xs-12 p-0">

                    <div class="row">
                        <div>
                            <?php if ($setting[60]->display == 1) { ?>
                                <p>
                                    <span style="color: #333333; font-size: large; font-weight: 500;">
                                        <?= lang('config_register') ?>
                                        <br><br>

                                        <?php if ($this->ApiDbname != "SchoolAccDigitalCulture") { ?>
                                            <input type="radio" id="allowphoto" name="allowphoto" value="1" style="width:auto;" <?php if ($setting[60]->required == 1) {
                                                                                                                                    echo 'required';
                                                                                                                                } ?>>
                                            <?= lang('na_accept') ?>

                                            <input type="radio" id="allowphoto2" name="allowphoto" value="0" style="width:auto;"> <?= lang('disagree') ?>
                                        <?php } else { ?>
                                            <input type="checkbox" id="allowphoto" name="allowphoto" value="1" style="width:auto;" <?php if ($setting[60]->required == 1) {
                                                                                                                                        echo 'required';
                                                                                                                                    } ?>>
                                            <?= lang('na_accept') ?>
                                        <?php } ?>
                                    </span>
                                </p>
                            <?php } ?>

                            <p class="text-justify" style="line-height: 50px;font-size: 20px;">
                                <?php if ($this->ApiDbname == "SchoolAccAdvanced") {
                                    echo lang('config_register1');
                                } else {
                                    echo lang('am_txtnew_dew');
                                } ?>
                            </p>

                            <div class="col-md-12 p-0">

                                <div class="clearfix"></div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content mt-20">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12">
                                        <?= lang('am_Signature') ?>
                                        <span class="danger">*</span></label>
                                    <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="Signature" name="Signature" value="<?= set_value('Signature'); ?>" class="form-control" required>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-12 text-left mt-20 p-0">
                            <a class="btn btnPrevious btn_regist_Previous"><?= lang('am_previous') ?></a>
                            <input type="submit" id="save" class="btn  btn_regist" value="<?= lang('registration') ?>" style="width:auto;margin:0;font-family: sukar">
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>
</div>
<script>
    $('#save').click(function(e) {
        var ApiDbname = $("#ApiDbname").val();
        if (ApiDbname == "xxx") {
            var parent_mobile = $("#parent_mobile").val();
            var ParentNumberID = $("#ParentNumberID").val();
            var pwd;

            if (parent_mobile) {
                e.preventDefault();
                $.ajax({
                    url: '<?php echo site_url(); ?>' + '/home/student_register/add_message/' +
                        parent_mobile + "/" + ParentNumberID,
                    type: "GET",
                    dataType: "json",

                    success: function(data) {
                        while (pwd == null) pwd = prompt("Please enter the confirmation code", "");

                        if (data != pwd) {

                            alert("الكود غير متطابق");

                            check_message(data);


                        } else {
                            $('#registration-form').unbind('submit').submit();

                        }

                    }


                });
            }
        }
    });

    function check_message(data) {

        var pwd;

        while (pwd == null) pwd = prompt("Please enter the confirmation code", "");

        if (data != pwd) {

            alert("الكود غير متطابق");

            check_message(data);


        } else {
            $('#registration-form').unbind('submit').submit();

        }

    }
</script>
<script type="text/javascript">
    var img = null;

    function upload_file2(fileInput, name) {
        $("#loadingDiv").show();
        var fd = new FormData();
        var files = fileInput[0].files[0];
        fd.append('userfile', files);
        $.ajax({
            url: '<?= site_url('home/student_register/do_upload') ?>',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#loadingDiv").hide();
                if (response.success == 1) {
                    img = response.img;
                    $('#' + name).val(img);
                } else {
                    alert(response.msg);
                }
            }
        });
    }
</script>
<script type="text/javascript">
    var addStudentValue = 1;
    $(".addStudent").click(function(event) {
        event.preventDefault();
        $.ajax({
            url: '<?php echo site_url(); ?>' + '/home/student_register/getStudentView/' + addStudentValue,
            type: "get",
            dataType: "html",
            success: function(data) {
                $('#load_student_data').append(data);
                addStudentValue++;
            }
        });
    });

    function addStudentPsy() {
        $.ajax({
            url: '<?php echo site_url(); ?>' + '/home/student_register/getStudentPsy/' + (addStudentValue),
            type: "get",
            dataType: "html",
            success: function(data) {
                $('#load_student_psy').append(data);
            }
        });
    }
</script>
<script type="text/javascript">
    function showAlert(input, lang) {

        var newLine = "\r\n"

        var
            message = "تنبيه !! ";
        message += newLine;
        message += "يرجى كتابة اسم الطالب الأول فقط وعدم كتابة كامل الاسم";
        message += newLine;
        message += "اسم الطالب الأول :محمد ✅ ";
        message += newLine;
        message += "اسم الطالب كامل : محمد احمد محمد ❌";
        alert(message);

    }

    function showAlert1(input, lang) {

        var newLine = "\r\n"

        var
            message = " عزيزي العميل  ";
        message += newLine;
        message += "( مهم جدًا )";
        message += newLine;
        message += "هنا يتم تعبئة بيانات (الأب) حسب الهوية الوطنية .";
        message += newLine;
        message += "وضع بيانات غير بيانات (الأب) حسب الهوية الوطنية لن يتم تسجيل الطالب لعدم صحة البيانات .";

        alert(message);


    }

    function checkLnag(input, lang) {
        var userInput = input.val();

        if (lang == 'ar') {
            let regex = /^[؀-ۿ ]+$/;
            let regex1 = /[{٠-٩}]/;
            if (userInput.match(regex1) || !userInput.match(regex)) {
                input.val('');
            }
        } else {
            let regex = /[\u0600-\u06FF\u0750-\u077F^0-9{٠-٩}]/;
            if (userInput.match(regex)) {
                input.val('');
            }
        }
    }

    function checktext(input) {
        var userInput = input.val();

        let regex = /[{0-9}]/;
        let regex1 = /[{٠-٩}]/;
        if (userInput.match(regex1) || userInput.match(regex)) {
            input.val('');
        }

    }
</script>
<script>
function updatePersonName() {
    var name2 = $('#name2').val();
    var name3 = $('#name3').val();
    var name4 = $('#name4').val();
    var name5 = $('#name5').val();
    if(name4){
        var fullName = name2 + ' ' + name3 + ' ' + name4 + ' ' + name5;
    }else{
        var fullName = name2 + ' ' + name3 + ' ' + name5;
    }
    $('#person_name').val(fullName);

    var ApiDbname = $("#ApiDbname").val();
    if (ApiDbname == "SchoolAccRemas") {
        $('#Signature').val(fullName);
    }
}

$('#name2, #name3, #name4, #name5').on('input', updatePersonName);
</script>
<script>
    $(document).ready(function() {
        $("#loadingDiv").hide();

        $('#parent_name').on('input', function(e) {
            var txtVal = $(this).val();
            var ApiDbname = $("#ApiDbname").val();
            $('#person_name').val(txtVal);
            if (ApiDbname == "SchoolAccRemas") {
                $('#Signature').val(txtVal);
            }
        });

        $('#ParentNumberID').on('input', function(e) {
            var txtVal = $(this).val();
            var val_number = toEnglishNumber(txtVal)
            $('#person_NumberID').val(val_number);
        });
        $('#parent_mobile').on('input', function(e) {
            var txtVal = $(this).val();
            var val_number = toEnglishNumber(txtVal)
            $('#person_mobile').val(val_number);
        });
    });

    var transportRules = {
        transport_address: {
            required: true,
        },
        transport_type: {
            required: true,
        }
    };


    $('.btnNext').click(function() {
        var ApiDbname = $("#ApiDbname").val();
        var form = $("#registration-form");
        form.validate({
            rules: {
                parent_name: {

                    minlength: 15,
                    maxlength: 70
                },
                parent_name_eng: {

                    minlength: 15,
                    maxlength: 70
                },
                ParentNumberID: {

                    number: true,

                    maxlength: 14
                },
                parent_type_Identity: {
                    maxlength: 250,
                },
                parent_source_identity: {
                    maxlength: 50,
                },
                parent_email: {
                    email: true,
                    maxlength: 50,
                },
                'parent_educational_qualification': {

                    maxlength: 255,
                },
                'mother_educational_qualification': {


                },
                parent_national_ID: {

                    maxlength: 255
                },
                parent_mobile: {

                    number: true,

                },

                parent_phone: {
                    number: true,
                    number: true,

                },
                parent_access_station: {
                    maxlength: 255
                },
                parent_house_number: {
                    maxlength: 11
                },
                parent_region: {
                    maxlength: 255
                },
                parent_profession: {
                    maxlength: 50
                },
                parent_profession_mather: {

                    maxlength: 50
                },
                mother_work: {

                    maxlength: 50
                },
                parent_work_address: {
                    maxlength: 255
                },
                parent_phone2: {
                    number: true,
                    number: true,

                },
                person_name: {
                    maxlength: 50
                },
                person_NumberID: {
                    number: true,

                    maxlength: 14

                },
                person_mobile: {
                    number: true,
                },
                school_staff: {
                    number: true,
                    maxlength: 4
                },
                'name[]': {


                    maxlength: 50
                },
                'frist_name_eng[]': {


                    maxlength: 50
                },
                how_school: {

                },
                'student_NumberID[]': {

                    number: true,
                    maxlength: 15
                },
                'student_region[]': {

                    maxlength: 255
                },
                gender: {

                    number: true,
                    maxlength: 1
                },
                'birthplace[]': {

                    maxlength: 50
                },

                Signature: {
                    maxlength: 500
                },
                file: {

                    minlength: 1,
                    extension: "png |gif | jpg | png | jpeg | pdf"
                },
                'img_name[]': {
                    // 
                    minlength: 1,
                },

            },
            messages: {
                parent_name: {
                    required: "<?= lang('This field is required') ?>"
                },
                parent_name_eng: {
                    required: "<?= lang('This field is required') ?>"
                },
                ParentNumberID: {
                    required: "<?= lang('This field is required') ?>",
                    number: "<?= lang('Please enter a valid number') ?>",
                    // maxlength: "<?= lang('Please enter no more than 14 characters') ?>"
                },
                parent_type_Identity: {
                    maxlength: "<?= lang('Please enter no more than 250 characters') ?>"
                },
                parent_source_identity: {
                    maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
                },
                parent_email: {

                    email: "<?= lang('Please enter a valid email') ?>",
                    maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
                },
                parent_educational_qualification: {
                    required: "<?= lang('This field is required') ?>",
                    maxlength: "<?= lang('Please enter no more than 255 characters') ?>"
                },
                mother_educational_qualification: {
                    required: "<?= lang('This field is required') ?>",
                    maxlength: "<?= lang('Please enter no more than 255 characters') ?>"
                },
                parent_national_ID: {
                    required: "<?= lang('This field is required') ?>",
                    maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
                },
                parent_mobile: {
                    required: "<?= lang('This field is required') ?>",
                    number: "<?= lang('Please enter a valid number') ?>",

                },

                parent_phone: {
                    required: "<?= lang('This field is required') ?>",
                    number: "<?= lang('Please enter a valid number') ?>",

                },
                parent_access_station: {
                    maxlength: "<?= lang('Please enter no more than 255 characters') ?>"
                },
                parent_house_number: {
                    maxlength: "<?= lang('Please enter no more than 10 characters') ?>"
                },
                parent_region: {
                    maxlength: "<?= lang('Please enter no more than 255 characters') ?>"
                },
                parent_profession: {
                    maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
                },
                parent_profession_mather: {
                    required: "<?= lang('This field is required') ?>",
                    maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
                },
                mother_work: {
                    required: "<?= lang('This field is required') ?>",
                    maxlength: "<?= lang('Please enter no more than 100 characters') ?>"
                },
                parent_work_address: {
                    maxlength: "<?= lang('Please enter no more than 255 characters') ?>"
                },
                parent_phone2: {
                    required: "<?= lang('This field is required') ?>",
                    number: "<?= lang('Please enter a valid number') ?>",

                },
                person_name: {
                    maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
                },
                person_NumberID: {
                    number: "<?= lang('Please enter a valid number') ?>",
                    // maxlength: "<?= lang('Please enter no more than 14 characters') ?>"
                },
                person_mobile: {
                    number: "<?= lang('Please enter a valid number') ?>",
                    // maxlength: "<?= lang('Please enter no more than 20 characters') ?>"
                },
                school_staff: {
                    number: "<?= lang('Please enter a valid number') ?>",
                    maxlength: "<?= lang('Please enter no more than 4 characters') ?>"
                },
                'name[]': {
                    required: "<?= lang('This field is required') ?>",
                    minlength: "<?= lang('Please enter at least 3 characters') ?>",
                    maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
                },
                'frist_name_eng[]': {
                    required: "<?= lang('This field is required') ?>",
                    minlength: "<?= lang('Please enter at least 3 characters') ?>",
                    maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
                },
                how_school: {
                    required: "<?= lang('This field is required') ?>",
                },
                'student_NumberID[]': {
                    required: "<?= lang('This field is required') ?>",
                    number: "<?= lang('Please enter a valid number') ?>",
                    maxlength: "<?= lang('Please enter no more than 14 characters') ?>"
                },
                'mother_educational_qualification': {
                    required: "<?= lang('This field is required') ?>",
                },
                'student_region[]': {
                    required: "<?= lang('This field is required') ?>",
                    maxlength: "<?= lang('Please enter no more than 255 characters') ?>"
                },
                gender: {
                    required: "<?= lang('This field is required') ?>",
                    number: "<?= lang('Please enter a valid number') ?>",
                    maxlength: "<?= lang('Please enter no more than 1 characters') ?>"
                },
                'birthplace[]': {
                    required: "<?= lang('This field is required') ?>",
                    maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
                },

                'studeType[]': {
                    required: "<?= lang('This field is required') ?>",
                },
                "school[]": "<?= lang('This field is required') ?>",

                "parent_profession": "<?= lang('This field is required') ?>",
                "parent_profession_mather": "<?= lang('This field is required') ?>",
                "level[]": "<?= lang('This field is required') ?>",
                "rowID[]": "<?= lang('This field is required') ?>",
                "YearId[]": "<?= lang('This field is required') ?>",

                "birthdate[]": "<?= lang('This field is required') ?>",
                "exSchool[]": "<?= lang('This field is required') ?>",
                "mother_educational_qualification": "<?= lang('This field is required') ?>",

                Signature: {
                    maxlength: "<?= lang('Please enter no more than 500 characters') ?>"
                },
                file: {
                    required: "<?= lang('This field is required') ?>",
                    minlength: "<?= lang('Please enter a valid image type (png |gif | jpg | png | jpeg | pdf)') ?>",
                    extension: "<?= lang('Please enter a valid image type (png |gif | jpg | png | jpeg | pdf)') ?>"
                },
                'img_name[]': {

                    minlength: "<?= lang('Please enter a valid image type (png |gif | jpg | png | jpeg | pdf)') ?>"
                },
                mother_name: {
                    required: "<?= lang('This field is required') ?>"
                },
                mother_email: {
                    email: "<?= lang('Please enter a valid email') ?>"
                },
                mother_mobile: {
                    required: "<?= lang('This field is required') ?>",
                    number: "<?= lang('Please enter a valid number') ?>"
                },
                transport_address: {
                    required: "<?= lang('This field is required') ?>"
                },
                transport_type: {
                    required: "<?= lang('This field is required') ?>"
                },
            }
        });
        var inputEle = document.getElementById('student_NumberID');
        const inputElement = document.getElementById('ParentNumberID');
        const inputValue = inputElement.value.trim();
        const student_NumberID = inputEle.value.trim();
      
                    if(student_NumberID===inputValue){
                     Swal.fire({
                        title: 'warning!',
                        text: 'رقم هوية ولى الامر نفس رقم هوية الابن    !',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
        if ($('input[name=want_transport]:checked').val() == 2) {
            addRules(transportRules);
        } else {
            removeRules(transportRules);
        }
        if (form.valid() == true) {

            $('.nav-tabs > .active').next('li').find('a').trigger('click');
        }
    });

    $('.btnPrevious').click(function() {
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    });

    function onlyNumberKey(evt) {
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
    $('document').ready(function() {
        $('.btn-lg').click(function() {
            $(window).scrollTop(0);
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
    const inputElement = document.getElementById('student_NumberID');
    inputElement.addEventListener('blur', () => {
    const inputValue = inputElement.value.trim();
    var inputEle = document.getElementById('ParentNumberID');
    var ApiDbname = $("#ApiDbname").val();
    const ParentNumberID = inputEle.value.trim();
        if (inputValue) {
              if(ParentNumberID===inputValue){
                     Swal.fire({
                        title: 'warning!',
                        text: 'رقم هوية ولى الامر نفس رقم هوية الابن    !',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                }
            if(ApiDbname !="SchoolAccAdvanced"){
                $.ajax({
                    url: '<?php echo site_url();?>' + '/home/student_register/checkStudentNumberId/'+inputValue,
                    type: "GET",
                    data: {},
                    dataType: "json",
                    success: function(response) {
                        if(response.success===0)
                        Swal.fire({
                            title: 'warning!',
                            text: 'رقم الهوية مسجل من قبل !',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
           
        }
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        
    var inputEle = document.getElementById('student_NumberID');
    const inputElement = document.getElementById('ParentNumberID');
    inputElement.addEventListener('blur', () => {
    const inputValue = inputElement.value.trim();
    const student_NumberID = inputEle.value.trim();
        if (inputValue) {
         
                    if(student_NumberID===inputValue){
                     Swal.fire({
                        title: 'warning!',
                        text: 'رقم هوية ولى الامر نفس رقم هوية الابن    !',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                }
        }
            
    });
});
</script>
<script type="text/javascript">
    function checkTransport(input) {
        if (input.is(':checked') && input.val() == 2) {
            $('input[name=transport_address]').attr('disabled', false);
            $('select[name=transport_type]').attr('disabled', false);
            addRules(transportRules);
        } else {
            $('input[name=transport_address]').val('');
            $('select[name=transport_type]').val('');
            $('input[name=transport_address]').attr('disabled', true);
            $('select[name=transport_type]').attr('disabled', true);
            removeRules(transportRules);
        }
    }

    function addRules(rulesObj) {
        for (var item in rulesObj) {
            $('#' + item).rules('add', rulesObj[item]);
        }
    }

    function removeRules(rulesObj) {
        for (var item in rulesObj) {
            $('#' + item).rules('remove');
            $('#' + item + '-error').remove();
            $('#' + item).removeClass('error');
        }
    }
</script>

<script>
    $(".zero").on("input", function() {
        if (/^0/.test(this.value)) {
            this.value = this.value.replace(/^0/, "")
        }
    })
</script>


<script>
    function toEnglishNumber(strNum) {
        var ar = '٠١٢٣٤٥٦٧٨٩'.split('');
        var en = '0123456789'.split('');
        strNum = strNum.replace(/[٠١٢٣٤٥٦٧٨٩]/g, x => en[ar.indexOf(x)]);
        strNum = strNum.replace(/[^\d]/g, '');
        return strNum;
    }

    $(document).on('keyup', '.arabicNumbers', function(e) {
        var val = toEnglishNumber($(this).val())
        $(this).val(val)
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("registration-form");
        const submitButton = document.getElementById("save");
        form.addEventListener("submit", function(event) {
            submitButton.disabled = true;
            submitButton.innerHTML = "Submitting...";
            setTimeout(function() {
                submitButton.disabled = false;
                submitButton.innerHTML = "Submit";
            }, 20000);
        });
    });
</script>
<script>
    $(function() {
        $("#father_brith_date").datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            position: {
                my: "left top",
                at: "left bottom",
                of: "#father_brith_date"
            },
            onSelect: function(selectedDate) {
                $("#father_brith_date").val(selectedDate);
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var allInputs = document.querySelectorAll("input, textarea");

        allInputs.forEach(function(input) {
            input.addEventListener("paste", function(event) {
                event.preventDefault();
            });
        });
    });
</script>
<script>
    function updatePersonName() {
        var name2 = $('#name2').val();
        var name3 = $('#name3').val();
        var name4 = $('#name4').val();
        var name5 = $('#name5').val();
        if (name4) {
            var fullName = name2 + ' ' + name3 + ' ' + name4 + ' ' + name5;
        } else {
            var fullName = name2 + ' ' + name3 + ' ' + name5;
        }
        $('#person_name').val(fullName);

        var ApiDbname = $("#ApiDbname").val();
        if (ApiDbname == "SchoolAccRemas") {
            $('#Signature').val(fullName);
        }
    }

    $('#name2, #name3, #name4, #name5').on('input', updatePersonName);
</script>
<?php include('home/footer.php'); ?>