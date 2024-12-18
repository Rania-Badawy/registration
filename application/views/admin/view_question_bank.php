<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<!-- tornado-rtl.css -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets_emp/bank/css/tornado-rtl.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets_emp/css/fontawsome.css">

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script>
    
    <script type="text/javascript" language="javascript" class="init">
        $(function() {
            $('#example').dataTable();

        });
    </script>

    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>datepicker/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>datepicker/css/datepicker.css" type="text/css" />
        <div class="clearfix"></div>
    <div class="clearfix"></div>

    <div class="content margin-top-none container-page">
        <div class="col-lg-12">
            <div class="block-st">
                <div class="sec-title">
                    <h2><?php echo lang('question_bank'); ?> </h2>
                    <span class="pull-left">
                        <a class="btn btn-success pull-left" href="<?= site_url('admin/question_bank/question_form') ?>"><?= lang('add_question_bank'); ?>
                        </a>
                    </span>
                </div>
                <div class="clearfix"></div>


                <?php
                if ($this->session->flashdata('SuccessAdd')) {
                    echo  '<div class="alert alert-success">' . $this->session->flashdata('SuccessAdd') . '</div>';
                }
                if ($this->session->flashdata('ErrorAdd')) {
                    echo  '<div class="alert alert-error">' . $this->session->flashdata('ErrorAdd') . '</div>';
                }
                ?>
                <div class="row" dir="auto">

                    <div class="form-group col-lg-5">

                        <label class="control-label col-lg-3"><?php echo lang('br_year'); ?><span class="danger" style="color: red;">*</span></label>

                        <div class="col-lg-9">

                            <select data-placeholder="<?php echo lang('br_year'); ?>" class="selectpicker form-control" data-live-search="true" tabindex="18" name="year_id" id="year_id">

                                <?php

                                foreach ($get_year as $Key => $ye) {

                                    $yearID         = $ye->ID;

                                    $yearName       = $ye->year_name;


                                ?>

                                    <option value="<?php echo $yearID; ?>" <?php if ($yearID == $year_id) {
                                                                                echo 'selected';
                                                                            } ?>> <?php echo $yearName; ?></option>

                                <?php

                                }

                                ?>

                            </select>

                        </div>

                    </div>

                    <div class="form-group col-lg-5">

                        <label class="control-label col-lg-3"><?php echo lang('Semester'); ?></label>

                        <div class="col-lg-9">

                            <select data-placeholder="<?php echo lang('Semester'); ?>" class="selectpicker form-control selectGroup bs-select-hidden" data-live-search="true" tabindex="18" name="Semesterid" id="Semesterid">

                                <option value="0" style="display:none"><?php echo lang('am_select'); ?></option>
                                <?php

                                foreach ($Semester as $Key => $sem) {

                                    $ID         = $sem->ID;

                                    $Name       = $sem->Name;

                                ?>

                                    <option value="<?php echo $ID; ?>" <?php if ($Semesterid == $ID) {
                                                                            echo 'selected';
                                                                        } ?>> <?php echo $Name; ?></option>

                                <?php

                                }

                                ?>

                            </select>

                        </div>


                    </div>

                    <div class="form-group col-lg-5">

                        <label class="control-label col-lg-3"><?php echo lang('am_row'); ?></label>

                        <div class="col-lg-9">

                            <select data-placeholder="<?php echo lang('am_row'); ?>" class="selectpicker form-control bs-select-hidden" data-live-search="true" tabindex="18" name="row_level_id" id="row_level_id">

                                <option value="0" style="display:none"><?php echo lang('am_select'); ?></option>
                                <?php

                                        $bankName         = $quba['name_ar'];
                                        $subjectName      = $quba['subjectdata']['name_ar'];
                                        $levelName        = $quba['gradedata']['level']['name_ar'];
                                        $gradeName        = $quba['gradedata']['name_ar'];
                                        $schoolName       = $quba['school']['name_ar'];
                                        $semesterName     = $quba['semesterdata']['name_ar'];
                                foreach ($row_level as $Key => $lev) {

                                    $row_level_ID  = $lev->ID;

                                    $Level_Name    = $lev->Level_Name;

                                    $Row_Name      = $lev->Row_Name;

                                        $bankName         = $quba['name_en'];
                                        $subjectName      = $quba['subjectdata']['name_en'];
                                        $levelName        = $quba['gradedata']['level']['name_en'];
                                        $gradeName        = $quba['gradedata']['name_en'];
                                        $schoolName       = $quba['school']['name_en'];
                                        $semesterName     = $quba['semesterdata']['name_en'];
                                    
                                ?>

                                    <option value="<?php echo $row_level_ID; ?>" <?php if ($row_level_id == $row_level_ID) {
                                                                                        echo 'selected';
                                                                                    } ?>>
                                        <?php echo $Level_Name . "/" . $Row_Name; ?></option>

                                <?php

                                                                                }

                                ?>

                            </select>

                        </div>


                    </div>

                    <div class="form-group col-lg-5">

                        <label class="control-label col-lg-3"><?php echo lang('am_subject'); ?></label>

                        <div class="col-lg-9">

                            <select data-placeholder="<?php echo lang('am_subject'); ?>" class="selectpicker form-control bs-select-hidden" data-live-search="true" tabindex="18" name="Subjectid" id="Subjectid">

                                <option value="0"><?php echo lang('am_choose_all'); ?></option>
                                <?php

                                if ($row_level_id) {
                                    foreach ($subject_by_rowlevel as $Key => $sub) {

                                        $ID   = $sub->SubjectID;

                                        $Name = $sub->Name;

                                ?>

                                        <option value="<?php echo $ID; ?>" <?php if ($Subjectid == $ID) {
                                                                                echo 'selected';
                                                                            } ?>> <?php echo $Name; ?></option>

                                <?php

                                    }
                                }

                                ?>
                            </select>

                        </div>


                    </div>

                    <input type="submit" class="btn btn-success" style="margin-top: 100px;" value="<?php echo lang('am_view'); ?>" onClick="return check_Request_add();" />
                </div>
            </div>
            <div class="block-st">
                <?php
                // print_r($get_employee);die;
                if (!empty($queBank)) { ?>
                    <div class="clearfix"></div>
                    <div class="panel panel-danger">
                        <div class="panel-body no-padding">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('br_n') ?></th>
                                        <th><?php echo lang('question_bank_name') ?></th>
                                        <th><?php echo lang('am_row') ?></th>
                                        <th><?php echo lang('am_subject') ?></th>
                                        <th><?php echo lang('br_Branche') ?></th>
                                        <th><?php echo lang('br_year') ?></th>
                                        <th><?php echo lang('Semester') ?></th>
                                        <th><?php echo lang('status') ?></th>
                                        <th><?php echo lang('am_view') ?></th>
                                        <th><?php echo lang('am_edit') ?></th>
                                        <th><?php echo lang('add_questions') ?></th>
                                        <th><?php echo lang('br_delete') ?></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($queBank as $Key => $quba) {
                                        $KeyVal              = $Key + 1;
                                        $ID                  = $quba['id'];
                                        $RowLevelID          = $quba['gradedata']['id'];
                                        $subjectID           = $quba['subject'];
                                        $school_id           = $quba['school_id'];
                                        $SemesterID          = $quba['semesterdata']['id'];
                                        $yearID              = $quba['yere']['id'];
                                        $yearName            = $quba['yere']['year_name'];
                                        $status              = $quba['status'];
                                        if ($Lang == "arabic") {

                                            $bankName         = $quba['name_ar'];
                                            $subjectName      = $quba['subjectdata']['name_ar'];
                                            $RowLevelName     = $quba['gradedata']['name_ar'];
                                            $schoolName       = $quba['school']['name_ar'];
                                            $semesterName     = $quba['semesterdata']['name_ar'];
                                        } else {

                                            $bankName         = $quba['name_en'];
                                            $subjectName      = $quba['subjectdata']['name_en'];
                                            $RowLevelName     = $quba['gradedata']['name_en'];
                                            $schoolName       = $quba['school']['name_en'];
                                            $semesterName     = $quba['semesterdata']['name_en'];
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $KeyVal; ?></td>
                                            <td><?php echo $bankName; ?></td>
                                            <td><?php echo $RowLevelName; ?></td>
                                            <td><?php echo $subjectName; ?></td>
                                            <td><?php echo $schoolName; ?></td>
                                            <td><?php echo $yearName; ?></td>
                                            <td><?php echo $semesterName; ?></td>
                                            <td><?php if ($status == '1') {
                                                    echo lang('br_active');
                                                } else {
                                                    echo lang('br_not_active');
                                                } ?></td>

                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('emp/exam_new/ques_type/' . $RowLevelID."/".$subjectID."/".'6'."/".$ID."/".'2'); ?>" target="_blank" class="btn btn-success btn-rounded">


                                            <td>
                                                <a href="<?php echo site_url('admin/question_bank/question_form/' . $ID); ?>" class="btn btn-success btn-rounded">

                                                    <i class="fa fa-edit "></i>

                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?php echo site_url('emp/exam_new/ques_type/' . $RowLevelID . "/" . $subjectID . "/" . '6' . "/" . $ID . "/" . '2'); ?>" target="_blank" class="btn btn-success btn-rounded">

                                                    <i class="fa fa-plus "></i>

                                                </a>
                                            </td>

                                            <td>
                                                <a href="<?php echo site_url('admin/question_bank/delete_question_bank/' . $ID); ?>" onclick="return confirm('Are you sure to delete?')" class="btn btn-danger btn-rounded">

                                                    <i class="fa fa-trash-o"></i>

                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>


                    </div>

                <?php
                } else {
                    echo '<div class="alert alert-error">' . lang('br_check_add') . '</div>';
                }
                ?>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>

    

    <script src="<?php echo base_url(); ?>assets_emp/bank/js/index.js"></script>
    <script src="<?php echo base_url(); ?>assets_emp/bank/js/tornado.min.js"></script>