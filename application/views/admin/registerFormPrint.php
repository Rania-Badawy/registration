<style>
    .school_name,
    .imgCode {
        display: none;
    }

    img {
        width: 100px;
        height: 100px
    }


    th {
        text-align: right;
    }

    .open-button {
        display: none;
    }

    @media print {}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.js">
</script>

<script type="text/javascript">
    function PrintElem(elem) {
        Popup($(elem).html());
        this.align = "center";


    }

    function Popup(data) {

        var mywindow = window.open('', 'print_div', 'height=1200,width=1400');
        <?php if ($this->session->userdata('language') != 'english') { ?>
            mywindow.document.write(
                '<html dir="rtl" ><head><title></title><style>.form-group{text-align: start;}.printDivO label{text-align: start;} </style>'
            );
            mywindow.document.write('<link href="<?php echo base_url(); ?>assets/new/css/rtl.css" rel="stylesheet">');
        <?php } else { ?>
            mywindow.document.write(
                '<html dir="ltr"><head><title></title><style>.form-group{text-align: end;}.printDivO label{text-align: end;}</style>'
            );
            mywindow.document.write('<link href="<?php echo base_url(); ?>assets/new/css/ltr.css" rel="stylesheet">');
        <?php } ?>
        mywindow.document.write('<link href="<?php echo base_url(); ?>assets/new/css/style.css" rel="stylesheet">');
        mywindow.document.write('<link href="<?php echo base_url(); ?>exam/exam.css" rel="stylesheet">');
        mywindow.document.write('<link href="<?php echo base_url(); ?>assets/new/css/bootstrap.min.css" rel="stylesheet">');
        mywindow.document.write(`<style>
		body{
		    font-size: large;
		}
        .formTitle{
            background: #f9f9f9 !important;;
            width: 40%;
            margin: 20px auto;
            padding: 15px;
            color: #000;
            font-weight: bold;
            font-size: 30px;
            border-radius: 11px;
        }
		.divPrint{
		    min-height: 34px;
            width: 100%;
            font-size: 1.6rem;
            border: 1px solid #f9f9f9;
            background-color: #f9f9f9 !important;
            border-radius: 5px;
		}
         .printDivO{
             width: 33.333333% !important;
             margin-bottom: 10px !important;
             <?php if ($this->session->userdata('language') != 'english') { ?>
             float : right ;
             <?php } else { ?>
             float : left ;
             <?php } ?>
         }
         .col-md-4{
             width: 33.333%;
         }
         .printDivO label{
		    font-size: 14px;
		}
		h4.divHeader{
            border-bottom: 2px solid #ddd;
            padding: 2px 10px;
            width: fit-content;
            font-size: 25px;
            font-weight: bold;
            color: #000;
		}
		.printDivO.certificate{
		    margin-bottom: 350px !important
		}
		.mediacl_datah4{
		    margin-top: 500px !important
		}
		.printDivO hr{
		    margin: 0 !important
		}
        .row{
            display: flex;
            align-items: center;
            flex-wrap: wrap
        }
		@page {
          margin: 0 0 0 0 !important;
        }
    
    
    .imgLink{
        display: none;
    }
    .fatherData{
        min-height:1020px !important;
    }
    .motherData{
        min-height:1130px !important;
    }
    .publicData{
        min-height:1120px !important;
        width: 100%
    }
    .studentData{
        min-height:1130px !important;
    }
    .busAbroP{
        min-height: 1130px !important;
        width: 100%
    }
    .nafsyaaDiv{
        min-height: 1120px !important;
    }
    img{
        width: 100px;
        height: 100px
    }
    .school_name{
        display: none;
    }
    .content h1 {
    text-transform: revert;}
    }
    .row{
        display: flex;
        align-items: center;
        flex-wrap: wrap
    }
    .schoolLogo{position: absolute;left: 0}
    </style>`);


        mywindow.document.write(
            '</head><body class="content" ><h4 class="school_name"><?= $query_SCHOOL['SchoolNameEn'] ?></h4>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.document.close();
        setTimeout(function() {
            mywindow.print();
        }, 2000)

        return true;
    }
</script>
<style>
    h4.divHeader {
        border-bottom: 2px solid #ddd;
        padding: 2px 10px;
        width: fit-content;
        font-size: 25px;
        font-weight: bold;
        color: #000;
    }

    .formTitle {
        background: #f9f9f9 !important;
        width: 30%;
        margin: 20px auto;
        padding: 15px;
        color: #000;
        font-weight: bold;
        font-size: 30px;
        border-radius: 11px;
    }

    @media print {

        .divPrint,
        .formTitle,
        h4.divHeader {
            background-color: #f9f9f9 !important;
            print-color-adjust: exact !important;
        }
    }
</style>
<?php $query = $this->db->query("select * from setting")->row_array(); ?>
<div class="col-lg-12">
    <div class="block-st">

        <div class="pull-left">
            <input type="button" onclick="PrintElem('#print_div')" value="print" class="btn btn-success" />
        </div>


        <div class="panel-body no-padding">

            <div class="col-xs-12">
                <div class="col-md-12">
                    <div class="row">
                        <?php foreach ($array as $key => $value) { ?>
                            <div class="col-md-6">
                                <div class="clearfix"></div>
                                <h4 style="color: green;"> <?= $value ?></h4>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <?= (isset($reason[$key])) ? ($reason[$key]->Reason ? $reason[$key]->Reason : lang('No notes')) : lang('Not reviewed'); ?>

                                </div>
                            </div>
                        <?php } ?>
                        <div class="row form-group" id="print_div">
                            <?php $setting = $this->db->query("SELECT * FROM `form_setting` WHERE `form_type` =1")->result(); ?>

                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                <img class="schoolLogo" src="<?= base_url() ?>intro/images/school_logo/<?php echo $query['Logo'] ?>" class="mt-20" width="120" />
                                <h3 class="formTitle"><?= lang('am_RegistrationForm') ?></h3>
                            </div>
                            <div class="pagebreak">
                                <div class="col-xs-12">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="fatherData">
                                                <h4 class="divHeader"> <?php echo lang('am_father_data'); ?> </h4>
                                                <div class="row">
                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php echo lang('am_Quadrant_name'); ?> </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                        </div>
                                                    </div>
                                                    <?php if ($setting[1]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label"><?php if ($this->ApiDbname == "SchoolAccAtlas") {
                                                                                                echo lang('am_name_atlas');
                                                                                            } else {
                                                                                                echo lang('name_eng');
                                                                                            } ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php echo lang('am_ID_Number'); ?> </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                        </div>
                                                    </div>
                                                    <?php if ($setting[48]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_number_type'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[49]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_number_identity'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[3]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_mail'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint email">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[97]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('br_BirhtDate'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[4]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_EducationalQualification'); ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[5]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_Nationality'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">


                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php echo lang('am_parent_religion'); ?> </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">


                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php echo lang('na_mobile'); ?> </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                        </div>
                                                    </div>
                                                    <?php if ($setting[7]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php if ($this->ApiDbname == "SchoolAccDigitalCulture") {
                                                                    echo lang('br_discount_code');
                                                                } else {
                                                                    echo lang('na_mobile_2');
                                                                } ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[8]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_phone_home'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[9]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_Work_Phone'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[56]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_emergency_number'); ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[10]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_The_job'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[4]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('br_work_Address'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                </div>
                                                <div class="row">
                                                    <?php if ($setting[52]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('Fathers_birth_certificate'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint" style="min-height: 80px">

                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if ($setting[50]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('Fathers_certificate_picture'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint" style="min-height: 80px">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[51]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('Fathers_ID_photo'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint" style="min-height: 80px">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[66]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('Fathers_ID_photo2'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint" style="min-height: 80px">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <div class="motherData">
                                                <h4 class="divHeader"> <?php echo lang('am_mother_data'); ?> </h4>
                                                <div class="row">
                                                    <?php if ($setting[12]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label"> <?= lang('am_name') ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[68]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label"> <?= lang('am_name_eng') ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[47]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label"> <?= lang('am_ID_Number') ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if ($setting[13]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_mother_educationa'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php echo lang('am_mother_religion'); ?> </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                        </div>
                                                    </div>

                                                    <?php if ($setting[14]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_The_job'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                        <!--<div class="row"></div>-->
                                                    <?php } ?>

                                                    <?php if ($setting[15]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_mother_work'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[16]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_mother_mobile'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if ($setting[17]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_mother_work_phone'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if ($setting[18]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_mother_email'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="row">

                                                    <?php if ($setting[53]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('mother_certificate_picture'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint" style="min-height: 80px">

                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if ($setting[54]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('mother_ID_photo'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint" style="min-height: 80px">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[67]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('mother_ID_photo2'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint" style="min-height: 80px">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[55]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('mother_birth_certificate'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint" style="min-height: 80px">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="clearfix"></div>
                                                    <div style="width: 97%;margin: auto">
                                                        <h4 class="divHeader"> <?php echo lang('am_general_data'); ?> </h4>
                                                        <div class="row">
                                                            <?php if ($setting[19]->display == 1) { ?>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label">
                                                                        <?php echo lang('br_how_school_name'); ?> </label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                    </div>
                                                                </div>

                                                            <?php } ?>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="communication">
                                                            <h4 class="divHeader"> <?php echo lang('Communication'); ?>
                                                            </h4>
                                                            <div class="row">
                                                                <?php if ($setting[44]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="control-label">
                                                                            <?php echo lang('Academic_Issues'); ?> </label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>

                                                                <?php } ?>
                                                                <?php if ($setting[45]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="control-label">
                                                                            <?php echo lang('Admin_Issues'); ?> </label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if ($setting[46]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="control-label">
                                                                            <?php echo lang('Finance_Issues'); ?> </label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>

                                                        <div class="clearfix"></div>
                                                        <?php if ($this->ApiDbname == "SchoolAccAtlas") { ?>
                                                            <h4 class="divHeader"><?php echo lang('am_res_studentExit'); ?>
                                                            </h4>
                                                        <?php } elseif ($this->ApiDbname == "SchoolAccElinjaz") { ?>
                                                            <h4 class="divHeader"><?php echo lang('am_res_emergency'); ?> </h4>
                                                        <?php } else { ?>
                                                            <h4 class="divHeader">
                                                                <?php echo lang('Another responsible for the student (other than the father)'); ?>
                                                            </h4>
                                                        <?php } ?>
                                                        <div class="row">
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_Name_manager'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_number_id_manager'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_number_manager'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                </div>
                                                            </div>
                                                            <?php if ($setting[70]->display == 1) { ?>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label">
                                                                        <?php echo lang('Responsible_character'); ?> </label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if ($setting[71]->display == 1) { ?>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label"> <?php echo lang('kg_picture'); ?>
                                                                    </label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO hidden">
                                                                <label class="control-label">
                                                                    <?php echo lang('account_number'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <?php if ($getStudentR['school_staff'] == '1') { ?>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label">
                                                                        <br />
                                                                    </label>
                                                                    <label class="">
                                                                        <?php echo lang('am_School_personnel'); ?>
                                                                    </label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="studentData">
                                                <h4 class="school_name"><?= $query_SCHOOL['SchoolNameEn'] ?></h4>
                                                <div class="clearfix"></div>
                                                <h4 class="divHeader"> <?php echo lang('am_student_data'); ?> </h4>
                                                <div class="row">
                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php if ($this->ApiDbname == "SchoolAccElinjaz") {
                                                                echo lang('student_name');
                                                            } else {
                                                                echo lang('am_frist_name');
                                                            } ?>
                                                        </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                        </div>
                                                    </div>

                                                    <?php if ($setting[21]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php if ($this->ApiDbname == "SchoolAccAtlas") {
                                                                    echo lang('am_firstName_atlas');
                                                                } else {
                                                                    echo lang('am_frist_name_eng');
                                                                } ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php if ($this->ApiDbname == "SchoolAccElinjaz") {
                                                                echo lang('br_st_numberid');
                                                            } else {
                                                                echo lang('am_ID_Number');
                                                            } ?>
                                                        </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                        </div>
                                                    </div>
                                                    <?php if ($setting[23]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('br_Address'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php echo lang('er_Gender'); ?> </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php echo lang('class_type'); ?> </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                        </div>
                                                    </div>
                                                    <?php if ($setting[26]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('br_BirhtDate'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if ($setting[27]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_place_birth'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php echo lang('am_studeType'); ?> </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php echo lang('school_Name'); ?> </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                        </div>
                                                    </div>

                                                    <?php foreach ($getRowLevel as $p) {
                                                        if ($p->RowLevelId == $getStudentR['rowLevelID']) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_level'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                </div>
                                                            </div>

                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label"> <?php echo lang('am_row'); ?>
                                                                </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                </div>
                                                            </div>
                                                            <?php if ($setting[96]->display == 1 && $getStudentR['status']) { ?>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label">
                                                                        <?php echo lang('status'); ?></label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label"><?= lang('br_year') ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label"><?= lang('Semester') ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                </div>
                                                            </div>

                                                            <?php if ($setting[33]->display == 1) { ?>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label">
                                                                        <?php echo lang('am_student_religion'); ?></label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                    </div>
                                                                </div>
                                                            <?php } ?>



                                                            <?php if ($setting[34]->display == 1) { ?>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label">
                                                                        <?php echo lang('second_lang'); ?> </label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                    </div>
                                                                </div>
                                                            <?php } ?>


                                                    <?php }
                                                    } ?>

                                                    <?php if ($setting[36]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_last_school'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if ($setting[37]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('na_school_type'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">


                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[64]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('Financial_clearance'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <!--<div class="clearfix"></div>-->
                                                    <?php if ($setting[35]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label"><?php echo lang('am_last_Degree'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>


                                                    <?php } ?>
                                                    <?php if ($setting[38]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('birth_certificate'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[61]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('vaccination_certificate'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[62]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('family_card1'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                    <?php } ?>


                                                    <?php if ($setting[63]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('family_card2'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>

                                                    <?php } ?>

                                                    <div class="clearfix"></div>
                                                    <div style="width: 97%;margin: auto">
                                                        <div class="bus">
                                                            <h4 class="divHeader"><?= lang('bus_serv') ?></h4>
                                                            <div class="row">
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO ">
                                                                    <label class="control-label">
                                                                        <?php echo lang('am_want_transport'); ?> </label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label">
                                                                        <?php echo lang('am_transport_address'); ?></label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                    </div>
                                                                </div>
                                                                <?php
                                                                $allowphoto = array(0 => lang('no'), 1 => lang('yes'));
                                                                ?>
                                                                <?php if ($setting[60]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="control-label">
                                                                            <?php echo lang('allow_photography'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                        <div class="bro">
                                                            <?php if ($setting[39]->display == 1) { ?>

                                                                <div class="<?php if ($query) {
                                                                                echo 'pagebreak';
                                                                            } ?>">
                                                                    <?php if ($query) { ?>
                                                                        <h4 class="school_name"><?= $query_SCHOOL['SchoolNameEn'] ?>
                                                                        </h4>
                                                                    <?php } ?>

                                                                    <div class="clearfix"></div>
                                                                    <h4 class="divHeader"><?php echo lang('bro_data'); ?> </h4>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label">
                                                                                <?php echo lang('na_bro_name'); ?> </label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label">
                                                                                <?php echo lang('am_level'); ?> </label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label">
                                                                                <?php echo lang('school_Name'); ?> </label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                        <input hidden <?= $sch_type = $School_Type; ?> />
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label">
                                                                                <?php echo lang('na_school_type'); ?> </label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            <?php } ?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div style="width: 97%;margin: auto">
                                                <?php if ($setting[43]->display == 1) { ?>
                                                    <div class="row">
                                                        <div class="nafsyaaDiv">

                                                            <h4 class="school_name"><?= $query_SCHOOL['SchoolNameEn'] ?>
                                                            </h4>

                                                            <h4 class="divHeader nafsyaa">
                                                                <?php echo lang('am_student_psyy'); ?> </h4>
                                                            <div class="row">
                                                                <?php if ($setting[72]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class=""><?php echo lang('am_student_brothers'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[73]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class=""><?php echo lang('am_student_order'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[74]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_student_live_with'); ?>
                                                                            :</label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[75]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class=""><?php echo lang('am_social'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[76]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_grand_parents'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[77]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_student_skills'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[78]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_student_games'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[79]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_student_sport'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[80]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_student_place'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[81]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_student_relation'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[82]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_student_descripe'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[83]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_student_behavior'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[84]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_student_get_rid'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[85]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_student_pressure'); ?>
                                                                        </label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[86]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_student_person'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[87]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_student_punish'); ?>
                                                                        </label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[88]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="">
                                                                            <?php echo lang('am_student_specialist'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                <?php }
                                                                if ($setting[89]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class=""><?php echo lang('am_student_academy'); ?>:</label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                        </div>
                                                                    </div>
                                                                    <?php if ($setting[99]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_child_favorite_color'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[100]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_child_favorite_game'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[101]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_child_favorite_type_toy'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[102]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_child_favorite_animal'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[103]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_child_favorite_nickname'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[104]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_child_favorite_food'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[105]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_things_scare_child'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[106]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_additional_information'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[107]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_enter_bathroom'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[108]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_method_enter_bathroom'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[109]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_time_electronic_devices'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[110]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_child_hobbies'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[111]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_activities_programs'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[112]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_child_routine'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[113]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_memorize_Quran'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if ($setting[114]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="">
                                                                                <?php echo lang('er_parenting_strategies'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                            </div>
                                                        </div>
                                                        <h4 class="divHeader"><?php echo lang('am_student_psyyy'); ?>
                                                        </h4>
                                                        <div class="row">
                                                        <?php }
                                                                if ($setting[90]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="">
                                                                    <?php echo lang('am_student_diseases'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                </div>
                                                            </div>
                                                        <?php }
                                                                if ($setting[91]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="">
                                                                    <?php echo lang('am_student_treatment'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                </div>
                                                            </div>
                                                        <?php }
                                                                if ($setting[92]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="">
                                                                    <?php echo lang('am_student_history'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        <?php }
                                                                if ($setting[93]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="">
                                                                    <?php echo lang('am_student_allergy'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                </div>
                                                            </div>
                                                        <?php }
                                                                if ($setting[94]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="">
                                                                    <?php echo lang('am_student_health'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                </div>
                                                            </div>
                                                        <?php }
                                                                if ($setting[95]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="">
                                                                    <?php if ($this->ApiDbname == "SchoolAccTilalAlzahran") { ?>
                                                                        <?php echo lang('Does_suffer_notmentioned'); ?>
                                                                    <?php } else { ?>
                                                                        <?php echo lang('Does_student_suffer_notmentioned'); ?>
                                                                    <?php } ?>
                                                                </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="">
                                                                <?php echo lang('am_Signature'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">

                                                            </div>
                                                        </div>
                                                        </div>

                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>