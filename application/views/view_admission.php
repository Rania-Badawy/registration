<?php $query = $this->db->query("select * from setting")->row_array();

$home_theme = $query['home_theme'];
if ($home_theme) {
    include('home_new/' . $home_theme . '/header.php');
} else {
    include('home_new/header.php');
}
?>

<link href="https://fonts.cdnfonts.com/css/fakt-pro" rel="stylesheet">
<link href="https://fonts.cdnfonts.com/css/neo-sans-arabic?styles=50556,50562" rel="stylesheet">




<style>
    .btn.btn-success,
    .form-check {
        font-family: 'Neo Sans Arabic', sans-serif !important;
    }

    span {
        font-size: 18px;
        font-weight: bold;
    }

    .cd-top {
        display: none;
    }

    #acceptChkBtn,
    .download {
        text-decoration: none;
        background: var(--main-color);
        padding: 8px;
        color: #fff;
        border-radius: 5px;
    }

    .form-check label {
        font-weight: 500;
    }

    .lang_st {
        text-decoration: none;
        background: #2a3b66;
        height: 30px;
        display: inline-block;
        width: 120px;
        text-align: center;
        line-height: 30px;
        color: #fff;
        border-radius: 10px;
    }

    .tooltip.fade.right {
        display: none !important;
    }

    #profile-description {
        position: relative;
        top: 70px;
        background: #fff;
        width: fit-content;
        box-shadow: 0 0 5px 5px #eaeaea;
        padding: 15px;
        margin: 0 auto 70px;
    }

    .rowImage {
        justify-content: center;
        border-bottom: 3px solid #bfbfbf;
        margin: 0 auto 10px;
        padding: 10px;
    }

    .lang_st:hover {
        text-decoration: none;
        color: #FFF;
    }

    .top-bar,
    .nav-bar,
    footer {
        display: none;
    }

    <?php if ($this->session->userdata('language') == 'arabic') {
    ?>.download {
        float: left;
    }

    .txt_accpt {
        text-align: right !important;
    }

    .txt_accpt2 {
        text-align: left;
    }

    <?php
    } else {
    ?>.download {
        float: right;

    }

    .txt_accpt {
        text-align: left !important;
    }

    .txt_accpt2 {
        text-align: right;
    }

    <?php
    }

    ?>#profile-description .show-more {
        /*   width: 690px;  */
        color: #777;
        position: relative;
        font-size: 12px;
        padding-top: 5px;
        /*height: 20px; */
        text-align: center;
        background: #f1f1f1;
        cursor: pointer;
    }

    #profile-description .show-more:hover {
        color: #1779dd;
    }

    <?php if ($query['ApiDbname'] == "SchoolAccMadac") {
    ?>#profile-description .show-more-height {
        height: 40px;
        overflow: hidden;
    }

    <?php
    }

    ?>#SchoolData,
    .news-bar {
        display: none;
    }

    #school_id {
        visibility: hidden;
        opacity: 0;
    }

    @media screen and (max-width: 600px) {
        #profile-description {
            top: 0 !important;
            width: unset !important;
        }

        #profile-description img {
            width: 100% !important;
        }

        #profile-description p {
            text-align: center !important;
        }
    }
    <?php if ($this->ApiDbname == "SchoolAccAdvanced" || $this->ApiDbname == "SchoolAccJeelAlriyada") {
    ?>.navbar {
        display: none;
    }
    <?php } ?>
</style>
<div class="clearfix"></div>

