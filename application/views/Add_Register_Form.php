<?php $query = $this->db->query("select * from setting")->row_array();

$home_theme = $query['home_theme'];
if ($home_theme) {
    include('home_new/' . $home_theme . '/header.php');
} else {
    include('home_new/header.php');
}
?>
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet" />
<?php if ($this->session->userdata('language') != 'english') { ?>
    <link href="<?php echo base_url(); ?>css/rtl.css" rel="stylesheet">
<?php } else { ?>
    <link href="<?php echo base_url(); ?>css/ltr.css" rel="stylesheet">
<?php } ?>
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<style>
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

    .tab-content1 span.danger {
        color: red;
        position: absolute;
        left: 10px;
        font-size: 18px;
    }

    .form-control {
        height: 35px;
        border-radius: 0.25rem 0 0 0.25rem;
        padding: 0 5px;
    }

    body {
        position: relative;

        <?php if (base_url() == 'https://almanhalschools.edu.sa') {
        ?>background-image: url("https://almanhalschools.edu.sa/assets/img/391c2575-b414-430d-8b0a-3f62987f7e51.jpg") !important;
        <?php
        }
        ?>background-repeat: no-repeat;
        background-size: cover !important;
    }

    .contacts,
    .contactHead,
    footer {
        display: none;
    }

    @keyframes example {
        0% {
            left: 0px;
        }

        50% {
            left: 200px;
        }

        100% {
            left: 0px;
        }
    }

    .gear-check {
        display: none;
    }

    .top-bar {
        display: none;
    }

    .custom-img {
        height: 47px;
        margin: 4px !important;
    }

    .custom-img2 {
        width: 65px !important;
        margin: 4px !important;
    }

    .custom-img3 {
        width: 60px !important;
        margin: 4px !important;
    }

    .title {
        font-size: x-large;
        background-color: #2c2c8e;
        color: white;
        margin: 10px auto;
        top: 35%;
        text-align: center;
        padding: 10px 19px 10px 21px;
        z-index: 9999;
        width: max-content;
        overflow: auto;

    }

    .control-label {
        position: relative;
        /*background:linear-gradient(90deg,#91c4db,#99d9f6, #c2dfed,#bad8e5);*/
        background: var(--main-color2);
        color: #fff;
        font-size: 12px;
        direction: rtl;
        text-align: right;
        font-weight: bold;
        line-height: 35px;
    }

    .send,
    .addstu {
        background: var(--main-color) !important;
        border-color: var(--main-color) !important;
        color: #fff;
    }

    /*.background-image {*/
    /*    background-color: rgb(255 255 255 / 54%);*/

    /*}*/


    .background-image #particles-js {
        display: none;


    }

    .pulse {
        width: 30px;
    }

    footer {
        padding: 10px;
        background-color: #fdfdfd;
        color: #000;
    }

    /*@media only screen and (max-width: 900px) {
@keyframes para {
  100% {
    background-position: 
      -5000px 20%,
      -800px 95%,
      500px 50%,
      1000px 100%,
      400px 0;
    }
  }
    .container-dd{
        left:0 !important;
        top: 110 !important;
        overflow: scroll;
        height: 75%;
        padding: 0;
        width: 97%;
    }
    .nav-bar{
        z-index: 1;
    }
    body{
    overflow-x: hidden;
    height: 100%; 
  background-color: hsla(200,40%,30%,.4);
  background-position-y: 185px !important;
  background-image:   
    url('https://almanhalschools.edu.sa/assets/img/391c2575-b414-430d-8b0a-3f62987f7e51.jpg');
  background-repeat: repeat-x !important;
  background-size: cover !important;
  background-position: 
    0 20%,
    0 100%,
    0 50%,
    0 100%,
    0 0;
  animation: 50s para infinite linear;
}
}*/

    .custom-img {
        width: 70px !important;
    }

    .custom-img2 {
        width: 51px !important;
    }

    .custom-img3 {
        width: 44px !important;
    }

    .container-dd {
        background: #fff0 !important;
        width: 85%;
        margin: auto;
    }

    #SchoolData,
    .news-bar {
        display: none;
    }

    #school_id {
        visibility: hidden;
        opacity: 0;
    }

    footer {
        margin: 15px 0;
    }

    .navbar-nav {
        display: none !important;
    }

    .alert {
        width: 100%;
        padding: 25px 10px;
        font-size: 15px;
        text-align: center;
    }
