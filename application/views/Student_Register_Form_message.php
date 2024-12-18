<?php $query = $this->db->query("select * from setting")->row_array();

$home_theme = $query['home_theme'];
if ($home_theme) {
    include('home_new/' . $home_theme . '/header.php');
} else {
    include('home_new/header.php');
}
?>
<style>
    .row,
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

    #SchoolData,
    .news-bar {
        display: none !important;
    }

    #school_id {
        visibility: hidden;
        opacity: 0;
    }
</style>


<?php $query = $this->db->query("select * from setting")->row_array(); ?>
<?php if ($this->session->userdata('language') != 'english') { ?>
    <title><?php echo $query['SchoolName'] ?></title>
<?php } else { ?>
    <title><?php echo $query['SchoolEnName'] ?></title>
<?php } ?>
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
<!--///////////-->



<?php //print_r($get_levels);die;  
?>
<div style="color:red" id="recaptchaMsg"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<?php $settingQuery = $this->db->query("select * from setting")->row_array(); ?>
<link href="https://fonts.cdnfonts.com/css/neo-sans-arabic?styles=50556,50562" rel="stylesheet">

<div style="color:red" id="recaptchaMsg"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>  -->
<script src="<?= base_url() ?>js/jquery.validate.min.js"></script>

<style>
    body {
        margin: 20px 0;
        font-family: 'Lato';
        font-weight: 300;
        font-size: 1.25rem;
    }

    .container-dd {
        margin-top: 150px
    }

    .datepicker-days {
        width: 300px;
    }

    .datepicker.dropdown-menu {
        width: 300px !important;
        margin-top: 19px;
    }

    .table-condensed {
        width: 100%;
    }

    form,
    p {
        margin: 20px;
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

    .nav-tabs>li {
        width: 25%;
    }

    @media(max-width:992px) {
        .nav-tabs>li {
            width: 50%;
        }
    }

    @media(max-width:600px) {
        .nav-tabs>li {
            width: 100%;
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
        background-color: #56ad48;
        border-color: #56ad48;
    }

    .tab-content .btn-danger,
    .tab-content .btn-danger:active,
    .tab-content .btn-danger:hover,
    .tab-content .btn-danger:focus,
    .tab-content .btn-danger:hover:focus {
        color: #fff;
        background-color: #303030;
        border-color: #303030;
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
        color: #56ad48 !important;
    }

    .nav-tabs.nav-tabs-ddds>li {
        float: right;
    }

    .nav-tabs.nav-tabs-ddds>li.active {
        background-color: #56ad48 !important;
    }

    .nav-tabs.nav-tabs-ddds>li.active a {
        color: #fff !important;
        background-color: transparent !important;
    }

    .nav-tabs.nav-tabs-ddds {
        border: 1px solid #ddd;
        padding: 0px;
    }

    .nav-tabs li.active:after {
        border-bottom-color: #fff !important;
    }

    <?php if ($this->ApiDbname == "SchoolAccAdvanced") { ?>.navbar {
        display: none;
    }

    <?php } ?>
</style>

<div class="container container-dd">
    <div class="row">
        <div class="col-md-12 text-left" style="left: 0px;z-index: 5;">
            <?php if ($settingQuery['homeLink']) {
                $url = $settingQuery['homeLink'];
            } else {
                $url = base_url();
            } ?>
            <a class="btn" href="<?= $url ?>" style="background: var(--main-color);color:#FFF"><?php echo lang('am_home'); ?> </a>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 text-center">

            <img src="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $settingQuery['Logo']; ?>" width="120">
            <h3 style="margin-bottom: 35px;"><?= lang('am_RegistrationForm') ?></h3>
        </div>
    </div>

    <div class="row form-group">

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
        <?php if ($this->ApiDbname == "SchoolAccAdvanced") { ?>
            <img src="<?php echo base_url(); ?>intro/images/almotqadima_img.jpeg" style="width: 1150px;">
        <?php } ?>
    </div>



</div>