<div class="container">

    <div class="col-lg-12 col-md-12">
        <div class="widgets-box widgets-box-in wow fadeIn" data-wow-duration="0s" data-wow-delay="0s" style="padding-bottom:20px;background:url(/upload/bg-pattern.jpg) repeat">
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

            <?php $query = $this->db->query("select * from setting")->row_array(); ?>
            <div class="widgets-box-data" style="margin: 185px 0 0;">
                <div class="cd-testimonials-wrapper cd-container">
                    <div id="profile-description" class="col-md-12 col-sm-12 col-xs-12" style="">
                        <div class="row rowImage">
                            <img src="<?php echo base_url(); ?>intro/images/school_logo/<?php echo $query['Logo']; ?>" class="mt-20" style="width:150px !important">
                        </div>
                        <?php
                        $cms_main_sub = 'cms_main_sub_new';
                        if ($query['home_type'] == 1) {
                            $cms_main_sub = 'cms_main_sub';
                        } ?>
                        <?php $queryFile = $this->db->query("SELECT dtls.MainSubID ,dtls.Title AS Name,dtls.ImagePath from cms_details AS dtls 
                                INNER JOIN $cms_main_sub ON $cms_main_sub.ID = dtls.MainSubID 
                                WHERE $cms_main_sub.ID = 209 AND dtls.`ImagePath` != '' ")->result(); ?>
                        <?php $queryConditions = $this->db->query("SELECT * FROM `cms_details` INNER JOIN $cms_main_sub ON $cms_main_sub.ID = cms_details.MainSubID WHERE $cms_main_sub.IsActive != 0 AND cms_details.MainSubID = 209")->row_array(); ?>

                        <?php foreach ($queryFile as $item) {
                            $MainSubID  = $item->MainSubID;
                            $Name       = $item->Name;
                            $Image      = explode(",", $item->ImagePath);
                            $ImagePath  = $Image[0];
                        ?>
                            <a class="download btn btn-success" download="<?php echo $Name ?>" href="<?php if ($ImagePath) {
                                                                                                        echo base_url(); ?>upload/<?php echo $ImagePath;
                                                                                                                                                } else {
                                                                                                                                                    echo '#';
                                                                                                                                                } ?>" style="margin: 4px 2px;"><?php echo $Name ?></a>
                        <?php } ?>
                        <br>
                        <div class="clearfix"></div>
                        <?php if ($query['ApiDbname'] == "SchoolAccMadac") { ?>
                            <p class="txt_accpt"><?php echo lang('accept_reg5') ?></p>
                            <p class="txt_accpt"><?php echo lang('accept_reg') ?></p>
                            <p class="txt_accpt"><?php echo lang('accept_reg2') ?></p>
                        <?php } ?>
                        <div class="iframe-box text show-more-height">
                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <?php if ($this->session->userdata('language') == 'arabic') {
                                echo $queryConditions['Content'];
                            } else {
                                echo $queryConditions['Content_en'];
                            } ?>
                        </div>
                        <?php $query = $this->db->query("select * from setting")->row_array();
                        if ($query['ApiDbname'] == "SchoolAccMadac") { ?>
                            <div class="show-more"><?php echo lang('am_more') ?></div>
                        <?php } ?>

                        <div style="display:flex;justify-content: space-around;margin-top: 30px">
                            <div class="txt_accpt">
                                <div class="form-check" dir="auto">
                                    <input type="checkbox" class="form-check-input" id="acceptChk" name="acceptChk">
                                    <label class="form-check-label" for="acceptChk">
                                        <?php echo lang('na_accept'); ?></label>

                                </div>
                            </div>
                            <?php
                            $reg = $this->db->query("select * from school_details ")->row_array();
                            ?>
                            <div class="txt_accpt2">
                                <a class="btn btn-success" id="acceptChkBtn" onclick="return acceptChk();" <?php if ($reg['reg_type'] == 1) { ?>href="<?php echo site_url('home/student_register/index'); ?>" <?php } else { ?> href="<?php echo site_url('home_new/Student_register/register_form'); ?>" <?php } ?>>
                                    <?php echo lang('am_Registration'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>

        </div><!-- widgets-box End -->

    </div>
</div>





<div class="clearfix"></div>

<script>
    function acceptChk() {
        if (document.getElementById('acceptChk').checked == false) {
            event.preventDefault();
            alert(" يجب أن توافق على الشروط ");
            return false;
        }
    }
</script>
<script>
    $(".show-more").click(function() {
        if ($(".text").hasClass("show-more-height")) {
            $(this).text("(Show Less)");
        } else {
            $(this).text("(Show More)");
        }

        $(".text").toggleClass("show-more-height");
    });
</script>
<script src="<?php echo base_url(); ?>js/jquery-2.1.1.js"></script>