</style>
<?php if ($this->session->userdata('language') == 'english') { ?>
    <style>
        .container-dd {
            direction: ltr;
        }

        .control-label,
        .list-group-item-text {
            text-align: left !important;
        }

        .tab-content1 span.danger {
            right: 10px;
            left: unset
        }
    </style>
<?php }
?>
<div>
    <div class="background-image" style="overflow-x: hidden;margin:0;padding: 150px 0 0">
        <div style="color:red" id="recaptchaMsg"></div>
        <div class="clearfix"></div>
    </div>
    <div class="container-dd">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <?php $query = $this->db->query("select * from setting")->row_array(); ?>
                <img src="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo'] ?>" width="120">
                <h2 style="margin-bottom: 10px;margin-top: 40px;"><?= lang('am_RegistrationForm') ?></h2>
            </div>
            <?php if ($this->ApiDbname == "SchoolAccManahelAlBukayriyah") { ?>
                <p style="color: #ddb873;margin: 45px;font-size: large;"><?php echo lang('am_welcome_manahl'); ?></p>
            <?php } ?>
        </div>
        <div class="row form-group m-0">

            <?php if ($this->session->flashdata('ErrorAdd')) { ?>
                <div class="alert alert-danger">
                    <?php
                    echo $this->session->flashdata('ErrorAdd'); ?>
                </div>
            <?php } else if ($this->session->flashdata('SuccessAdd')) { ?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('SuccessAdd'); ?>
                </div>
            <?php } ?>


            <div class="tab-content1">
                <div class="tab-pane active" id="tab1">
                    <div class="col-xs-12 p-0">
                        <div class="col-md-12 p-0">
                            <h4 class="list-group-item-text" style="font-family: 'Neo Sans Arabic', sans-serif !important;text-align:right">
                                <?= lang('am_father_information'); ?></h4>
                            <hr>
                            <div class="row">

                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                        <?= lang('br_father_NumID') ?> <span class="danger">*</span></label>
                                    <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="ParentNumberID" name="ParentNumberID" maxlength="10" minlength="10" class="form-control arabicNumbers" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                        <?= lang('am_father_name') ?> <span class="danger">*</span></label>
                                    <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_name" name="parent_name" value="<?= set_value('parent_name'); ?>" maxlength="50" class="form-control" required>
                                        <input type="hidden" id="reg_per" name="reg_per" value="<?= $reg_per_level[0]->reg_level; ?>" class="form-control">
                                    </div>
                                </div>
                                 <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                        <?= lang('grandba_name') ?> <span class="danger">*</span></label>
                                    <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="grandba_name" name="grandba_name" value="<?= set_value('grandba_name'); ?>" maxlength="50" class="form-control" required>
                                    </div>
                                </div>
                                 <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                        <?= lang('family_name') ?> <span class="danger">*</span></label>
                                    <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="family_name" name="family_name" value="<?= set_value('family_name'); ?>" maxlength="50" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                        <?= lang('am_Nationality') ?> <span class="danger">*</span></label>
                                    <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                        <select id="parent_national_ID" name="parent_national_ID" class="form-control" required>
                                            <option value=""><?php echo lang('am_choose_select'); ?></option>
                                            <?php foreach ($get_nationality as $item) { ?>
                                                <option value="<?= $item->NationalityId; ?>" <?php echo set_select('parent_national_ID', $item->NationalityName, (!empty($data) && $data == $item->NationalityName ? TRUE : FALSE)); ?>>
                                                    <?= $item->NationalityName; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-6 col-sm-12 col-xs-12"><?php echo lang('father_mobile') ?>
                                        <span class="danger">*</span></label>
                                    <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_mobile" name="parent_mobile" maxlength="12" minlength="9" class="form-control arabicNumbers" required>
                                    </div>
                                </div>

                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-6 col-sm-12 col-xs-12"><?php if ($this->ApiDbname == "SchoolAccUniversitySchools") {
                                                                                                    echo lang('br_st_mo_mobile');
                                                                                                } else {
                                                                                                    echo lang('am_Mobile') . "2";
                                                                                                } ?></label>
                                    <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_mobile2" name="parent_mobile2" maxlength="15" minlength="8" class="form-control arabicNumbers">
                                    </div>
                                </div>


                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                        <?= lang('am_mail') ?> <?php if ($this->ApiDbname == "SchoolAccanwaralfayhaa") { ?><span class="danger">*</span><?php } ?></label>
                                    <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_email" name="parent_email" minlength="10" maxlength="50" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                    <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                        <?= lang('am_region') ?><span class="danger">*</span> </label>
                                    <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                        <input type="text" id="parent_region" name="parent_region" minlength="10" maxlength="255" class="form-control" required>
                                    </div>
                                </div> 

                                <div class="col-md-12 text-left">
                                    <input type="submit" onclick="GetData();" class="btn btn-info send" value="<?= lang('am_student_information') ?>" id="show" style="width: 150px" />
                                </div>
                                <div class="clearfix"></div>
                                <div class="clearfix"></div>
                                <div class="clearfix"></div>
                                <div class="clearfix"></div>
                                <div id="result_student">
                                    <form action="<?php echo site_url('home/student_register/add_step_reg_data') ?>" method="post" onsubmit="return validation_speed();" style="margin:25px 10px">
                                        <input type="hidden" name="DbName" id="DbName" value="<?php echo $this->ApiDbname; ?>">
                                        <input type="hidden" name="Parent_ID" id="Parent_ID" value="">
                                         <input type="hidden" name="parent_mobile_new" id="parent_mobile_new" value="">
                                         <input type="hidden" name="parent_mobile2_new" id="parent_mobile2_new" value="">
                                         <input type="hidden" name="parent_email_new" id="parent_email_new" value="">
                                         <input type="hidden" name="parent_name_new" id="parent_name_new" value="">
                                         <input type="hidden" name="grandba_name_new" id="grandba_name_new" value="">
                                         <input type="hidden" name="family_name_new" id="family_name_new" value="">
                                         <input type="hidden" name="ParentNumberID_new" id="ParentNumberID_new" value="">
                                         <input type="hidden" name="parent_region_new" id="parent_region_new" value="">
                                         <input type="hidden" name="parent_national_ID_new" id="parent_national_ID_new" value="">
                                        <input type="hidden" name="num_ALL_Student" id="num_ALL_Student" value="1">
                                        <input type="hidden" name="reg_year" id="reg_year" value="<?php echo $reg_year; ?>">

                                        <div id="add_stu">
                                            <div class="clearfix"></div>
                                            <div class="clearfix"></div>
                                            <?php $num_student = 1; ?>
                                            <input type="hidden" name="num_student" id="num_student" value="1">
                                            <h4 class="list-group-item-text" style="font-family: 'Neo Sans Arabic', sans-serif !important;text-align:right">
                                                <?= lang('am_student_information'); ?></h4>
                                            <hr>
                                            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                                <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                                    <?php echo lang('am_frist_name') ?><span class="danger">*</span></label>
                                                <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                                    <input data-value="<?php echo $num_student; ?>" type="text" id="stu_name<?php echo $num_student; ?>" name="stu_name<?php echo $num_student; ?>" maxlength="50" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                                <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                                    <?php echo lang('br_st_numberid') ?> <span class="danger">*</span></label>
                                                <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                                    <input data-value="<?php echo $num_student; ?>" type="text" id="student_NumberID<?php echo $num_student; ?>" name="student_NumberID<?php echo $num_student; ?>" maxlength="10" minlength="10" class="form-control arabicNumbers" required>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                                <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                                    <?= lang('am_type') ?> <span class="danger">*</span></label>
                                                <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                                    <select data-value="<?php echo $num_student; ?>" id="gender<?php echo $num_student; ?>" name="gender<?php echo $num_student; ?>" class="form-control" required>
                                                        <option value=""><?php echo lang('am_choose_select'); ?>
                                                        </option>
                                                        <?php
                                                        if ($get_genders) {
                                                            foreach ($get_genders as $gender) {
                                                        ?>
                                                                <option value="<?= $gender->GenderId ?>">
                                                                    <?= $gender->GenderName ?>
                                                                </option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                                <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                                    <?= lang('class_type') ?> <span class="danger">*</span></label>
                                                <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                                    <select data-value="<?php echo $num_student; ?>" id="ClassTypeName<?php echo $num_student; ?>" name="ClassTypeName<?php echo $num_student; ?>" class="form-control" required>
                                                        <option value=""><?php echo lang('am_choose_select'); ?>
                                                        </option>
                                                        <?php
                                                        if ($get_ClassTypeName) {
                                                            foreach ($get_ClassTypeName as $TypeName) {

                                                        ?>
                                                                <option value="<?= $TypeName->ClassTypeId ?>">
                                                                    <?= $TypeName->ClassTypeName ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                                <label class="control-label col-md-6 col-sm-12 col-xs-12"><?= lang('am_education_type') ?><span class="danger">*</span></label>
                                                <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                                    <select data-value="<?php echo $num_student; ?>" id="studeType<?php echo $num_student; ?>" name="studeType<?php echo $num_student; ?>" class="form-control" required>
                                                        <option value=""><?php echo lang('am_choose_select'); ?>
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                                <label class="control-label col-md-6 col-sm-12 col-xs-12"><?= lang('br_school_name') ?>
                                                    <span class="danger">*</span></label>
                                                <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                                    <select data-value="<?php echo $num_student; ?>" id="school<?php echo $num_student; ?>" name="school<?php echo $num_student; ?>" class="form-control" required>
                                                        <option value=""><?php echo lang('am_choose_select'); ?>
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                                <label class="control-label col-md-6 col-sm-12 col-xs-12"><?= lang('am_level') ?>
                                                    <span class="danger">*</span></label>
                                                <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                                    <select data-value="<?php echo $num_student; ?>" id="levelID<?php echo $num_student; ?>" name="levelID<?php echo $num_student; ?>" class="form-control" required>
                                                        <option value=""><?php echo lang('am_choose_select'); ?>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                                <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                                    <?= lang('br_row_level') ?> <span class="danger">*</span></label>
                                                <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                                    <select data-value="<?php echo $num_student; ?>" id="rowID<?php echo $num_student; ?>" name="rowID<?php echo $num_student; ?>" class="form-control" required>
                                                        <option value=""><?php echo lang('am_choose_select'); ?>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="FeeStatus" id="FeeStatus" value="">
                                                <div id="show_status<?= $num_student ?>">
                                                    <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                                        <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('status') ?>
                                                            <span class="danger">*</span></label>
                                                        <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                                            <select data-value="<?= $num_student ?>" id="status<?= $num_student ?>" name="status<?= $num_student ?>" value="<?= set_value('status'); ?>" class="form-control" required>
                                                                <option value=""><?php echo lang('am_choose_select'); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content" style="display:none;">-->
                                            <!--    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('br_class') ?> <span class="danger">*</span></label>-->
                                            <!--    <div class="col-md-7 col-sm-12 col-xs-12 p-0">-->
                                            <!--        <select  id="classID<?php echo $num_student; ?>" name="classID<?php echo $num_student; ?>" class="form-control" required>-->
                                            <!--<option value="0"><?php echo lang('am_choose_select'); ?></option>-->
                                            <!--        </select>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                                <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                                    <?= lang('br_year') ?> <span class="danger">*</span></label>
                                                <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                                    <select data-value="<?php echo $num_student; ?>" id="YearId<?php echo $num_student; ?>" name="YearId<?php echo $num_student; ?>" class="form-control" required>
                                                        <option value=""><?php echo lang('am_choose_select'); ?>
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>

                                           <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                                <label class="control-label col-md-6 col-sm-12 col-xs-12">
                                                    <?= lang('Semester') ?> <span class="danger">*</span></label>
                                                <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                                    <select data-value="<?php echo $num_student; ?>" id="semester<?php echo $num_student; ?>" name="semester<?php echo $num_student; ?>" class="form-control" required>
                                                        <option value=""><?php echo lang('ra_Choose_semester'); ?></option>
                                                        <option value="1,2,3"><?php echo lang('am_fullyear'); ?></option>
                                                        <option value="2,3"><?php echo lang('ra_First_second_semester'); ?></option>
                                                        <option value="3"><?php echo lang('Semester') . " " . lang('er_third'); ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                                <label class="control-label col-md-6 col-sm-12 col-xs-12" style="font-size: 11px"><?= lang('am_how_school') ?> <span class="danger">*</span></label>
                                                <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                                    <select data-value="<?php echo $num_student; ?>" id="how_school<?php echo $num_student; ?>" name="how_school<?php echo $num_student; ?>" class="form-control" required>
                                                        <option value=""><?php echo lang('am_choose_select'); ?>
                                                        </option>
                                                        <?php foreach ($get_how_school as $item_how_school) { ?>
                                                            <option value="<?= $item_how_school->ID; ?>" <?php echo set_select('how_school', $item_how_school->Name, (!empty($data) && $data == $item_how_school->Name ? TRUE : FALSE)); ?>>
                                                                <?= $item_how_school->Name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                                <label class="control-label col-md-6 col-sm-12 col-xs-12"><?php if ($this->ApiDbname == "SchoolAccUniversitySchools") {
                                                                                                                echo lang('er_TeacherName');
                                                                                                            } else {
                                                                                                                echo lang('am_notes');
                                                                                                            } ?></label>
                                                <div class="col-md-6 col-sm-12 col-xs-12 p-0">
                                                    <input data-value="<?php echo $num_student; ?>" type="text" id="note<?php echo $num_student; ?>" name="note<?php echo $num_student; ?>" class="form-control">
                                                </div>
                                            </div>


                                        </div>
                                        <!--<div id="append_student"> <div class="clearfix"></div><div class="clearfix"></div></div>-->
                                        <!--        <input readonly onclick="add_student()" class="btn btn-danger" value="<?= lang('am_add_student') ?>">-->
                                        <div id="append_student"></div>
                                        <a href="javascript:void(0)" class="btn btn-success addstu" style="width: 135px;margin-left:15px"><?= lang('am_add_student') ?></a>
                                        <h4></h4>
                                        <?php if ($this->ApiDbname == "SchoolAccManahelAlBukayriyah") { ?>
                                            <br>
                                            <input type="checkbox" id="allowphoto" name="allowphoto" value="1" style="width:auto;font-family: 'Neo Sans Arabic', sans-serif !important" required> <?= lang('am_reg_note') ?>
                                            <h4></h4>
                                            <br>
                                            <input type="checkbox" id="allowphoto1" name="allowphoto1" value="1" style="width:auto;font-family: 'Neo Sans Arabic', sans-serif !important" required> <?= lang('am_reg_note1') ?>
                                            <h4></h4>
                                            <br>
                                            <input type="checkbox" id="allowphoto2" name="allowphoto2" value="1" style="width:auto;font-family: 'Neo Sans Arabic', sans-serif !important" required> <?= lang('am_reg_note2') ?>
                                        <?php } else { ?>
                                            <br>
                                            <input type="checkbox" id="allowphoto" name="allowphoto" value="1" style="width:auto;font-family: 'Neo Sans Arabic', sans-serif !important" required> <?= lang('na_accept') ?>
                                        <?php } ?>
                                        <div class="text-left">

                                        <!--    <php $queryFile = $this->db->query("SELECT dtls.MainSubID ,dtls.Title AS Name,dtls.ImagePath from cms_details AS dtls -->
                                        <!--        INNER JOIN cms_main_sub_new ON cms_main_sub_new.ID = dtls.MainSubID -->
                                        <!--        WHERE cms_main_sub_new.ID = 209 AND dtls.`ImagePath` != '' ")->result(); ?>-->

                                        <!--    <php foreach ($queryFile as $item) {-->
                                        <!--        $MainSubID  = $item->MainSubID;-->
                                        <!--        $Name       = $item->Name;-->
                                        <!--        $Image      = explode(",", $item->ImagePath);-->
                                        <!--        $ImagePath  = $Image[0];-->
                                        <!--    ?>-->
                                        <!--        <a class="download btn btn-info send" download="<?php echo $Name ?>" href="<php if ($ImagePath) {-->
                                        <!--                                                                                        echo base_url(); ?>upload/<php echo $ImagePath;-->
                                        <!--                                                                                                                } else {-->
                                        <!--                                                                                                                    echo '#';-->
                                        <!--                                                                                                                } ?>" style="margin: 4px 2px;"><?php echo $Name ?></a>-->
                                        <!--    <php } ?>-->
                                            <input type="submit" class="btn btn-info send" value="<?= lang('am_send') ?>" id="show2" style="width: 110px" />
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <?php if (base_url() == 'https://almanhalschools.edu.sa') { ?>
            <div>
                <div style="padding: 11px 38% 11px 38%;text-align: center;">
                    <h2 style="text-align:center;color: aliceblue;"><?= lang('Our_partners') ?></h2>
                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="logo col-md-10 col-xs-12" style="text-align: center;width: auto;float: inherit;">
                        <img class="custom-img" src="<?php echo base_url(); ?>intro/images/British-Council-logo_0.png">
                        <img class="custom-img" src="<?php echo base_url(); ?>intro/images/Cognia_RGB_Logotype_FullColor.png">
                        <img class="custom-img2" src="<?php echo base_url(); ?>intro/images/iso-206939.png">
                        <img class="custom-img2" src="<?php echo base_url(); ?>intro/images/ln_25_1.png">
                        <img class="custom-img3" src="<?php echo base_url(); ?>intro/images/map.png">
                        <img class="custom-img" src="<?php echo base_url(); ?>intro/images/كلاسيرا.png">
                        <img class="custom-img" src="<?php echo base_url(); ?>intro/images/SAT1-min.jpeg">
                        <img class="custom-img2" src="<?php echo base_url(); ?>intro/images/esologo.png">
                    </div>
                </div>

            </div>
        <?php } ?>
    </div>
</div>

</div>
<script>
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
    function validation_speed() {
        ///////////////

        if ($('select[name="levelID"]').val() == 0) {
            alert('اختر المرحله للطالب    ');
            return false;
        }
        return true;

    }

    function ValidateEmail(mail) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.emailAddr.value)) {
            return (true)
        }
        alert("You have entered an invalid email address!")
        return (false)
    }
</script>

<script>
    var index = $('#num_student').val();
    $('#ClassTypeName' + index).on('change', function() {
        var ClassTypeName = $(this).val();
        var DbName = $('#DbName').val();

        if (ClassTypeName) {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetAllStudyTypes',
                type: "GET",
                data: {},
                dataType: "json",
                success: function(data) {
                    $('#studeType' + index).empty();
                    $('#school' + index).empty();
                    $('#levelID' + index).empty();
                    $('#rowID' + index).empty();
                    $('#studeType' + index).append(
                        '<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        $('#studeType' + index).append('<option value="' + value.StudyTypeId +
                            '">' +
                            value.StudyTypeName + '</option>');
                    });
                }
            });
        } else {
            $('#studeType' + index).empty();
            $('#studeType' + index).append('<option value="0" ><?php echo lang('am_choose_select'); ?></option>');
        }
        $('#studeType' + index).trigger('change');
        $('#school' + index).trigger('change');
    });
