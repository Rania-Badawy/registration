<?php $query = $this->db->query("select * from setting")->row_array();

$home_theme = $query['home_theme'];
if ($home_theme) {
    include('home_new/' . $home_theme . '/header.php');
} else {
    include('home_new/header.php');
}
?>
<!--//header-->
<?php $query = $this->db->query("select * from setting")->row_array(); ?>
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
<!--///////////-->

<?php //print_r($get_levels);die;  
?>
<div style="color:red" id="recaptchaMsg"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<?php $settingQuery = $this->db->query("select * from setting")->row_array(); ?>
<?php $setting = $this->db->query("SELECT * FROM `form_setting` WHERE form_type = 1")->result(); ?>
<link href="https://fonts.cdnfonts.com/css/neo-sans-arabic?styles=50556,50562" rel="stylesheet">

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

    .tab-content {
        display: block !important;
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

    <?php if ($setting[43]->display == 1) { ?>.nav-tabs>li {
        width: 25%;
    }

    <?php } ?>@media(max-width:992px) {
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

    <?php if ($this->ApiDbname == "SchoolAccAdvanced") { ?>.navbar {
        display: none;
    }

    <?php } ?>.list-group-item-text {
        text-align: center
    }

    <?php if ($lang != 'english') { ?>.container-dd {
        direction: rtl !important;
        min-height: 900px;
    }

    .nav-tabs.nav-tabs-ddds>li {
        float: right !important;
    }

    <?php } else { ?>.container-dd {
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

    <?php } ?>.lang_st {
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
</style>
<?php $query = $this->db->query("select * from setting")->row_array(); ?>
<div class="container container-dd">
    <div class="row">
        <div class="col-md-12 text-left" style="display: none">
            <?php if ($this->ApiDbname != "SchoolAccAdvanced" && $this->ApiDbname != "SchoolAccSinwan") { ?>
                <?php
                $langSession = $lang;
                switch ($langSession) {
                    case 'arabic':
                ?><a href="<?php echo site_url('home/home/set_lang/L/1'); ?>" class="lang_st">English</a> <?php
                                                                                                            break;
                                                                                                        case 'english':
                                                                                                            ?><a href="<?php echo site_url('home/home/set_lang/L/2'); ?>" class="lang_st">العربية</a> <?php
                                                                                                            break;
                                                                                                        default:
                                                                                                            ?><a href="<?php echo site_url('home/home/set_lang/L/1'); ?>" data-toggle="tooltip" data-placement="right" title="<?php echo $lang_word; ?>" class="lang_st"><i style="font-size: 30px;" class="fa fa-globe"></i></a> <?php
                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                        ?>
                <?php if ($query['homeLink']) { ?>
                    <a class="btn btn-danger btn-st btn-st" href="<?php echo $query['homeLink'] ?>" target="_blank"><?php echo lang('am_home'); ?> </a>
                <?php } else { ?>
                    <a class="btn btn-danger btn-st btn-st" href="<?= site_url(); ?>"><?php echo lang('am_home'); ?> </a>
                <?php } ?>
            <?php } ?>
        </div>


        <a target="_blank" class="btn" href="<?= base_url('home/student_register/check_code/' . $lang) ?>" style="float: left;background: var(--main-color);color: #fff;"><?php echo lang('am_new_student_Check_Code'); ?></a>
        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
            <img src="<?= base_url() ?>intro/images/school_logo/<?php echo $query['Logo'] ?>" class="mt-20" width="120" />

            <? if ($settingQuery['ApiDbname'] == 'SchoolAccAndalos') { ?>
                <img src="<?= base_url() ?>intro/images/school_logo/andalus_alamya.png" class="mt-20" width="80" />
            <? } ?>
            <h3 style="margin-bottom: 35px;font-family:  'Neo Sans Arabic', 
            sans-serif !important; "><?= lang('am_RegistrationForm') ?></h3>
        </div>
    </div>
    <ul class="nav nav-tabs nav-tabs-ddds">
        <li class="active">
            <a href="#tab1" data-toggle="tab">
                <h4 class="list-group-item-heading btnNext"><?= lang('am_frist_stap') ?></h4>
                <p class="list-group-item-text"> <?= lang('am_student_information') ?></p>
            </a>
        </li>



        <li>
            <a <?php if ($this->ApiDbname == "SchoolAccAdvanced") { ?>href="#" <?php } else { ?>href="#tab2" <?php } ?> data-toggle="tab">
                <h4 class="list-group-item-heading btnNext"><?php if ($setting[43]->display == 0) {
                                                                echo lang('am_third_step');
                                                            } else {
                                                                echo lang('am_frist_second');
                                                            } ?></h4>
                <p class="list-group-item-text"> <?= lang('am_Registration'); ?> </p>

            </a>
        </li>
    </ul>
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



    <form action="<?php echo site_url('home_new/home/NewRegisterInstitute'); ?>" method="post" id="registration-form" style="margin:25px 10px">
        <div class="tab-content">
            <!--    Tab1    -->
            <div class="tab-pane active" id="tab1">
                <div class="col-xs-12 p-0">
                    <div class="col-md-12 p-0">
                        <div class="row">
                            <div class="col-xs-12 title_register">
                                <h5><i class="fa fa-user" aria-hidden="true"></i><?= lang('am_Quadrant_name') ?></h5>
                            </div>
                            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('am_frist_name') ?> <span class="danger">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                    <input type="text" id="student_name" name="student_name" onkeyup="checkLnag($(this), 'ar');" maxlength="12" value="" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content">
                                <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('er_Gender') ?> <span class="danger">*</span></label>
                                <div class="col-md-7 col-sm-12 col-xs-12 p-0">
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option value=""><?php echo lang('am_choose_select'); ?></option>
                                        <option value="1">ذكر</option>
                                        <option value="2">انثى</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 text-left mt-20 p-0">
                        <a class="btn btnNext btn_regist"><?= lang('am_Next') ?></a>
                    </div>
                </div>

            </div>

            <!--    Tab4    -->
            <div class="tab-pane" id="tab2">
                <div class="col-xs-12 p-0">

                    <div class="row">
                        <div>
                            <?php if ($setting[60]->display == 1) { ?>
                                <p>
                                    <span style="color: #333333; font-size: large; font-weight: 500;">
                                        <?= lang('config_register') ?>
                                        <br><br>

                                        <input type="radio" id="allowphoto" name="allowphoto" value="1" style="width:auto;" <?php if ($setting[60]->required == 1) {
                                                                                                                                echo 'required';
                                                                                                                            } ?>> <?= lang('na_accept') ?>
                                        <input type="radio" id="allowphoto2" name="allowphoto" value="0" style="width:auto;"> <?= lang('disagree') ?>
                                    </span>
                                </p>
                            <?php } ?>

                            <p class="text-justify" style="line-height: 50px;font-size: 20px;"> <?php if ($this->ApiDbname == "SchoolAccAdvanced") {
                                                                                                    echo lang('config_register1');
                                                                                                } else {
                                                                                                    echo lang('am_txtnew_dew');
                                                                                                } ?> </p>

                            <div class="col-md-12 p-0">

                                <div class="clearfix"></div>
                                <div class="form-group col-md-4 col-sm-6 col-xs-12 register_form_content mt-20">
                                    <label class="control-label col-md-5 col-sm-12 col-xs-12"> <?= lang('am_Signature') ?> <span class="danger">*</span></label>
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

<script type="text/javascript">
    var img = null;

    function upload_file2(fileInput, name) {
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
    function checkLnag(input, lang) {
        var userInput = input.val();

        if (lang == 'ar') {
            let regex = /^[؀-ۿ ]+$/;
            let regex1 = /[{٠-٩}]/;
            if (userInput.match(regex1) || !userInput.match(regex)) {
                // alert("Only use Arabic characters!");
                input.val('');
            }
        } else {
            let regex = /[\u0600-\u06FF\u0750-\u077F^0-9{٠-٩}]/;
            if (userInput.match(regex)) {
                //  alert("Only use English characters!");
                input.val('');
            }
        }
    }

    function checktext(input) {
        var userInput = input.val();

        let regex = /[{0-9}]/;
        let regex1 = /[{٠-٩}]/;
        if (userInput.match(regex1) || userInput.match(regex)) {
            // alert("Only use Arabic characters!");
            input.val('');
        }

    }
</script>

<script>
    $(document).ready(function() {
        // $('#person_name').keyup(function(e) {
        //     var txtVal = $(this).val();
        //     $('#Signature').attr("value", txtVal);
        // });
        $('#parent_name').keyup(function(e) {
            var txtVal = $(this).val();
            var ApiDbname = $("#ApiDbname").val();
            $('#person_name').attr("value", txtVal);
            if (ApiDbname == "SchoolAccRemas") {
                $('#Signature').attr("value", txtVal);
            }
        });

        $('#ParentNumberID').keyup(function(e) {
            var txtVal = $(this).val();
            $('#person_NumberID').attr("value", txtVal);
        });
        $('#parent_mobile').keyup(function(e) {
            var txtVal = $(this).val();
            $('#person_mobile').attr("value", txtVal);
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
                    //
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
                parent_mobile2: {
                    number: true,
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
                    maxlength: 50
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
                    maxlength: 20
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
                    // minlength: "<?= lang('Please enter at least 10 characters') ?>",
                    // maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
                },
                parent_name_eng: {
                    required: "<?= lang('This field is required') ?>"
                    // minlength: "<?= lang('Please enter at least 10 characters') ?>",
                    // maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
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
                parent_mobile2: {
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
                    maxlength: "<?= lang('Please enter no more than 50 characters') ?>"
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
                    maxlength: "<?= lang('Please enter no more than 20 characters') ?>"
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

        // Only ASCII charactar in that range allowed 
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


<?php include('home/footer.php'); ?>