<?php
$query = $this->db->query("select * from setting")->row_array();

header('Content-Type: text/html; charset=utf-8');

$css_cpanel = $this->session->userdata('css_cpanel'); ?>

<script src="<?php echo base_url(); ?>assets_emp/bank/js/sweetalert2.all.js"></script>


    <?php $js_cpanel = $this->session->userdata('js_cpanel');
    $lang         = $this->session->userdata('language');

    $query = $this->db->query("select * from setting")->row_array(); ?>
    <?php $reg = $this->db->query("select reg_type, IN_ERP,IN_HR from school_details ")->row_array(); ?>

    <!DOCTYPE html>

    <html style="--primary-color: <?php echo $query['primary-color']; ?>;--primary-hover:<?php echo $query['hover_color']; ?>;--header-color:<?php echo $query['home_color'] ?>;--main-color2: <?php echo $query['main-color2']; ?>;--main-color: <?php echo $query['main-color']; ?>;">
    <?php 
    $title       = $title ? $title : $this->session->userdata('contact_name');
    $description = $description ? $description : lang('description');
    $key_word    = $key_word ? $key_word : lang('keywords');
    
    ?>
    <title><?php echo $title ; ?></title>


    <link href="<?php echo base_url(); ?>assets/css/cpanel_admin.css" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="language" content="ar">
    <meta http-equiv="x-ua-compatible" content="text/html" charset="utf-8">

    <meta name="description" content="<?= $description ?>">
    <meta name="keywords" content="<?= $key_word  ?>">
    <meta name="author" content="<?= lang('author') ?>">

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/new/css/bootstrap.min.css" rel="stylesheet">

    <!-- style -->
    <link href="<?php echo base_url(); ?>assets/new/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_new/css/load.css">

    <?php
    if ($this->session->userdata('language') == 'english') { ?>
        <link href="<?php echo base_url(); ?>assets/new/css/ltr.css" rel="stylesheet">
    <?php } else { ?>
        <!-- Bootstrap rtl -->
        <link href="<?php echo base_url(); ?>assets/new/css/rtl.css" rel="stylesheet">
    <?php }
    ?>
    <!-- animate -->
    <link href="<?php echo base_url(); ?>assets/new/css/animate.min.css" rel="stylesheet">

    <!-- font-awesome -->
    <link href="<?php echo base_url(); ?>assets/new/css/font-awesome.css" rel="stylesheet">

    <!-- font-awesome-animation -->
    <link href="<?php echo base_url(); ?>assets/new/css/font-awesome-animation.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/new/css/bootstrap-select.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/new/fancybox-master/jquery.fancybox.min.css" rel="stylesheet" />

    <style>
        .dropdown-menu li:hover,
        .dropdown-menu li a:hover,
        .bootstrap-select.btn-group .dropdown-menu>.active>a,
        .bootstrap-select.btn-group .dropdown-menu>.active>a:focus,
        .bootstrap-select.btn-group .dropdown-menu>.active>a:hover,
        .nav.navbar-nav .open>.dropdown-menu li:hover,
        .content_new .top_nv_new ul li:hover{
            background: var(--primary-color) !important;
        }
        .tornado-select .options-list li:not(:first-child):hover{
            background: var(--primary-color);
            color: #fff !important;
        }
        .dropdown-menu li:hover a{
            color: #fff !important;
        }
        .content_new .top_nv_new {
            <?php echo $query['home_color'] ?>
        }

        .dropdown-menu.open{
            height: auto;
            max-height: 400px !important;
        }
        .dropdown-menu.inner{
            height: auto;
            max-height: 325px !important;
        }
        :root {
            --main-color: <?php echo $query['main-color'] ?>;
            --main-color2: <?php echo $query['main-color2'] ?>;
            --header-color: <?php echo $query['home_color'];
                            ?>
        }


        body {
            overflow-x: hidden;
            overflow-y: auto;
        }
        
        @media screen and (min-width:1226px) and (max-width:1329px) {
            .stdC ul {
                right: 0 !important;
            }

            .users ul {
                left: 0 !important;
                right: unset !important;
            }
        }

        @media screen and (min-width:1357px) and (max-width:1670px) {

            .stdC ul,
            .users ul {
                left: 0 !important;
                right: unset !important;
            }

        }

        @media screen and (min-width: 1256px) and (max-width: 1395px) {
            .navbar-nav .dropdown.rtl-dr-d .columns-3 {
                right: 0 !important;
            }

            .navbar-nav .dropdown.rtl-dr-d .columns-2 {
                right: 0 !important;
            }
        }

        @media screen and (min-width: 1396px) and (max-width: 1492px) {
            .navbar-nav .dropdown.rtl-dr-d .columns-2 {
                right: 0 !important;
            }

            .navbar-nav .dropdown.rtl-dr-d .columns-3 {
                right: 0 !important;
            }
        }

        @media screen and (min-width: 1493px) and (max-width: 1644px) {

            .navbar-nav .dropdown.rtl-dr-d .columns-2,
            .navbar-nav .dropdown.rtl-dr-d .columns-3 {
                left: 0 !important;
            }

            .navbar-nav .dropdown.rtl-dr-d:last-of-type .dropdown-menu {
                right: 0 !important;
            }
        }

        @media screen and (min-width:1512px) and (max-width:1619px) {
            .navbar-nav .dropdown.rtl-dr-d .columns-2 {
                right: 0 !important;
                left: unset !important;
            }
        }

        @media screen and (min-width: 1645px) {

            .navbar-nav .dropdown.rtl-dr-d .columns-2,
            .navbar-nav .dropdown.rtl-dr-d .columns-3 {
                left: 0 !important;
            }

            .navbar-nav .dropdown.rtl-dr-d:last-of-type .dropdown-menu {
                right: 0 !important;
            }
        }
    
    <?php if ($this->session->userdata('language') == 'english') { ?>
        
            @media screen and (min-width:1201px) and (max-width:1329px) {
                .stdC ul {
                    right: 0 !important;
                    left: unset !important;
                }

                .users ul {
                    left: 0 !important;
                    right: unset !important;
                }

                .navbar-nav .dropdown.rtl-dr-d .columns-3 {
                    left: 0 !important;
                    right: unset !important;
                }

                .navbar-nav .dropdown.rtl-dr-d .columns-2 {
                    left: 0 !important;
                    right: unset !important;
                }

                .navbar-nav .dropdown.rtl-dr-d:last-of-type .dropdown-menu {
                    left: 0 !important;
                    right: unset !important;
                }
            }

            @media screen and (min-width: 1256px) and (max-width: 1395px) {
                .navbar-nav .dropdown.rtl-dr-d .columns-3 {
                    left: 0 !important;
                    right: unset !important;
                }

                .navbar-nav .dropdown.rtl-dr-d .columns-2 {
                    left: 0 !important;
                    right: unset !important;
                }
            }

            @media screen and (min-width: 1396px) and (max-width: 1492px) {
                .navbar-nav .dropdown.rtl-dr-d .columns-2 {
                    left: 0 !important;
                    right: unset !important;
                }

                .navbar-nav .dropdown.rtl-dr-d .columns-3 {
                    right: 0 !important;
                    left: unset !important;
                }

                .navbar-nav .dropdown.rtl-dr-d:last-of-type .dropdown-menu {
                    left: 0 !important;
                    right: unset !important;
                }
            }

            @media screen and (min-width: 1493px) and (max-width: 1644px) {

                .navbar-nav .dropdown.rtl-dr-d .columns-2,
                .navbar-nav .dropdown.rtl-dr-d .columns-3 {
                    right: 0 !important;
                    left: unset !important;
                }

                .navbar-nav .dropdown.rtl-dr-d:last-of-type .dropdown-menu {
                    left: 0 !important;
                    right: unset !important;
                }
            }

            @media screen and (min-width: 1645px) {

                .navbar-nav .dropdown.rtl-dr-d .columns-2,
                .navbar-nav .dropdown.rtl-dr-d .columns-3 {
                    right: 0 !important;
                    left: unset !important;
                }

                .navbar-nav .dropdown.rtl-dr-d:last-of-type .dropdown-menu {
                    right: 0 !important;
                    left: unset !important;
                }
            }    
            <?php } ?>
           
     </style>
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/new/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url(); ?>assets/new/js/star-rating.js" type="text/javascript"></script>
    </head>

    <body>


        <div class="warper-ds">
            <div id="wrapper">
                <div class="overlay"></div>



                <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
                    <ul class="nav sidebar-nav">

                        <li class="active"><a href="#">الرئيسية</a></li>

                        <li class="dropdown"><a class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown" href="#">
                                <i class="fa fa-columns faa-float"></i>
                                <span><?php echo lang('er_online_lec'); ?></span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url('admin/online_lec') ?>">
                                        <?php echo lang('er_online_lec'); ?> </a> </li>
                                <li><a href="<?php echo site_url('admin/forum/comment_not_active') ?>">
                                        <?php echo lang('er_Comments'); ?> </a> </li>
                            </ul>
                        </li>

                        <li><a href="<?php echo site_url('counseling_students') ?>" class="faa-parent animated-hover">
                                <i class="fa fa-pie-chart faa-float"></i>
                                <span><?php echo lang('er_annual_plan'); ?></span>
                            </a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
                                <i class="fa fa-newspaper-o faa-float"></i>
                                <span><?php echo lang('am_models') ?></span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url('admin/model') ?>"><?php echo lang('am_design_models'); ?>
                                    </a></li>
                                <li><a href="<?php echo site_url('admin/model/model_image') ?>"><?php echo lang('Illustd_form'); ?> </a></li>
                            </ul>
                        </li>
                    </ul>

                </nav>
               
                <div id="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="row">

                            <style>
                                .nav_top .se-st-22 {
                                    padding: 9px 10px;
                                }
                            </style>



                            <div class="content_new white">

                                <div style="background: <?php echo $query['home_color']; ?>;--primary-hover:<?php echo $query['hover_color']; ?>" class="top_nv_new newNavPa">
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <div class="nav-logo text-center sm-p-left pull-right">

                                            <a class="navbar-brand pull-right" <?php if ($this->session->userdata("type") == "U") { ?> href="<?php echo site_url('admin/cpanel') ?>" <?php } ?>>

                                                <img src="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo'] ?>" />
                                            </a>

                                        </div>
                                        <ul class="nav navbar-nav nav_top w-auto pull-right">
                                            <?php
                                            $SchoolName = '';

                                            if ($this->session->userdata('language') == 'english') {
                                                $Name = 'SchoolNameEn';
                                            } else {
                                                $Name = 'SchoolName';
                                            }

                                            $QueryGetSchoolName = $this->db->query("SELECT school_details." . $Name . " as SchoolName  FROM school_details  WHERE ID = '" . $this->session->userdata('SchoolID') . "' ")->row_array();
                                            if (sizeof($QueryGetSchoolName) > 0) {
                                                $SchoolName = $QueryGetSchoolName['SchoolName'];
                                            }
                                            ?>
                                            <li class="se-st-22">
                                                <?= $SchoolName;   ?>
                                            </li>

                                        </ul>

                                        <ul class="nav navbar-nav nav_top pull-right newNav">
                                            <?php if ($this->session->userdata("type") == "U") { ?>
                                                <li class="dropdown dropdown-big" data-toggle="tooltip" data-placement="left" title="<?php echo lang('br_inside_home') ?>">
                                                    <a href="<?php echo site_url('admin/cpanel') ?>">
                                                        <i class="fa fa-home"></i>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                           
                                            <li class="dropdown pull-right user-data" data-toggle="tooltip" data-placement="left" title="<?php echo $this->session->userdata('contact_name') ?>">

                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fa fa-user"></i>
                                                    <b class="caret"></b>
                                                </a>

                                                <ul class="dropdown-menu">

                                                    <li class="padd_ri">

                                                        <a href="<?php echo site_url('contact/contact/edit_contact') ?>">

                                                            <?php echo lang('br_edit_profile') ?>


                                                        </a>

                                                    </li>

                                                    <li class="padd_ri">

                                                        <a href="<?php echo site_url('home/login/log_out') ?>">

                                                            <?php echo lang('br_logout') ?>



                                                        </a>

                                                    </li>


                                                </ul>

                                            </li>

                                            <?php $this->session->set_userdata('previous_page', uri_string()); ?>

                                            <?php if ($lang != 'arabic') : ?>



                                                <li class="dropdown dropdown-big">

                                                    <a class="lang_in_st" data-toggle="tooltip" data-placement="right" title="AR" href="<?php echo site_url('home/home/set_lang/L/2'); ?>">
                                                        <i class="fa fa-life-ring"></i>




                                                    </a>

                                                </li>
                                            <?php else : ?>
                                                <li class="dropdown dropdown-big">

                                                    <a class="lang_in_st" data-toggle="tooltip" data-placement="left" title="EN" href="<?php echo site_url('home/home/set_lang/L/1'); ?>">
                                                        <i class="fa fa-life-ring"></i>




                                                    </a>

                                                </li>
                                            <?php endif; ?>

                                        </ul>

                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="display: flex;">

                                        <ul class="nav navbar-nav nav_top pull-left">

                                            <li class="se-st-22 ">

                                                <?php

                                               
                                                $CI                  = get_instance();
                                                $CI->load->model('admin/setting_model');
                                                $Lang           = $CI->session->userdata('language');
                                                

	
                                                $get_schools = json_decode(file_get_contents(lang('api_link')."/api/Schools/" . $query['ApiDbname'] . "/GetAllSchools"));
                                               // if (sizeof($query_school) > 1) {
                                                ?>
                                                    <select id="SchoolData" onChange="chang_school(this.value);" class="form-control">
                                                        <!--<option value=""><?=lang('am_select')?></option>-->
                                                              <?php 
                                            										if ($get_schools) {
                                            											foreach ($get_schools as $school) {
                                            										?>
                                                                                        <option value="<?=$school->SchoolId?>" <?php if ($this->session->userdata('SchoolID') == $school->SchoolId) {
                                                                                                        echo 'selected';
                                                                                                    } ?>><?=$school->SchoolName?></option>
                                                                                        <?php
                                            											}
                                            										}
                                            										?>
                                                            </select>
                                                    <script>
                                                        function chang_school(SchoolID) {
                                                            window.location = "<?= site_url('admin/cpanel/chang_school'); ?>/" +
                                                                SchoolID;
                                                        }
                                                    </script>
                                                <?php
                                               // }

                                                ?>
                                            </li>
                                            
                                        </ul>

                                    </div>
                                </div>
                               
                               <div class="clearfix"></div>
                                    <div class="navbar navbar-default" id="custom-bootstrap-menu" role="navigation">
                                        <div class="container-fluid">
                                            <div class="navbar-header">
                                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                                    <span class="sr-only">Toggle navigation</span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                            </div>
                                            <div class="collapse navbar-collapse">
                                                <ul class="nav navbar-nav" style="padding: 0">
                                   
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
                                        <i class="fa fa-list-alt faa-float"></i>
                                        <span><?php echo lang('br_permission'); ?></span>
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo site_url('admin/user_permission/per_group') ?>"><?php echo lang('br_per_group'); ?></a>
                                        </li>
                                        <li><a href="<?php echo site_url('admin/user_permission/group_page') ?>"><?php echo lang('br_permission') . '-' . lang('br_per_group'); ?></a>
                                        </li>
                                      
                                        
                                        
                                       

                                      
                                    </ul>
                                </li>
                                                    
                                                   
                               
                                <?php if ($query['Registration'] == 1) { ?>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
                                            <i class="fa fa-list-alt faa-float"></i>
                                            <span><?php echo lang('am_admission'); ?></span>
                                            <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                        
                                        <?php if ($query['ApiDbname'] == "SchoolAccTabuk") { ?>
                                            <li><a href="<?php echo site_url('admin/Report_Register/admission_form') ?>"><?php echo lang('er_accept_student');?></a></li>
                                        <?php } ?>

                                       
                                            <li><a href="<?php echo site_url('admin/Report_Register/configYearRegister') ?>"><?php echo lang('Preparing_year_register') ?> </a></li>
                                            <?php  
                                                $query_erb = $this->db->query("SELECT IN_ERP, time_zone FROM school_details")->row_array(); 
                                                if (($query_erb['IN_ERP'] == 1) && ($query_erb['time_zone'] === 'Asia/Riyadh')) {
                                                    ?>
                                                    <li><a href="<?php echo site_url('admin/Report_Register/config_semester_register') ?>"><?php echo lang('Semester') ?> </a></li>
                                                    <?php 
                                                } 
                                                ?>
                                            <?php if($this->session->userdata('id') == 4471) { ?>
                                            <li><a href="<?php echo site_url('admin/Report_Register/set_reg_type') ?>"><?php echo lang('Preparing_admission') ?></a></li>
                                            <?php } ?>
                                            <?php if ($reg['reg_type'] == 1) { ?>
                                                <li><a href="<?php echo site_url('admin/config_system/config_form_register') ?>"><?php echo lang('br_Preparing_registration_form'); ?></a>
                                                </li>
                                                <li><a href="<?php echo site_url('admin/Report_Register') ?>"><?php echo lang('br_check_st_register'); ?>
                                                    </a></li>
                                                <li><a href="<?php echo site_url('admin/Report_Register/report_register/1') ?>">
                                                        <?php echo lang('br_report_st_register'); ?> </a></li>
                                                <li><a href="<?php echo site_url('admin/Report_Register/count_student_register/1') ?>"><?php echo lang('ra_statistical_report_for_admission'); ?>
                                                    </a></li>
                                                <li><a href="<?php echo site_url('admin/Report_Register/dashboard') ?>"><?php echo lang('dash_reg'); ?>
                                                    </a></li>
                                                <li><a href="<?php echo site_url('admin/Report_Register/registerFormPrint') ?>"><?php echo lang('am_RegistrationForm'); ?>
                                                </a></li>
                                            <?php } else { ?>
                                                <li><a href="<?php echo site_url('admin/Report_Register/register_type') ?>"><?php echo lang('Create_request_status'); ?>
                                                    </a></li>
                                                <li><a href="<?php echo site_url('admin/Report_Register/reg_per_level') ?>"><?php echo lang('level_marketing'); ?>
                                                    </a></li>
                                               
                                                <li><a href="<?php echo site_url('admin/Report_Register/Get_service_res') ?>"><?php echo lang('Service_representatives_ratings'); ?>
                                                    </a></li>
                                                <li><a href="<?php echo site_url('admin/Report_Register/Student_Register_marketing') ?>"><?php echo lang('br_check_st_register'); ?>
                                                    </a></li>
                                                <li><a href="<?php echo site_url('admin/Report_Register/reg_complete') ?>"><?php echo lang('reg_form_complete'); ?></a>
                                                </li>
                                                <li><a href="<?php echo site_url('admin/Report_Register/report_register/2') ?>">
                                                        <?php echo lang('br_report_st_register'); ?> </a></li>
                                                <li><a href="<?php echo site_url('admin/Report_Register/count_student_register/2') ?>"><?php echo lang('ra_statistical_report_for_admission'); ?></a>
                                                </li>
                                                <li><a href="<?php echo site_url('admin/Report_Register/dashboard_register') ?>"><?php echo lang('dash_reg'); ?>
                                                    </a></li>
                                                <li><a href="<?php echo site_url('emp/exam_new/index/4') ?>"><?php echo lang('Add_Exam'); ?>
                                                    </a></li>
                                            <?php } ?>
                                            
                                           

                                        </ul>
                                    </li>
                                <?php }  ?>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
                                            <i class="fa fa-bar-chart-o faa-float"></i>
                                            <span><?php echo lang('am_cms'); ?></span>
                                            <b class="caret"></b>
                                        </a>
                                        
                                            <ul class="dropdown-menu">
                                                <li><a href="<?php echo site_url('admin/content_management/main_content_management') ?>"><?php echo lang('am_cms'); ?></a></li>
                                                <li><a href="<?php echo site_url('admin/content_management/call_us') ?>"><?php echo lang('am_contact_us') ?></a>
                                            </ul>
                                       
                                    </li>
                                    <li class="dropdown users">
                                        <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
                                            <i class="fa fa-gear faa-float"></i>
                                            <span><?php echo lang('br_contact'); ?></span>
                                            <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                          
                                            <li><a href="<?php echo site_url('admin/employee'); ?>"><?php echo lang('br_employee_edit'); ?>
                                                </a></li>
                                            <?php  if($this->session->userdata('type') == 'U'){?>
                                            <li><a href="<?php echo site_url('admin/cpanel/admin'); ?>"><?php echo lang('admins'); ?>   </a></li>
                                            <?php } ?>
                                               
                                          
                                        </ul>
                                    </li>
    
                                    <?php if($this->session->userdata('id') == 4471 || $reg['IN_ERP'] == 1 ||$reg['IN_HR'] == 1 || $query['ApiDbname'] == "SchoolAccAndalos"){ ?>
                                    <li class="dropdown">
                                            <a href="#" class="dropdown-toggle faa-parent animated-hover" data-toggle="dropdown">
                                                <i class="fa fa-columns faa-float"></i>
                                                <span> <?php echo lang('er_linking_system'); ?></span>
                                                <b class="caret"></b> </a>

                                            <ul class="dropdown-menu ">
                                           
                                                   
                                            <li><a href="<?php echo site_url('admin/config_system/config_accounts_erp') ?>"><?php echo lang('config_accounts') ?></a></li>
                                            
                                        </ul>
                                    </li>
                                    <?php } ?>
                                 </ul>
                                            </div>
                                            <!--/.nav-collapse -->
                                        </div>
                                    </div>

                            </div>
                            
                        <style>
                            #custom-bootstrap-menu.navbar-default {
                                margin-bottom: 0;
                            }
                        </style>
                        <div class="clearfix"></div>
                        <?php $query = $this->db->query("select * from setting")->row_array();
                        if ($query['ApiDbname'] == "SchoolAccGheras") { ?>
                            <script>
                                $(document).ready(function() {
                                    window.intervalID = setInterval(function() {
                                        window.location.href = "<?php echo site_url(); ?>/home/login/log_out";
                                    }, 2700000);
                                });
                                $(document).click(function() {
                                    clearInterval(window.intervalID);
                                    window.intervalID = setInterval(function() {
                                        window.location.href = "<?php echo site_url(); ?>/home/login/log_out";
                                    }, 2700000);

                                });
                            </script>
                        <?php } else { ?>
                            <script>
                                $(document).ready(function() {
                                    window.intervalID = setInterval(function() {
                                        window.location.href = "<?php echo site_url(); ?>/home/login/log_out";
                                    }, 25200000);
                                });
                                $(document).click(function() {
                                    clearInterval(window.intervalID);
                                    window.intervalID = setInterval(function() {
                                        window.location.href = "<?php echo site_url(); ?>/home/login/log_out";
                                    }, 25200000);

                                });
                            </script>
                        <?php } ?>
         

                    <script>
                        if (window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                        }
                    </script>
                    <script>
window.onload = function() {
    <?php if($this->session->flashdata('success_msg')): ?>
    Swal.fire({
        title: 'نجاح!',
        text: '<?php echo $this->session->flashdata('success_msg'); ?>',
        icon: 'success',
        confirmButtonText: 'حسناً'
    });
    <?php endif; ?>
};
</script>
<style>
#example > tbody > tr > td > a:not(.btn), #example1 > tbody > tr > td > a:not(.btn),#employee_grid_2_wrapper > tbody > tr > td > a:not(.btn) {
    color: white; 
    background-color: var(--primary-color); 
    padding: 5px 10px; 
    border-radius: 5px;
    text-decoration: none; 
    border: none; 
    cursor: pointer; 
    transition: background-color 0.3s ease; 
    display: inline-block; 
    margin: 2px; 
    width: 95%;
}

#example > tbody > tr > td > a:not(.btn):hover, #example1 > tbody > tr > td > a:not(.btn):hover, #employee_grid_2_wrapper > tbody > tr > td > a:not(.btn):hover {
    background-color: #0056b3; 
}

</style>