</script>
<script>
    var index = $('#num_student').val();
    $('#studeType' + index).on('change', function() {
         document.getElementById("show_status"+ index).style.display = "none";
        var studeType = $(this).val();
        var DbName = $('#DbName').val();

        if (studeType) {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/Schools/' + DbName + '/GetSchoolsByStudyType',
                type: "GET",
                data: {
                    studyTypeId: studeType
                },
                dataType: "json",
                success: function(data) {
                    $('#school' + index).empty();
                    $('#school' + index).append(
                        '<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        $('#school' + index).append('<option value="' + value.SchoolId + '">' +
                            value.SchoolName + '</option>');
                    });
                }
            });
        } else {
            $('#school' + index).empty();
            $('#school' + index).append('<option value="0" ><?php echo lang('am_choose_select'); ?></option>');
        }
        $('#school' + index).trigger('change');
        $('#levelID' + index).trigger('change');
    });
</script>



<script type="text/javascript">
    var index = $('#num_student').val();
    $('#school' + index).on('change', function() {

        var studeType = $('#studeType' + index).val();
        var school = $(this).val();
        var ClassTypeName = $('#ClassTypeName' + index).val();
        var DbName = $('#DbName').val();
        if (school && studeType != "") {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetLevelsBySchool',
                type: "GET",
                data: {
                    schoolId: school,
                    studyTypeId: studeType,
                    genderId: ClassTypeName
                },
                dataType: "json",
                success: function(data) {

                    $('#levelID' + index).empty();
                    $('#levelID' + index).append(
                        '<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        $('#levelID' + index).append('<option value="' + value.LevelId + '">' +
                            value.LevelName + '</option>');

                    });
                }
            });
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetClassesBySchool',
                type: "GET",
                data: {
                    schoolId: school
                },
                dataType: 'json',
                success: function(data) {
                    var element = $('#classID');
                    element.empty();
                    // element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        element.append('<option value="' + value.ClassId + '">' + value
                            .ClassName + '</option>');
                    });
                }
            });
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/Years/' + DbName + '/GetOpenedYearsBySchoolId',
                type: "GET",
                data: {
                    schoolId: school
                },
                dataType: 'json',
                success: function(data) {
                    var element = $('#YearId' + index);
                    element.empty();
                    element.append(
                        '<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                   
                    var year_array = $('#reg_year').val();
                    var reg_year   = $('#reg_year').val().split(',');
                    if(year_array ==0){
                    var lastElement = null;
                    $.each(data, function(key, value) {
                        lastElement = value;
                    });
                    element.append('<option value="' + lastElement.YearId + '">' + lastElement
                        .YearName + '</option>');
                    }else{
                         $.each(data, function(key, value) {
                        if (reg_year.includes(value.YearName)) {
                        element.append('<option value="' + value.YearId + '">' + value.YearName + '</option>');
                        }
                        });

                    }
                   
                }
            });
        } else {

            $('#levelID' + index).empty();
            $('#levelID' + index).append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
        $('#levelID' + index).trigger('change');
    });
