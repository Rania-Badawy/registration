<?php
$get_api_setting = $this->setting_model->get_api_setting();

$this->ApiDbname = $get_api_setting[0]->{'ApiDbname'};
?>

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
		.divPrint{
		    min-height: 34px;
            width: 100%;
            font-size: 1.6rem;
            border: 1px solid #000;
            background-color: white;
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
		    margin-bottom: 5px !important;
		    border-bottom: 1px solid #eaeaea !important;
		    padding-bottom: 0 !important
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
        min-height:1120px !important;
    }
    .motherData{
        min-height:1120px !important;
    }
    .publicData{
        min-height:1130px !important;
    }
    .studentData{
        min-height:1150px !important;
    }
    .busAbroP{
        min-height: 1120px !important
    }
    .nafsyaaDiv{
        min-height: 1130px !important;
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
    </style>`);


        mywindow.document.write(
            '</head><body class="content" ><h4 class="school_name"><?= $getStudentR['schoolName'] ?></h4>');
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
        margin-bottom: 0 !important;
        border-bottom: 1px solid #000 !important;
        padding-bottom: 5px !important
    }
</style>
<?php $per = check_group_permission_page(); ?>
<?php $reg = $this->db->query("select reg_type from school_details ")->row_array();
$reg_type = $reg['reg_type'];
$check_student     = json_decode(file_get_contents( lang("api_link")."/api/Students/" . $this->ApiDbname . "/GetStudentStatus?studentIdNumber=" . $getStudentR['student_NumberID'] . ""));
?>

<div class="col-lg-12">
    <div class="block-st">
        <div class="sec-title">
            <h4><?php echo lang('br_check_st_register'); ?></h4>
            <a href="<?php echo site_url('admin/Report_Register/index/' . $school_id . "/" . $year_id); ?>" class="btn btn-danger pull-left" role="button"> <?php echo lang('Back'); ?> </a>
            <div class="pull-left">
                <input type="button" onclick="PrintElem('#print_div')" value="print" class="btn btn-success" />
            </div>
        </div>
        <?php
        if ($this->session->flashdata('SuccessAdd')) {
        ?>
            <div class="widget-content">
                <div class="widget-box">
                    <div class="alert alert-success fade in">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <?php
                        echo $this->session->flashdata('SuccessAdd');
                        ?>
                    </div>
                </div>
            </div>
        <?php
        }

        if ($this->session->flashdata('Failuer')) {
        ?>
            <div class="widget-content">
                <div class="widget-box">
                    <div class="alert alert-danger fade in">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <?php
                        echo $this->session->flashdata('Failuer');
                        ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="panel-body no-padding">
            <?php
            if ($getStudentR['IsAccepted'] == 0) {
                $query1 = $this->db->query("SELECT jobTitleID FROM employee	WHERE Contact_ID = '" . $this->session->userdata('id') . "' ")->row_array();
                if ($getPerEmp == 'U' || ($this->session->userdata('type') == 'E' && $query1['jobTitleID'] != 0 && ($get_permission_request['NameSpaceID'] != 87 && $get_permission_request['NameSpaceID'] != 85))) { ?>
                    <?php
                    if ($check_student->StBasicId == "") { ?>
                        <?php if ($isNextYear == 1 && $per['PermissionEdit'] == 1) { ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                <?= lang('am_accept') ?>/<?= lang('am_refuse') ?></button>
                        <?php } ?>

                        <?php } else { ?><?php if ($check_student->StatusName == "مستجد") {
                                                $ch = lang("am_or_wait");
                                            } ?><div style="color: red;font-size: x-large;">
                            <?php echo lang("am_registe_erp") . " " . lang('br_year') . " :" . $check_student->YearName . "   " . lang("status") . "  " . $check_student->StatusName . $ch . "   " . lang("school") . "  " . $check_student->SchoolName; ?>
                        </div> <?php  } ?>
                    <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title"> <?= lang('am_accept') ?>/<?= lang('am_refuse') ?></h4>
                                </div>
                                <!-- Modal body -->

                                <div class="modal-body row">
                                    <?php if ($reg_type == 2) { ?>
                                        <form action="<?= site_url('admin/Report_Register/accept_student_register_marketing/' . $getStudentR['reg_id'] . '/0'); ?>" method="post">
                                        <?php } else { ?>
                                            <form action="<?= site_url('admin/Report_Register/accept_student_register/' . $getStudentR['reg_id'] . '/0'); ?>" method="post">
                                            <?php } ?>
                                            
                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <textarea class="form-control" name="Reason" rows="7"></textarea>
                                            </div>
                                            <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                                <label class="col-md-12 col-sm-12 col-xs-12"> <br /> </label>
                                                <input type="hidden" name="parent_mobile" value="<?= $getStudentR['person_mobile']; ?>" />
                                                <input type="hidden" name="IsActive" id="IsActive">
                                                <button type="submit" onclick="$('#IsActive').val(2);return confirm('Are you sure to refuse?')" class="btn btn-danger"><?= lang('am_refuse') ?></button>
                                                <button type="submit" onclick="$('#IsActive').val(1);return confirm('Are you sure to accept?')" class="btn btn-success"><?= lang('am_accept') ?></button>
                                            </div>
                                            <br /><br />
                                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php

                } elseif ($get_permission_request['NameSpaceID'] == 87) {
                    //var_dump($getPerEmp, $get_permission_request);
                    if ($getPerEmp['IsActive'] == 1) {
                        echo '<div class="alert alert-success">' . lang('am_accepted') . ' - ' . $getPerEmp['name_space'] . '</div>';
                    } else {
                        if ($getPerEmp['IsActive'] == 0 || $getPerEmp['IsActive'] == 2) {
                    ?>
                            <?php
                            if ($check_student->StBasicId == "") { ?>
                                <?php if ($isNextYear == 1 && $per['PermissionEdit'] == 1) { ?>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                        <?= lang('am_accept') ?>/<?= lang('am_refuse') ?></button>
                                <?php } ?>
                            <?php } else {
                                $ch = lang("am_or_wait"); ?><div style="color: red;font-size: x-large;">
                                    <?php echo lang("am_registe_erp") . " " . lang('br_year') . " :" . $check_student->YearName . "   " . lang("status") . "  " . $check_student->StatusName . $ch . "   " . lang("school") . "  " . $check_student->SchoolName; ?>
                                </div> <?php  } ?>

                            <div class="modal" id="myModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title"> <?= lang('am_accept') ?>/<?= lang('am_refuse') ?> </h4>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body row">
                                            <?php if ($reg_type == 2) { ?>
                                                <form action="<?= site_url('admin/Report_Register/accept_student_register_marketing/' . $getPerEmp['RequestID'] . '/' . $getPerEmp['NameSpaceID']); ?>" method="post">
                                                <?php } else { ?>
                                                    <form action="<?= site_url('admin/Report_Register/accept_student_register/' . $getPerEmp['RequestID'] . '/' . $getPerEmp['NameSpaceID']); ?>" method="post">
                                                    <?php } ?>
                                                   
                                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                        <textarea class="form-control" name="Reason" rows="7"></textarea>
                                                    </div>
                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                                        <label class="col-md-12 col-sm-12 col-xs-12"> <br /> </label>
                                                        <input type="hidden" name="parent_mobile" value="<?= $getStudentR['person_mobile']; ?>" />
                                                        <input type="hidden" name="IsActive" id="IsActive">
                                                        <button type="submit" onclick="$('#IsActive').val(2);return confirm('Are you sure to refuse?')" class="btn btn-danger"><?= lang('am_refuse') . ' - ' . $getPerEmp['name_space'] ?></button>
                                                        <button type="submit" onclick="$('#IsActive').val(1);return confirm('Are you sure to accept?')" class="btn btn-success"><?= lang('am_accept') . ' - ' . $getPerEmp['name_space'] ?></button>
                                                    </div>
                                                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php }

                        
                        ?>
                    <?php
                      
                    }
                } elseif ($get_permission_request['NameSpaceID'] == 85 && $getStudentR['IsRefused'] == 0) {
                    ?>

                    <?php

                    if ($all_accept_request == 1) {
                        echo '<div class="alert alert-danger">' . 'لم يتم المراجعه من الشئون الأكاديمية' . '</div>';
                    } elseif ($all_accept_request2 == 1) {
                        echo '<div class="alert alert-danger">' . 'تم الرفض من الشئون الأكاديمية' . '</div>';
                    } else {
                        if ($getPerEmp['IsActive'] == 1) {
                            echo '<div class="alert alert-success">' . lang('am_accepted') . ' - ' . $getPerEmp['name_space'] . '</div>';
                        } else {
                            if ($getPerEmp['IsActive'] == 0) {
                    ?>


                            
                                <div class="row form-group">
                                    <?php if ($isNextYear == 1 && $per['PermissionEdit'] == 1) { ?>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> قبول /
                                            رفض</button>
                                    <?php } ?>
                                    <div class="modal" id="myModal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title"> <?= lang('am_accept') ?>/<?= lang('am_refuse') ?></h4>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body row">
                                                    <?php if ($reg_type == 2) { ?>
                                                        <form action="<?= site_url('admin/Report_Register/accept_student_register_marketing/' . $getPerEmp['RequestID'] . '/' . $getPerEmp['NameSpaceID']); ?>" method="post">
                                                        <?php } else { ?>
                                                            <form action="<?= site_url('admin/Report_Register/accept_student_register/' . $getPerEmp['RequestID'] . '/' . $getPerEmp['NameSpaceID']); ?>" method="post">
                                                            <?php } ?>

                                                          
                                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                                <textarea class="form-control" name="Reason" rows="7"></textarea>
                                                            </div>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                                                <!--label class="col-md-12 col-sm-12 col-xs-12"> <br /> </label-->
                                                                <input type="hidden" name="parent_mobile" value="<?= $getStudentR['person_mobile']; ?>" />
                                                                <input type="hidden" name="IsActive" id="IsActive">
                                                                <button type="submit" onclick="$('#IsActive').val(2);return confirm('Are you sure to refuse?')" class="btn btn-danger"><?= lang('am_refuse') . ' - ' . $getPerEmp['name_space'] ?></button>
                                                                <button type="submit" onclick="$('#IsActive').val(1);return confirm('Are you sure to accept?')" class="btn btn-success"><?= lang('am_accept') . ' - ' . $getPerEmp['name_space'] ?></button>
                                                            </div>
                                                            <br /><br />
                                                            </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }

                            if ($getPerEmp['IsActive'] == 2) {
                            ?>
                                <div class="alert alert-danger"><?= lang('am_refuse') . ' - ' . $getPerEmp['name_space']; ?></div>
                <?php
                            }
                        }
                    }
                } ?>
            <?php
            } elseif ($getStudentR['IsRefused'] == 1) { ?>
                <div class="alert alert-danger"><?= lang('am_refuse'); ?></div>
            <?php } else {
            ?>
                <div class="alert alert-success"><?= lang('am_accepted') . ' - ' . $getPerEmp['name_space']; ?></div>
            <?php
            } ?>

            <div class="row form-group">

                <?php
                $query = $this->db->query("select accpet_reg_type,reg_type	 from school_details limit 1")->row_array();
                if ($query['accpet_reg_type'] == 1 || $query['accpet_reg_type'] == 2 || $query['reg_type'] == 2) {

                    $array = array(
                        87 =>   lang('Academic Affairs Note'),
                        85 =>  lang('Note the financial affairs')
                    );
                } else {
                    $array = array(
                        87 =>   lang('Academic Affairs Note')
                    );
                }
                ?>
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

                                <!--<div id="print_div">-->
                                <div class="pagebreak">
                                    <div class="col-xs-12">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="mainData">
                                                    <h4 class="divHeader"> <?php echo lang('am_basic_data'); ?> </h4>
                                                    <div class="row">
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php
                                                                    echo lang('am_frist_name');
                                                                 ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?= $getStudentR['name']; ?>
                                                            </div>
                                                        </div>

                                                        <?php if ($setting[1]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php if ($this->ApiDbname == "SchoolAccAtlas") {
                                                                        echo lang('am_firstName_atlas');
                                                                    } else {
                                                                        echo lang('am_frist_name_eng');
                                                                    } ?>
                                                                </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['name_eng']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php 
                                                                    echo lang('br_student_NumberID');
                                                                ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?= $getStudentR['student_NumberID']; ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('father_name'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?= $getStudentR['parentname']; ?>
                                                            </div>
                                                        </div>
                                                        <?php if ($setting[1]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label"><?php if ($this->ApiDbname == "SchoolAccAtlas") {
                                                                                                    echo lang('am_name_atlas');
                                                                                                } else {
                                                                                                    echo lang('am_father_name_en');
                                                                                                } ?>
                                                                </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['parentnameeng']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('br_father_NumberID'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?= $getStudentR['ParentNumber']; ?>
                                                            </div>
                                                        </div>
                                                        <?php if ($setting[3]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_mail'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint email">
                                                                    <?= $getStudentR['parentemail']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[5]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_Nationality'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php foreach ($get_nationality as $n) {
                                                                        if ($n->NationalityId == $getStudentR['nationality']) {
                                                                            echo $n->NationalityName;
                                                                        }
                                                                    } ?>

                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('father_mobile'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?= $getStudentR['parentmobile']; ?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="fatherData">
                                                    <h4 class="divHeader"> <?php echo lang('am_father_data'); ?> </h4>
                                                    <div class="row">

                                                        <?php if ($setting[48]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_number_type'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['parent_type_Identity']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[49]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_number_identity'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['parent_source_identity']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                        <?php if ($setting[97]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('br_BirhtDate'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['father_brith_date']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[4]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_EducationalQualification'); ?>
                                                                </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['parent_educational_qualification']; ?>
                                                                    <?php
                                                                    //  foreach($get_educations as $e) {
                                                                    //                                 if($e->Value ==$getStudentR['parenteducationalqualification']) {
                                                                    //                                     echo $e->Text;
                                                                    //                                 }
                                                                    //                             } 
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[58]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_parent_religion'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?php foreach ($religion as $n) {

                                                                    if ($n->Value == $getStudentR['par_religion']) {

                                                                        echo $n->Value;
                                                                    }
                                                                } ?>

                                                            </div>
                                                        </div>
                                                        <?php } ?>
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
                                                                    <?= $getStudentR['parentmobile2']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[8]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_phone_home'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['parentphone']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[9]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_Work_Phone'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['parentphone2']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[56]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_emergency_number'); ?>
                                                                </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['emergency_number']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[10]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_The_job'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['parentprofession']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[11]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('br_work_Address'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['parent_work_address']?$getStudentR['parent_work_address']:$getStudentR['parentregion']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                    <div class="row">
                                                        <?php if ($setting[52]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('Fathers_birth_certificate'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['father_brith_certificate']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['father_brith_certificate']) ?>" target="_blank" style="color:#03a9f4"><?= lang("CLICK_TO_WATCH") ?>
                                                                        </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['father_brith_certificate']) ?>" alt="" />

                                                                    <?php } else {
                                                                        echo " ";
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                        <?php if ($setting[50]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('Fathers_certificate_picture'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['father_certificate']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['father_certificate']) ?>" target="_blank" style="color:#03a9f4"><?= lang("CLICK_TO_WATCH") ?>
                                                                        </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['father_certificate']) ?>" alt="" />

                                                                    <?php } else {
                                                                        echo " ";
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[51]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('Fathers_ID_photo'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['father_national_id']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['father_national_id']) ?>" target="_blank" style="color:#03a9f4"><?= lang("CLICK_TO_WATCH") ?>
                                                                        </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['father_national_id']) ?>" alt="" />

                                                                    <?php } else {
                                                                        echo " ";
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="row">
                                                        <?php if ($setting[66]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('Fathers_ID_photo2'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['father_national_id2']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['father_national_id2']) ?>" target="_blank" style="color:#03a9f4"><?= lang("CLICK_TO_WATCH") ?>
                                                                        </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['father_national_id2']) ?>" alt="" />

                                                                    <?php } else {
                                                                        echo " ";
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <!--<div class="form-group col-md-4 col-sm-12 col-xs-12">-->
                                                    <!--	<label class="control-label col-md-12 col-sm-12 col-xs-12"> <?php echo lang('am_am_Workplace'); ?>  </label>-->
                                                    <!--	<div class="col-md-12 col-sm-12 col-xs-12 divPrint">		-->
                                                    <!--		<?= $getStudentR['parentworkaddress']; ?>-->
                                                    <!--	</div>						-->
                                                    <!--</div>		-->
                                                </div>
                                                <div class="motherData">
                                                    <h4 class="divHeader"> <?php echo lang('am_mother_data'); ?> </h4>
                                                    <div class="row">
                                                        <?php if ($setting[12]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label"> <?= lang('am_name') ?>
                                                                </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['mothername']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[68]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label"> <?= lang('am_name_eng') ?>
                                                                </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['mother_name_eng']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[47]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label"> <?= lang('am_ID_Number') ?>
                                                                </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['motherNumberID']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                        <?php if ($setting[13]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_mother_educationa'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['mother_educational_qualification']; ?>
                                                                    <?php
                                                                    // 	 foreach($get_educations as $ed) {
                                                                    //                                 if($ed->Value ==$getStudentR['mothereducationalqualification']) {
                                                                    //                                     echo $ed->Text;
                                                                    //                                 }
                                                                    //                             } 
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[57]->display ==  1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_mother_religion'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?php foreach ($religion as $n) {

                                                                    if ($n->Value == $getStudentR['par_religion']) {

                                                                        echo $n->Value;
                                                                    }
                                                                } ?>

                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <?php if ($setting[14]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_The_job'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['parentprofessionmather']; ?>
                                                                </div>
                                                            </div>
                                                            <!--<div class="row"></div>-->
                                                        <?php } ?>

                                                        <?php if ($setting[15]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_mother_work'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['motherwork']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[16]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_mother_mobile'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['mothermobile']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                        <?php if ($setting[17]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_mother_work_phone'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['motherworkphone']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                        <?php if ($setting[18]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_mother_email'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['motheremail']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[53]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('mother_certificate_picture'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['mother_certificate']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['mother_certificate']) ?>" target="_blank" style="color:#03a9f4"><?= lang("CLICK_TO_WATCH") ?>
                                                                        </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['mother_certificate']) ?>" alt="" />

                                                                    <?php } else {
                                                                        echo " ";
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                        <?php if ($setting[54]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('mother_ID_photo'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['mother_national_id']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['mother_national_id']) ?>" target="_blank" style="color:#03a9f4"><?= lang("CLICK_TO_WATCH") ?>
                                                                        </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['mother_national_id']) ?>" alt="" />

                                                                    <?php } else {
                                                                        echo " ";
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[67]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('mother_ID_photo2'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['mother_national_id2']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['mother_national_id2']) ?>" target="_blank" style="color:#03a9f4"><?= lang("CLICK_TO_WATCH") ?>
                                                                        </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['mother_national_id2']) ?>" alt="" />

                                                                    <?php } else {
                                                                        echo " ";
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[55]->display ==  1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('mother_birth_certificate'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['mother_brith_certificate']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['mother_brith_certificate']) ?>" target="_blank" style="color:#03a9f4"><?= lang("CLICK_TO_WATCH") ?>
                                                                        </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['mother_brith_certificate']) ?>" alt="" />

                                                                    <?php } else {
                                                                        echo " ";
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="publicData">
                                                    <h4 class="divHeader"> <?php echo lang('am_general_data'); ?> </h4>
                                                    <?php
                                                    $want_transport = array(1 => lang('no'), 2 => lang('yes'));
                                                    $transport_type = array(1 => 'Round-trip ', 2 => 'go', 3 => 'return');
                                                    ?>
                                                    <?php if ($setting[19]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('br_how_school_name'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?= $getStudentR['how_school_name']; ?>
                                                            </div>
                                                        </div>

                                                    <?php } ?>
                                                    <div class="clearfix"></div>
                                                    <div class="communication">
                                                        <h4 class="divHeader"> <?php echo lang('Communication'); ?>
                                                        </h4>
                                                        <?php if ($setting[44]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('Academic_Issues'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['Academic_Issues'] == 1) {
                                                                        echo lang('father only');
                                                                    } elseif ($getStudentR['Academic_Issues'] == 2) {
                                                                        echo lang('only mother');
                                                                    } elseif ($getStudentR['Academic_Issues'] == 3) {
                                                                        echo lang('both');
                                                                    } elseif ($getStudentR['Academic_Issues'] == 4) {
                                                                        echo lang('other');
                                                                    } else {
                                                                    } ?>
                                                                </div>
                                                            </div>

                                                        <?php } ?>
                                                        <?php if ($setting[45]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('Admin_Issues'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['Admin_Issues'] == 1) {
                                                                        echo lang('father only');
                                                                    } elseif ($getStudentR['Admin_Issues'] == 2) {
                                                                        echo lang('only mother');
                                                                    } elseif ($getStudentR['Admin_Issues'] == 3) {
                                                                        echo lang('both');
                                                                    } elseif ($getStudentR['Admin_Issues'] == 4) {
                                                                        echo lang('other');
                                                                    } else {
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[46]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('Finance_Issues'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['Finance_Issues'] == 1) {
                                                                        echo lang('father only');
                                                                    } elseif ($getStudentR['Finance_Issues'] == 2) {
                                                                        echo lang('only mother');
                                                                    } elseif ($getStudentR['Finance_Issues'] == 3) {
                                                                        echo lang('both');
                                                                    } elseif ($getStudentR['Finance_Issues'] == 4) {
                                                                        echo lang('other');
                                                                    } else {
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
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
                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php echo lang('am_Name_manager'); ?></label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                            <?= $getStudentR['person_name']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php echo lang('am_number_id_manager'); ?> </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                            <?= $getStudentR['person_NumberID']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                        <label class="control-label">
                                                            <?php echo lang('am_number_manager'); ?> </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                            <?= $getStudentR['person_mobile']; ?>
                                                        </div>
                                                    </div>
                                                    <?php if ($setting[70]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('Responsible_character'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?= $getStudentR['person_relative']; ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($setting[71]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label"> <?php echo lang('kg_picture'); ?>
                                                            </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?php if ($getStudentR['kg_picture']) { ?>
                                                                    <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['kg_picture']) ?>" target="_blank" style="color:#03a9f4">
                                                                        <?= lang("CLICK_TO_WATCH") ?> </a>
                                                                    <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['kg_picture']) ?>" alt="" />
                                                                <?php } ?>
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
                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                <?php echo lang('am_School_personnel'); ?>
                                                            </label>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO hidden">
                                                        <label class="control-label"> اسم الموظف </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <input type="text" id="" name="" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO hidden">
                                                        <label class="control-label"> عدد دفعات السداد </label>
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <input type="text" id="" name="" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>
                                                <input hidden <?= $lang = $getStudentR['sec_language']; ?>>
                                                <input hidden <?= $school_type_stu = $getStudentR['note']; ?>>
                                                <div class="studentData">
                                                    <h4 class="school_name"><?= $getStudentR['schoolName'] ?></h4>
                                                    <div class="clearfix"></div>
                                                    <h4 class="divHeader"> <?php echo lang('am_student_data'); ?> </h4>
                                                    <div class="row">


                                                        <?php if ($setting[23]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('br_Address'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php
                                                                    if ($this->ApiDbname == 'SchoolAccQurtubahJeddah') { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['student_region']) ?>" target="_blank" style="color:#03a9f4"><?= lang("CLICK_TO_WATCH"); ?>
                                                                        </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['student_region']) ?>" alt="" />

                                                                    <?php } else {
                                                                        echo $getStudentR['student_region'];
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('er_Gender'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?php foreach ($get_genders as $gender) {
                                                                    if ($gender->GenderId == $getStudentR['gender']) {
                                                                        echo $gender->GenderName;
                                                                    }
                                                                } ?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('class_type'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?php foreach ($get_ClassTypeName as $TypeName) {
                                                                    if ($TypeName->ClassTypeId == $getStudentR['ClassTypeId']) {
                                                                        echo $TypeName->ClassTypeName;
                                                                    }
                                                                } ?>
                                                            </div>
                                                        </div>
                                                        <?php if ($setting[26]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('br_BirhtDate'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['birthdate'] . "/ " . $getStudentR['birthdate_hij']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                        <?php if ($setting[27]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_place_birth'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['birthplace']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_studeType'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?php foreach ($studeType as $type) {

                                                                    if ($type->StudyTypeId == $getStudentR['studyType']) {
                                                                        echo $type->StudyTypeName;
                                                                    }
                                                                } ?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('school_Name'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                               <?= $getStudentR['schoolName']; ?>

                                                            </div>
                                                        </div>

                                                       
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label">
                                                                        <?php echo lang('am_level'); ?> </label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                       <?= $getStudentR['levelName']; ?>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label"> <?php echo lang('am_row'); ?>
                                                                    </label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                        <?= $getStudentR['rowLevelName']; ?>
                                                                    </div>
                                                                </div>
                                                                <?php if ($setting[96]->display == 1 && $getStudentR['status']) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="control-label">
                                                                            <?php echo lang('status'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                            <?php foreach ($getStatus as $status) {
                                                                                if ($status->StatusId == $getStudentR['status']) {
                                                                                    echo $status->StatusName;
                                                                                }
                                                                            } ?>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                               
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label"><?= lang('br_year') ?> </label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                        <?php foreach ($getYear as $Year) {
                                                                            if ($Year->YearId == $getStudentR['YearId']) {
                                                                                echo $Year->YearName;
                                                                            }
                                                                        } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label"><?= lang('Semester') ?> </label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                        <?php
                                                                        if ($getStudentR['semester'] == "1,2,3") {
                                                                            echo lang('am_fullyear');
                                                                        } elseif ($getStudentR['semester'] == "2,3") {
                                                                            echo lang('ra_First_second_semester');
                                                                        } elseif ($getStudentR['semester'] == "3") {
                                                                            echo lang('Semester') . " " . lang('er_third');
                                                                        } ?>
                                                                    </div>
                                                                </div>

                                                                <?php if ($setting[33]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="control-label">
                                                                            <?php echo lang('am_student_religion'); ?></label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                            <?= $getStudentR['religion']; ?>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>

                                                                <!--<div class="clearfix"></div>-->

                                                                <?php if ($setting[34]->display == 1) { ?>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="control-label">
                                                                            <?php echo lang('second_lang'); ?> </label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                            <?php if ($lang == 1) {
                                                                                echo lang('French language');
                                                                            } elseif ($lang == 2) {
                                                                                echo  lang('German language');
                                                                            } else if ($this->ApiDbname == 'SchoolAcclittlecaterpillars') {
                                                                                if ($lang == 1) {
                                                                                    echo 'اللغة الإنجليزية';
                                                                                } else if ($lang == 2) {
                                                                                    echo 'اللغة الفرنسية';
                                                                                } else if ($lang == 3) {
                                                                                    echo 'اللغة الألمانية';
                                                                                } else if ($lang == 4) {
                                                                                    echo 'اخرى';
                                                                                } else if ($lang == 5) {
                                                                                    echo 'لايوجد';
                                                                                }
                                                                            } else {
                                                                            } ?>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                       

                                                        <!--<div class="clearfix"></div>	-->
                                                        <?php if ($setting[36]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('am_last_school'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['exSchool']; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                        <?php if ($setting[37]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('na_school_type'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($school_type_stu == 1) {
                                                                        echo lang('governmental');
                                                                    } elseif ($school_type_stu == 2) {
                                                                        echo  lang('private');
                                                                    } elseif ($school_type_stu == 3) {
                                                                        echo  lang('international');
                                                                    } else {
                                                                    } ?>

                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[64]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('Financial_clearance'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['Financial_clearance']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['Financial_clearance']) ?>" target="_blank" style="color:#03a9f4">
                                                                            <?= lang("CLICK_TO_WATCH") ?> </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['Financial_clearance']) ?>" alt="" />
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <!--<div class="clearfix"></div>-->
                                                        <?php if ($setting[35]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label"><?php echo lang('am_last_Degree'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['parent_degre_img']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['parent_degre_img']) ?>" target="_blank" style="color:#03a9f4"><?= lang("CLICK_TO_WATCH") ?>
                                                                        </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['parent_degre_img']) ?>" alt="" />

                                                                    <?php } else {
                                                                        echo lang('am_no_teachers');
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>


                                                        <?php } ?>
                                                        <?php if ($setting[38]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('birth_certificate'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['birth_certificate']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['birth_certificate']) ?>" target="_blank" style="color:#03a9f4">
                                                                            <?= lang("CLICK_TO_WATCH") ?> </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['birth_certificate']) ?>" alt="" />
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[61]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('vaccination_certificate'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['vaccination_certificate']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['vaccination_certificate']) ?>" target="_blank" style="color:#03a9f4">
                                                                            <?= lang("CLICK_TO_WATCH") ?> </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['vaccination_certificate']) ?>" alt="" />
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($setting[62]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('family_card1'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['family_card1']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['family_card1']) ?>" target="_blank" style="color:#03a9f4">
                                                                            <?= lang("CLICK_TO_WATCH") ?> </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['family_card1']) ?>" alt="" />
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>


                                                        <?php if ($setting[63]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('family_card2'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?php if ($getStudentR['family_card2']) { ?>
                                                                        <a class="imgLink" href="<?= base_url('upload/' . $getStudentR['family_card2']) ?>" target="_blank" style="color:#03a9f4">
                                                                            <?= lang("CLICK_TO_WATCH") ?> </a>
                                                                        <img class="imgCode" src="<?= base_url('upload/' . $getStudentR['family_card2']) ?>" alt="" />
                                                                    <?php } ?>
                                                                </div>
                                                            </div>

                                                        <?php } ?>

                                                    </div>
                                                </div>
                                                <div class="busAbroP">
                                                    <div class="bus">
                                                        <h4 class="divHeader"><?= lang('bus_serv') ?></h4>
                                                        <?php if ($setting[69]->display == 1) { ?>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO ">
                                                            <label class="control-label">
                                                                <?php echo lang('am_want_transport'); ?> </label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?= $want_transport[$getStudentR['want_transport']]; ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                            <label class="control-label">
                                                                <?php echo lang('am_transport_address'); ?></label>
                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                <?= $getStudentR['transport_address']; ?>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <?php
                                                        $allowphoto = array(0 => lang('no'), 1 => lang('yes'));
                                                        ?>
                                                        <?php if ($setting[60]->display == 1) { ?>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label">
                                                                    <?php echo lang('allow_photography'); ?></label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $allowphoto[$getStudentR['allowphoto']]; ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="bro">
                                                        <?php if ($setting[39]->display == 1) { ?>


                                                            <?php $query = $this->db->query(" select reg_brothers.*,row_level.* from reg_brothers left join row_level on row_level.ID = reg_brothers.Row_Level_Id where reg_id=$id ORDER BY `reg_brothers`.`ID` ASC")->result();  ?>
                                                            <div class="<?php if ($query) {
                                                                            echo 'pagebreak';
                                                                        } ?>">
                                                                <?php if ($query) { ?>
                                                                    <h4 class="school_name"><?= $getStudentR['schoolName'] ?>
                                                                    </h4>
                                                                <?php } ?>
                                                                <?php foreach ($query as $Key => $row) {
                                                                    $Bro_Name        = $row->Bro_Name;
                                                                    $Level_Name        = $row->Level_Name;
                                                                    $Row_Name        = $row->Row_Name;
                                                                    $School_Name    = $row->School_Name;
                                                                    $School_Type    = $row->School_Type;
                                                                ?>
                                                                    <div class="clearfix"></div>
                                                                    <h4 class="divHeader"><?php echo lang('bro_data'); ?> </h4>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="control-label">
                                                                            <?php echo lang('na_bro_name'); ?> </label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                            <?= $Bro_Name ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="control-label">
                                                                            <?php echo lang('am_level'); ?> </label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                            <?= $Row_Name . "-" . $Level_Name; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="control-label">
                                                                            <?php echo lang('school_Name'); ?> </label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                            <?= $School_Name; ?>
                                                                        </div>
                                                                    </div>
                                                                    <input hidden <?= $sch_type = $School_Type; ?> />
                                                                    <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                        <label class="control-label">
                                                                            <?php echo lang('na_school_type'); ?> </label>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                            <?php if ($sch_type == 1) {
                                                                                echo "خاص";
                                                                            } elseif ($sch_type == 2) {
                                                                                echo "حكومى";
                                                                            } else {
                                                                                "";
                                                                            } ?>
                                                                        </div>
                                                                    </div>

                                                                <?php } ?>

                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div>
                                                    <?php if ($setting[43]->display == 1) { ?>
                                                        <div class="row">
                                                            <div class="nafsyaaDiv">
                                                                <?php
                                                                $live_with = array(1 => lang("am_student_live_parents"), 2 => lang("am_student_live_father"), 3 => lang("am_student_live_mother"), 4 => lang("am_student_live_other"));
                                                                $social_parents = array(1 => lang("am_married"), 2 => lang("separated"));
                                                                $grand_parents = array(1 => lang("Grandparents from the father's side"), 2 => lang("Grandparents from the mother's side"));
                                                                $history = array(lang('am_student_father_side'), lang('am_student_mother_side'));
                                                                $allergy = array(lang("am_student_food"), lang("am_student_medicin"));
                                                                $student_descripe = array(1 => lang("am_student_descripe1"), 2 => lang("am_student_descripe2"), 3 => lang("am_student_descripe3"), 4 => lang("am_student_descripe4"));
                                                                ?>
                                                                <h4 class="school_name"><?= $getStudentR['schoolName'] ?>
                                                                </h4>

                                                                <h4 class="divHeader nafsyaa">
                                                                    <?php echo lang('am_student_psyy'); ?> </h4>
                                                                <div class="row">
                                                                    <?php if ($setting[72]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo lang('am_student_brothers'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['brothers_num']; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[73]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo lang('am_student_order'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['student_order']; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[74]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_student_live_with'); ?>
                                                                                :</label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $live_with[$getStudentR['live_with']]; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[75]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo lang('am_social'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $social_parents[$getStudentR['social_parents']]; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[76]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_grand_parents'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?php
                                                                                $arr = explode(',', $getStudentR['grand_parents']);
                                                                                if ($arr[0] == 1) {
                                                                                    echo lang('am_father_grand');
                                                                                } elseif ($arr[0] == 2) {
                                                                                    echo lang('am_mother_grand');
                                                                                }
                                                                                if ($arr[1] == 1) {
                                                                                    echo " ," . lang('am_father_grand');
                                                                                } elseif ($arr[1] == 2) {
                                                                                    echo " ," . lang('am_mother_grand');
                                                                                }
                                                                                if ($getStudentR['grand_parents'] == "لا") {
                                                                                    echo $getStudentR['grand_parents'];
                                                                                }
                                                                                if ($getStudentR['grand_parents'] == "نعم") {
                                                                                    echo $getStudentR['grand_parents'];
                                                                                }

                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[77]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_student_skills'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['student_skills']; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[78]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_student_games'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['student_games']; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[79]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_student_sport'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['student_sport']; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[80]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_student_place'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['student_place']; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[81]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_student_relation'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['student_relation']; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[82]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_student_descripe'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $student_descripe[$getStudentR['student_descripe']]; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[83]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_student_behavior'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['student_behavior']; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[84]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_student_get_rid'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['student_get_rid']; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[85]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_student_pressure'); ?>
                                                                            </label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['student_pressure']; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[86]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_student_person'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['student_person']; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[87]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_student_punish'); ?>
                                                                            </label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['student_punish']; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[88]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                <?php echo lang('am_student_specialist'); ?></label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['student_specialist']; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }
                                                                    if ($setting[89]->display == 1) { ?>
                                                                        <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                            <label class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo lang('am_student_academy'); ?>:</label>
                                                                            <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                <?= $getStudentR['student_academy']; ?>
                                                                            </div>
                                                                        </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[99]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_child_favorite_color'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['child_favorite_color']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[100]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_child_favorite_game'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['child_favorite_game']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[101]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_child_favorite_type_toy'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['child_favorite_type_toy']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[102]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_child_favorite_animal'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['child_favorite_animal']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[103]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_child_favorite_nickname'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['child_favorite_nickname']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[104]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_child_favorite_food'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['child_favorite_food']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[105]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_things_scare_child'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['things_scare_child']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[106]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_additional_information'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['additional_information']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[107]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_enter_bathroom'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['enter_bathroom']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[108]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_method_enter_bathroom'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['method_enter_bathroom']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[109]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_time_electronic_devices'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['time_electronic_devices']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[110]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_child_hobbies'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['child_hobbies']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[111]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_activities_programs'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['activities_programs']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[112]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_child_routine'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['child_routine']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[113]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_memorize_Quran'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['memorize_Quran']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php if ($setting[114]->display == 1) { ?>
                                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                                    <?php echo lang('er_parenting_strategies'); ?></label>
                                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                                    <?= $getStudentR['parenting_strategies']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                </div>
                                                            </div>
                                                            <h4 class="divHeader"><?php echo lang('am_student_psyyy'); ?>
                                                            </h4>
                                                            <div class="row">
                                                            <?php 
                                                                    if ($setting[90]->display == 1) { ?>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                        <?php echo lang('am_student_diseases'); ?> </label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                        <?= $getStudentR['student_diseases']; ?>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                                    if ($setting[91]->display == 1) { ?>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                        <?php echo lang('am_student_treatment'); ?></label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                        <?= $getStudentR['student_treatment']; ?>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                                    if ($setting[92]->display == 1) { ?>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                        <?php echo lang('am_student_history'); ?></label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                        <?php
                                                                        if ($getStudentR['student_history'] == "لا") {
                                                                            echo $getStudentR['student_history'];
                                                                        } elseif ($getStudentR['student_history'] == "نعم") {
                                                                            echo $getStudentR['student_history'];
                                                                        } else {
                                                                            $arr = explode(',', $getStudentR['student_history']);
                                                                            echo lang("father's face") . " :" . $arr[0];
                                                                            echo '<br/>' . lang("mother's face") . " :" . $arr[1];
                                                                            // 		foreach (unserialize($getStudentR['student_history']) as $key => $value) {
                                                                            // 			echo '	<div class="col-md-12 col-sm-12 col-xs-12 divPrint">		
                                                                            // 						'.$history[$key].' : '.$value.'
                                                                            // 					</div>	';
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            <?php }
                                                                    if ($setting[93]->display == 1) { ?>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                        <?php echo lang('am_student_allergy'); ?></label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                        <?php
                                                                        if ($getStudentR['student_allergy'] == "لا") {
                                                                            echo $getStudentR['student_allergy'];
                                                                        } elseif ($getStudentR['student_allergy'] == "نعم") {
                                                                            echo $getStudentR['student_allergy'];
                                                                        } else {
                                                                            $arr = explode(',', $getStudentR['student_allergy']);
                                                                            echo lang('am_student_food') . " :" . $arr[0];
                                                                            echo '<br/>' .  lang('am_student_medicin') . " :" . $arr[1];
                                                                            // 			print_r();die;
                                                                            // 		foreach ($getStudentR['student_allergy']as $key => $value) {
                                                                            // 			echo '	<div class="col-md-12 col-sm-12 col-xs-12 divPrint">		
                                                                            // 						'.$allergy[$key].' : '.$value.'
                                                                            // 					</div>	';
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                                    if ($setting[94]->display == 1) { ?>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                        <?php echo lang('am_student_health'); ?> </label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                        <?= $getStudentR['student_health']; ?>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                                    if ($setting[95]->display == 1) { ?>
                                                                <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                    <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                        <?php if ($this->ApiDbname == "SchoolAccTilalAlzahran") { ?>
                                                                            <?php echo lang('Does_suffer_notmentioned'); ?>
                                                                        <?php } else { ?>
                                                                            <?php echo lang('Does_student_suffer_notmentioned'); ?>
                                                                        <?php } ?>
                                                                    </label>
                                                                    <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                        <?= $getStudentR['student_health_not']; ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            </div>
                                                            <div class="form-group col-md-4 col-sm-12 col-xs-12 printDivO">
                                                                <label class="control-label col-md-12 col-sm-12 col-xs-12">
                                                                    <?php echo lang('am_Signature'); ?> </label>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 divPrint">
                                                                    <?= $getStudentR['Signature']; ?>
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