</script>

<script type="text/javascript">
    var index = $('#num_student').val();
    $('#levelID' + index).on('change', function() {
        var levelID = $(this).val();
        var school = $('#school' + index).val();
        var studeType = $('#studeType' + index).val();
        var ClassTypeName = $('#ClassTypeName' + index).val();
        var DbName = $('#DbName').val();
        if (school && levelID) {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetRowsByLevel',
                type: "GET",
                data: {
                    schoolId: school,
                    levelId: levelID,
                    studyTypeId: studeType,
                    genderId: ClassTypeName
                },
                dataType: "json",
                success: function(data) {
                    $('#rowID' + index).empty();
                    $('#rowID' + index).append(
                        '<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        $('#rowID' + index).append('<option value="' + value.RowId + '">' +
                            value.RowName + '</option>');
                            $('#FeeStatus').val(value.IsSpecialEdu);
                             var selectElement = document.getElementById("status" + index);
                        if (value.IsSpecialEdu == 1) {
                            document.getElementById("show_status" + index).style.display = "block";
                            selectElement.setAttribute("required", "required");
                        } else {
                            document.getElementById("show_status" + index).style.display = "none";
                            selectElement.removeAttribute("required");
                           
                        }
                    });
                }
            });
        } else {
            $('#rowID' + index).empty();
            $('#rowID' + index).append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
    });
</script>
<script type="text/javascript">
 var index = $('#num_student').val();
        $('#rowID' + index).on('change', function() {
       
        var rowId = $(this).val();
        var schoolID = $('#school' + index).val();
        var studeType = $('#studeType' + index).val();
        var ClassTypeName = $('#ClassTypeName' + index).val();
        var levelID = $('#levelID' + index).val();
        var DbName = $('#DbName').val();
        if (schoolID && levelID && rowId) {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetFeeStatus',
                type: "GET",
                data: {
                    schoolId: schoolID,
                    levelId: levelID,
                    rowId: rowId,
                    studyTypeId: studeType,
                    genderId: ClassTypeName
                },
                dataType: "json",
                success: function(data) {
                    var element = $('#status' + index);
                    element.empty();
                    element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        element.append('<option value="' + value.StatusId + '">' + value
                            .StatusName + '</option>');
                    });
                }
            });
        } else {
            var element = $('#status' + index);
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        document.getElementById("show_status"+ index).style.display = "none";
        $("#result_student").hide();
        $("#show").show();
        $("#show2").hide();

    });

    function GetData() {
        var DbName = $('#DbName').val();
        var ParentNumberID = $('#ParentNumberID').val();
        var parent_name    = $('#parent_name').val();
        var grandba_name   = $('#grandba_name').val();
        var family_name    = $('#family_name').val();
        var parent_national_ID = $('#parent_national_ID').val();
        var parent_mobile = $('#parent_mobile').val();
        var parent_mobile2 = $('#parent_mobile2').val();
        var parent_email = $('#parent_email').val();
        if ($("#ParentNumberID").val().length < 10 || $("#ParentNumberID").val().length > 10) {
            alert('رقم الهويه يجب الا يقل عن 10 ارقام ولا يزيد عن 10 رقم');
            return false;
        }
        if ($("#parent_email").val().length == 0 && DbName == 'SchoolAccanwaralfayhaa') {
            alert('يجب ادخال البريد الالكتروني');
            return false;
        }

        var data = {
            ParentNumberID: ParentNumberID,
            parent_name: parent_name,
            grandba_name: grandba_name,
            family_name: family_name,
            parent_national_ID: parent_national_ID,
            parent_mobile: parent_mobile,
            parent_mobile2: parent_mobile2,
            parent_email: parent_email
        };
        $.ajax({
            url: "<?php echo site_url('home/student_register/add_father_data') ?>",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
                $("#result_student").show();
                $("#show").hide();
                $("#show2").show();
                var Parent_ID = data.Parent_ID;
                $("#Parent_ID").val(Parent_ID);
            }
        });
    }
    $('#parent_mobile').on('input', function(e) {
            var txtVal = $(this).val();
            var val_number = toEnglishNumber(txtVal)
            $('#parent_mobile_new').val(val_number);
        });
        $('#parent_mobile2').on('input', function(e) {
            var txtVal = $(this).val();
            var val_number = toEnglishNumber(txtVal)
            $('#parent_mobile2_new').val(val_number);
        });
        $('#parent_email').on('input', function(e) {
            var txtVal = $(this).val();
            $('#parent_email_new').val(txtVal);
        });
        $('#parent_name').on('input', function(e) {
            var txtVal = $(this).val();
            $('#parent_name_new').val(txtVal);
        });
        $('#grandba_name').on('input', function(e) {
            var txtVal = $(this).val();
            $('#grandba_name_new').val(txtVal);
        });
        $('#family_name').on('input', function(e) {
            var txtVal = $(this).val();
            $('#family_name_new').val(txtVal);
        });
        $('#ParentNumberID').on('input', function(e) {
            var txtVal = $(this).val();
            var val_number = toEnglishNumber(txtVal)
            $('#ParentNumberID_new').val(val_number);
        });
        $('#parent_region').on('input', function(e) {
            var txtVal = $(this).val();
            $('#parent_region_new').val(txtVal);
        });
         $('#parent_national_ID').on('change', function(e) {
        var selectedVal = $(this).val();
        $('#parent_national_ID_new').val(selectedVal);
    });
    // 	function add_student(){
    // 	       var num_student        = parseInt($('#num_student').val());
    //           var num_student        = num_student+1 ;
    //          $("#num_student").val(num_student);
    //          $('#append_student').append($('#add_stu').html());

    // 	}
</script>
<script type="text/javascript">
    var num_student = 2;
    $(".addstu").click(function(event) {
        event.preventDefault();
        $.ajax({
            url: '<?php echo site_url(); ?>' + '/home/student_register/add_another_stu/' + num_student,
            type: "get",
            dataType: "html",
            success: function(data) {
                $('#append_student').append(data);


                var index = num_student;
                $("#num_ALL_Student").val(num_student);
                $('#studeType' + index).on('change', function() {
                    document.getElementById("show_status"+ index).style.display = "none";
                    var studeType = $(this).val();
                    var DbName = $('#DbName').val();

                    if (studeType) {
                        $.ajax({
                            url: '<?php echo lang("api_link"); ?>' + '/api/Schools/' +
                                DbName + '/GetSchoolsByStudyType',
                            type: "GET",
                            data: {
                                studyTypeId: studeType
                            },
                            dataType: "json",
                            success: function(data) {
                                $('#school' + index).empty();
                                $('#levelID' + index).empty();
                                $('#rowID' + index).empty();
                                $('#school' + index).append(
                                    '<option value=""><?php echo lang('am_choose_select'); ?></option>'
                                );
                                $.each(data, function(key, value) {
                                    $('#school' + index).append(
                                        '<option value="' + value
                                        .SchoolId + '">' + value
                                        .SchoolName + '</option>');
                                });
                            }
                        });
                    } else {
                        $('#school' + index).empty();
                        $('#school' + index).append(
                            '<option value="" ><?php echo lang('am_choose_select'); ?></option>'
                        );
                    }
                    $('#school' + index).trigger('change');
                    $('#levelID' + index).trigger('change');
                });

                $('#school' + index).on('change', function() {

                    var studeType = $('#studeType' + index).val();
                    var school = $(this).val();
                    var ClassTypeName = $('#ClassTypeName' + index).val();
                    var DbName = $('#DbName').val();
                    if (school && studeType != "") {
                        $.ajax({
                            url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' +
                                DbName + '/GetLevelsBySchool',
                            type: "GET",
                            data: {
                                schoolId: school,
                                studyTypeId: studeType,
                                genderId: ClassTypeName
                            },
                            dataType: "json",
                            success: function(data) {

                                $('#levelID' + index).empty();
                                $('#rowID' + index).empty();
                                $('#levelID' + index).append(
                                    '<option value="0"><?php echo lang('am_choose_select'); ?></option>'
                                );
                                $.each(data, function(key, value) {
                                    $('#levelID' + index).append(
                                        '<option value="' + value
                                        .LevelId + '">' + value
                                        .LevelName + '</option>');

                                });
                            }
                        });
                        $.ajax({
                            url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' +
                                DbName + '/GetClassesBySchool',
                            type: "GET",
                            data: {
                                schoolId: school
                            },
                            dataType: 'json',
                            success: function(data) {
                                var element = $('#classID');
                                element.empty();
                                $.each(data, function(key, value) {
                                    element.append('<option value="' + value
                                        .ClassId + '">' + value
                                        .ClassName + '</option>');
                                });
                            }
                        });
                        $.ajax({
                            url: '<?php echo lang("api_link"); ?>' + '/api/Years/' +
                                DbName + '/GetOpenedYearsBySchoolId',
                            type: "GET",
                            data: {
                                schoolId: school
                            },
                            dataType: 'json',
                            success: function(data) {
                                var element = $('#YearId' + index);
                                element.empty();
                                element.append(
                                    '<option value="" ><?php echo lang('am_choose_select'); ?></option>'
                                );
                    
                                    var year_array = $('#reg_year').val();
                                    var reg_year   = $('#reg_year').val().split(',');
                                    if(year_array ==0){
                                    var lastElement = null;
                                    $.each(data, function(key, value) {
                                        lastElement = value;
                                    });
                                    element.append('<option value="' + lastElement.YearId + '">' + lastElement
                                        .YearName + '</option>');
                                    }else{
                                        $.each(data, function(key, value) {
                                        if (reg_year.includes(value.YearName)) {
                                        element.append('<option value="' + value.YearId + '">' + value.YearName + '</option>');
                                        }
                                        });

                                    }
                               
                            }
                        });
                    } else {

                        $('#levelID' + index).empty();
                        $('#levelID' + index).append(
                            '<option value="" ><?php echo lang('am_choose_select'); ?></option>'
                        );
                    }
                    $('#levelID' + index).trigger('change');
                });

                $('#levelID' + index).on('change', function() {
                    var levelID = $(this).val();
                    var school = $('#school' + index).val();
                    var studeType = $('#studeType' + index).val();
                    var ClassTypeName = $('#ClassTypeName' + index).val();
                    var DbName = $('#DbName').val();
                    if (school && levelID) {
                        $.ajax({
                            url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' +
                                DbName + '/GetRowsByLevel',
                            type: "GET",
                            data: {
                                schoolId: school,
                                levelId: levelID,
                                studyTypeId: studeType,
                                genderId: ClassTypeName
                            },
                            dataType: "json",
                            success: function(data) {
                                $('#rowID' + index).empty();
                                $('#rowID' + index).append(
                                    '<option value=""><?php echo lang('am_choose_select'); ?></option>'
                                );
                                $.each(data, function(key, value) {
                                    $('#rowID' + index).append(
                                        '<option value="' + value
                                        .RowId + '">' + value.RowName +
                                        '</option>');
                                        $('#FeeStatus').val(value.IsSpecialEdu);
                                         var selectElement = document.getElementById("status" + index);
                                        if (value.IsSpecialEdu == 1) {
                                            document.getElementById("show_status" + index).style.display = "block";
                                            selectElement.setAttribute("required", "required");
                                        } else {
                                            document.getElementById("show_status" + index).style.display = "none";
                                            selectElement.removeAttribute("required");
                                           
                                        }
                                });
                            }
                        });
                    } else {
                        $('#rowID' + index).empty();
                        $('#rowID' + index).append(
                            '<option value="" ><?php echo lang('am_choose_select'); ?></option>'
                        );
                    }
                });
                
                 $('#rowID' + index).on('change', function() {
        
        var rowId = $(this).val();
        var schoolID = $('#school' + index).val();
        var studeType = $('#studeType' + index).val();
        var ClassTypeName = $('#ClassTypeName' + index).val();
        var levelID = $('#levelID' + index).val();
        var DbName = $('#DbName').val();
        if (schoolID && levelID && rowId) {
            $.ajax({
                url: '<?php echo lang("api_link"); ?>' + '/api/RowLevels/' + DbName + '/GetFeeStatus',
                type: "GET",
                data: {
                    schoolId: schoolID,
                    levelId: levelID,
                    rowId: rowId,
                    studyTypeId: studeType,
                    genderId: ClassTypeName
                },
                dataType: "json",
                success: function(data) {
                    var element = $('#status' + index);
                    element.empty();
                    element.append('<option value=""><?php echo lang('am_choose_select'); ?></option>');
                    $.each(data, function(key, value) {
                        element.append('<option value="' + value.StatusId + '">' + value
                            .StatusName + '</option>');
                    });
                }
            });
        } else {
            var element = $('#status' + index);
            element.empty();
            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
        }
    });
                num_student++;
            }
        });
    });
</script>
<?php include('home_new/footer.php'); ?>