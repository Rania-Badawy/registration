<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>


<script type="text/javascript">
$(document).ready(function() {

    $('#example').DataTable({

        "dom": 'lBfrtip',

        buttons: [{
                extend: 'print',
                title: '<?php echo lang('reg_form_complete'); ?>'
            },
            {
                extend: 'excel',
                title: '<?php echo lang('reg_form_complete'); ?>'

            },
            {
                extend: 'copy',
                title: '<?php echo lang('reg_form_complete'); ?>'

            },
        ]
    });

});
</script>
<style>
.footer-page {
    display: none;
}
</style>
<div class="clearfix"></div>
<div class="content margin-top-none container-page">
    <div class="col-lg-12">
        <div class="block-st">
            <div class="sec-title">
                <h2><?php echo lang('reg_form_complete'); ?></h2>
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

            <form action="<?php echo site_url('admin/Report_Register/reg_complete') ?>" method="post">

               

                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-12"><?php echo lang('br_school_name'); ?></label>

                    <div class="col-lg-12">

                        <select name="school" id="school" class="form-control" required>
                            <option value=""></option>
                           <?php if ($get_schools != 0) {

                                foreach ($get_schools as $School) {

                                    $SchoolId       = $School->SchoolId;
                                    $SchoolName     = $School->SchoolName;
                                    $GetBranches    = get_branches();
                                    $school_per     = explode(",",$GetBranches);
									if (in_array($SchoolId, $school_per)) {
                            ?>
                            <option value="<?php echo $SchoolId; ?>" <?php if ($SchoolId == $SchoolID) {
                                                                                    echo "selected";
                                                                                } ?>>
                                <?php echo $SchoolName; ?></option>

                            <?php 
                            }}} ?>

                        </select>

                    </div>

                </div>

                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-12"><?php echo lang('br_year'); ?></label>

                    <div class="col-lg-12">

                        <select name="GetYear" id="GetYear" class="form-control" required>
                            <option value=""></option>
                            <?php

                            foreach ($GetYear as $year) {

                                $ID          = $year->YearId;

                                $YearName    = $year->YearName;

                                $IsNextYear   = $year->IsNextYear;

                            ?>

                            <option value="<?php echo $ID; ?>" <?php if ($ID == $Get_Year) {
                                                                        echo "selected";
                                                                    } ?>>
                                <?php echo $YearName; ?></option>

                            <?php } ?>

                        </select>

                    </div>

                </div>

                <div class="col-lg-2">
                    <input type="submit" class="btn btn-success" value="<?= lang('am_search'); ?>"
                        style="margin-top: 36px;" />
                </div>

            </form>
            <div class="clearfix"></div>
            <div class="panel panel-danger">

                <div class="panel-body no-padding">

                    <?php if (is_array($getStudentR)) { ?>
                    <table class="table table-bordered table-striped" id="example">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="text-align: center !important;"><?php echo lang('order number') ?> </th>
                                <th style="text-align: center !important;"><?php echo lang('student_name') ?></th>
                                <!--<th style="text-align: center !important;" ><?php echo lang('am_Mobile') ?></th>-->
                                <th style="text-align: center !important;"> <?php echo lang('br_reg_date') ?></th>
                                <th style="text-align: center !important;"><?php echo lang('am_studeType') ?></th>
                                <th style="text-align: center !important;"> <?php echo lang('br_level') ?> </th>
                                <!--<th style="text-align: center !important;" ><?php echo lang('br_status') ?> </th>-->
                                <!--<th style="text-align: center !important;" ><?php echo lang('contacted') ?>  </th>-->
                                <th style="text-align: center !important;"> <?php echo lang('interview_date') ?> </th>
                                <th style="text-align: center !important;">المقابله </th>
                                <th style="text-align: center !important;"> <?php echo lang('test_student_degree') ?>
                                </th>
                                <th style="text-align: center !important;"> <?php echo lang('test_degree') ?> </th>
                                <!--<th style="text-align: center !important;" > <?php echo lang('student_percentage') ?> </th>-->
                                <th style="text-align: center !important;"><?php echo lang('br_academy_accept') ?></th>
                                <th style="text-align: center !important;"><?php echo lang('br_money_accept') ?></th>
                                <?php if ($reg_per['NameSpaceID'] == 87 ||$this->session->userdata('type') == "U") { ?>
                                <th style="text-align: center !important;"><?php echo lang('am_send_test') ?></th>
                                <?php } ?>
                                <?php if ($reg_per['NameSpaceID'] == 85 || $reg_per['NameSpaceID'] == 87 ||$this->session->userdata('type') == "U") { ?>
                                <th style="text-align: center !important;"><?php echo lang('repet_exam') ?> </th>
                                <?php } ?>
                                <?php if ($reg_per['NameSpaceID'] == 85  ||$this->session->userdata('type') == "U") { ?>
                                <th style="text-align: center !important;"><?php echo lang('er_repeat_accept') ?> </th>
                                <?php } ?>
                                <th style="text-align: center !important;"><?php echo lang('br_page_view') ?></th>
                                <?php $query = $this->db->query("select GroupID from contact where ID =" . $this->session->userdata('id') . "")->row_array();
                                    if ($query['GroupID'] != 18) {
                                    ?>
                                <th style="text-align: center !important;"><?php echo lang('br_delete') ?> </th>

                                <?php } ?>

                            </tr>
                        </thead>

                        <tbody>
                            <?php

                                foreach ($getStudentR as $Key => $StudentR) {
                                    $exam               = 0;
                                    $Num                = $Key + 1;
                                    $id                 = $StudentR->id;
                                    $name               = $StudentR->name;
                                    $parent_name        = $StudentR->parent_name;
                                    $LevelId            = $StudentR->LevelID;
                                    $Nationality        = $StudentR->nationality;
                                    $IsAccepted         = $StudentR->IsAccepted;
                                    $check_code         = $StudentR->check_code;
                                    $parent_mobile      = $StudentR->parent_mobile;
                                    $Reg_Date           = $StudentR->Reg_Date;
                                    $status             = $StudentR->status_reg;
                                    $is_contact         = $StudentR->is_contact;
                                    $schoolID           = $StudentR->schoolID;
                                    $studyType          = $StudentR->studyType;
                                    $gender             = $StudentR->gender;
                                    $interview_date     = $StudentR->interview_date;
                                    $is_attend          = $StudentR->is_attend;
                                    $level_name         = $StudentR->levelName;
                                    $duration           = $StudentR->duration;
                                    $notes              = $StudentR->note;
                                    $rowLevelID         = $StudentR->rowLevelID;
                                    $YearId             = $StudentR->YearId;
                                    $ContactID          = $StudentR->ContactID;
                                    $interview_type     = $StudentR->interview_type;
                                    $student_percentage = $StudentR->student_percentage;
                                    $query_attend       = $this->db->query("select * from zoom_meetings where reg_id=" . $id . " order by id desc")->row_array();
                                    $min                = $query_attend['duration'];
                                    $endTime            = date('Y-m-d H:i:s', strtotime($query_attend['start_time']) + $min * 60);
                                    $starttime          = date('Y-m-d H:i:s', strtotime($query_attend['start_time']));
                                    $date_now           = date('Y-m-d H:i:s', strtotime($date));
                                    $status_academy     = lang('br_request_wating');
                                    $status_money       = lang('br_request_wating');
                                    $query              = $this->db->where('RequestID', $StudentR->id)->get('active_request')->result();
                                    $total_degree       = "";
                                    $student_degree     = "";
                                    $check_exam         = $this->db->query("select ID  FROM `test` WHERE SchoolId=$schoolID AND FIND_IN_SET($rowLevelID ,`RowLevelID`) AND IsActive=1 AND type =4  ")->row_array();
                                    $contact_id         = $this->db->query("SELECT ID FROM `contact` WHERE contact.reg_id  =" . $id . " ")->row_array();
                                    if ($contact_id['ID']) {
                                        $exam           = $this->db->query("select ID  FROM `test_student` WHERE `Contact_ID`     =  " . $contact_id['ID'] . " ")->row_array();
                                    }

                                    if ($ContactID) {
                                        $total_degree    = $this->Report_Register_model->getTotalTestDegree($rowLevelID, $ContactID);
                                        $student_degree  = $this->db->query("select sum( test_student.Degree) as student_totalDeg from test_student where Contact_ID=" . $ContactID . " ")->row_array();
                                    }
                                    if ($query != null) {
                                        foreach ($query as $row) {
                                            if ($row->NameSpaceID == 87 && $row->IsActive == 1) {
                                                $status_academy = lang('br_request_accepted');
                                            }
                                            if ($row->NameSpaceID == 87 && $row->IsActive == 2) {
                                                $status_academy = lang('br_request_refused');
                                            }
                                            if ($row->NameSpaceID == 85 && $row->IsActive == 1) {
                                                $status_money = lang('br_request_accepted');
                                            }
                                            if ($row->NameSpaceID == 85 && $row->IsActive == 2) {
                                                $status_money = lang('br_request_refused');
                                            }
                                        }
                                    }
                                    $IsActiveArray = array(1 => lang('br_active'), 0 => lang('br_not_active'));
                                    $studyTypeMap = array_column($allStudeType, 'StudyTypeName', 'StudyTypeId');
                                    $StudyTypeName = isset($studyTypeMap[$studyType]) ? $studyTypeMap[$studyType] : null;
                                    if ($StudentR->rowLevelID) {
                                ?>
                            <tr>
                                <td><?php echo $Num; ?></td>
                                <td><?php echo $check_code; ?></td>
                                <td><?php echo $name; ?></td>
                                <!--<td><?php echo "-----" . substr($parent_mobile, 0, 3); ?></td>-->
                                <td><?php echo $Reg_Date; ?></td>
                                <td><?php echo $StudyTypeName ?></td>
                                <td><?php echo $level_name;  ?></td>
                                <!--<td><?php echo $status; ?></td>-->
                                <!--  <td><?php echo $is_contact; ?></td>-->
                                <td>
                                    <button type="button" class="allowedAddedButton btn btn-info btn-rounded"
                                        data-toggle="modal" data-target="#view-rating-<?= $Num ?>">
                                        <?php if ($interview_date) {
                                                        echo $interview_date;
                                                    } else {
                                                        echo lang('interview_date');
                                                    } ?></button>
                                </td>
                                <td>
                                    <?php
                                                $query = $this->db->query("select ID,GroupID,Type from contact where ID =" . $this->session->userdata('id') . "")->row_array();

                                                if (($query['Type'] == 'U' || $query['ID'] == $query_attend['teacherid']) && $starttime < $date_now && $endTime > $date_now) {

                                                    $token = $this->zoom_token;
                                                    $curl_h = curl_init('https://api.zoom.us/v2/meetings/' . $query_attend['meeting_id']);
                                                    curl_setopt(
                                                        $curl_h,
                                                        CURLOPT_HTTPHEADER,
                                                        array("Authorization:Bearer" . $token,)
                                                    );
                                                    curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
                                                    $response =  json_decode(json_encode(curl_exec($curl_h)), true);
                                                    $obj = json_decode($response);
                                                ?>
                                    <a href="<?php echo site_url('emp/zoom/user_attend/' . $query_attend['meeting_id'] . '/' . $query_attend['id'] . '/' . $endTime) ?>"
                                        class="btn small circle fa fa-plus success"></a>

                                    <?php } elseif ($interview_type == 1) { ?>
                                    <a disabled href="#" class="btn small circle fa fa-plus"></a>
                                    <?php
                                                } ?>
                                </td>
                                <td><?= $student_degree['student_totalDeg'] ?></td>
                                <td><?= $total_degree ?></td>
                                <!--<td><?= $student_percentage ?></td>-->
                                <td><?= $status_academy ?></td>

                                <td><?= $status_money ?></td>
                                <?php if ($reg_per['NameSpaceID'] == 87 ||$this->session->userdata('type') == "U") { ?>
                                <td>
                                    <?php if (!$exam['ID'] && $check_exam['ID']) { ?>
                                    <button type="button" class="allowedAddedButton btn btn-info btn-rounded"
                                        data-toggle="modal" data-target="#view-sms-<?= $Num ?>"> <i
                                            class='fa fa-envelope'></i></button>
                                    <?php } else { ?>
                                    <button type="button" class="allowedAddedButton btn btn-info btn-rounded" disabled>
                                        <i class='fa fa-envelope'></i></button>
                                    <?php } ?>
                                    <!--<a role="button"  href="<?= site_url('admin/Report_Register/send_sms/' . $id . '') ?>" class="btn btn-success btn-rounded" >-->
                                    <!--    <?php echo lang('br_send_sms_table') ?> -->
                                    <!--</a>-->
                                    <div id="view-sms-<?= $Num ?>" class="modal fade in" tabindex="-1" role="dialog"
                                        aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background: cadetblue !important;">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        <?php echo lang('Exams') ?> </h4>
                                                </div>
                                                <form
                                                    action="<?php echo site_url('admin/Report_Register/send_sms/' . $id . ''); ?>"
                                                    method="post">
                                                    <div class="modal-body">

                                                        <div class="form-group">
                                                            <label
                                                                style="width: inherit;"><?php echo lang('answer_exam') ?></label>
                                                            <div class="controls">
                                                                <div class="col-lg-4">
                                                                    <label class="control-radio">Remotly
                                                                        <input type="radio" name="test_attend"
                                                                            value="1" />
                                                                        <div class="control_indicator_radio"></div>
                                                                    </label>
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    <label class="control-radio">School
                                                                        <input type="radio" name="test_attend"
                                                                            value="2" />
                                                                        <div class="control_indicator_radio"></div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="modal-footer noborder">
                                                            <input type="button" class="col-lg-2 text-left"
                                                                class="btn btn-danger" data-dismiss="modal"
                                                                value="<?php echo lang('am_close') ?>">
                                                            <input type="submit" class="col-lg-2 text-right"
                                                                class="btn btn-info"
                                                                value="<?php echo lang('am_save') ?>">
                                                        </div>
                                                </form>
                                            </div </div>
                                        </div>
                                    </div>
                </div>
                </td>
                <?php } ?>
                <?php if (($reg_per['NameSpaceID'] == 85 || $reg_per['NameSpaceID'] == 87) ||$this->session->userdata('type') == "U") { ?>
                <td>
                    <?php if($exam['ID'] && $check_exam['ID']){?>
                    <a role="button" href="<?= site_url('admin/Report_Register/repeat_accept_academy/' . $id . '') ?>"
                        class="btn btn-success btn-rounded">
                        <?php echo lang('repet_exam') ?>
                    </a>
                    <?php } ?>
                </td>
                <?php } ?>
                <?php if ($reg_per['NameSpaceID'] == 85  ||$this->session->userdata('type') == "U") { ?>
                <td>
                <?php if($status_academy == lang('br_request_refused') ||(!$exam['ID'] && $IsAccepted!=1 && $status_academy == lang('br_request_accepted'))){?>
                    <a role="button" href="<?= site_url('admin/Report_Register/repeat_acceptance/' . $id . '') ?>"
                        class="btn btn-success btn-rounded">
                        <?php echo lang('er_repeat_accept') ?>
                    </a>
                    <?php } ?>
                </td>
                <?php } ?>
                <td>
                    <?php
                                        $query = $this->db->query("select GroupID from contact where ID =" . $this->session->userdata('id') . "")->row_array();
                                        if ($StudentR->rowLevelID) {
                ?>
                    <a role="button"
                        href="<?= site_url('admin/Report_Register/view_student_register_complete/' . $id . "/" . $schoolID . "/" . $YearId) ?>"
                        class="btn btn-success btn-rounded">
                        <?php echo lang('br_page_view') ?> <i class="fa fa-edit"></i>
                    </a>
                    <?php } ?>

                </td>
                <?php $query = $this->db->query("select ID,GroupID,Type from contact where ID =" . $this->session->userdata('id') . "")->row_array();
                                        if ($query['GroupID'] != 18) {
            ?>
                <td>

                    <a class="btn btn-danger" onclick="return confirm('Are you sure to delete?')"
                        href="<?php echo site_url('admin/Report_Register/delete_register/' . $id) ?>"><?= lang('br_delete'); ?></a>
                </td>
                <?php } ?>



                </tr>
                <div id="view-rating-<?= $Num ?>" class="modal fade in" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background: #1173bb;--primary-hover:">
                                <h4 class="modal-title" id="myModalLabel" style="color: #ffffff;"><?php echo lang('interview_attend') ?> </h4>
                            </div>
                            <form
                                action="<?php echo site_url('admin/Report_Register/add_register_attend/' . $id . ''); ?>"
                                method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label col-lg-4"><?php echo lang('am_date') ?></label>
                                        <div class="controls">

                                            <input type="datetime-local" name="interview_date"
                                                <?php if ($interview_date != "") { ?>value="<?php echo date("Y-m-d\TH:i:s", strtotime($interview_date)); ?>"
                                                <?php } ?> required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-4"> <?php echo lang('Duration per minute') ?></label>
                                        <div class="controls">
                                            <input type="number" name="duration" value="<?php echo $duration; ?>"
                                                required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4"><?php echo lang('attend') ?></label>
                                        <div class="controls">
                                            <div class="col-lg-4">
                                                <label class="control-radio"> <?php echo lang('Yes') ?>
                                                    <input type="radio" name="attend" value="نعم"
                                                        <?php if ($is_attend == "نعم") { ?> checked="checked"
                                                        <?php } ?> />
                                                    <div class="control_indicator_radio"></div>
                                                </label>
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="control-radio"><?php echo lang('NO') ?>
                                                    <input type="radio" name="attend" value="لا"
                                                        <?php if ($is_attend == "لا") { ?> checked="checked"
                                                        <?php } ?> />
                                                    <div class="control_indicator_radio"></div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="control-label col-lg-4"><?php echo lang('meeting_type') ?></label>
                                        <div class="controls">
                                            <div class="col-lg-4">
                                                <label class="control-radio">Zoom
                                                    <input type="radio" name="interview_type" value="1"
                                                        <?php if ($interview_type == 1) { ?> checked="checked"
                                                        <?php } ?> />
                                                    <div class="control_indicator_radio"></div>
                                                </label>
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="control-radio">School
                                                    <input type="radio" name="interview_type" value="2"
                                                        <?php if ($interview_type == 2) { ?> checked="checked"
                                                        <?php } ?> />
                                                    <div class="control_indicator_radio"></div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-4"><?php echo lang('am_notes') ?> </label>
                                        <div class="controls">
                                            <textarea name="notes"><?php echo $notes; ?></textarea>
                                        </div>
                                    </div>
                                    <?php $query = $this->db->query("SELECT time_zone FROM school_details WHERE ID = '" . $this->session->userdata('SchoolID') . "'  ")->row_array(); ?>
                                    <input type="hidden" name="timezone" value=<?= $query['time_zone']; ?>>


                                    <div class="modal-footer noborder">
                                        	<input type="button" class="col-lg-2 btn btn-danger" data-dismiss="modal" value="<?php echo lang('am_close'); ?>">
											<input type="submit" class="col-lg-2 text-right btn btn-info" value="<?php echo lang('am_save'); ?>">
                                    </div>
                            </form>
                        </div </div>
                    </div>
                </div>
                <?php
                                    }
                                }
    ?>
                </tbody>
                </table>
            </div>
        </div>

        <?php } ?>
    </div>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>

</div>
<div class="modal fade" id="msg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="margin-top: 0; margin-right: 30px"><?= lang('br_send_sms_table') ?></h4>
            </div>
            <form method="post" action="<?= site_url('admin/Report_Register/send_sms') ?>">
                <div class="modal-body">
                    <label> <?= lang('br_send_label') ?></label>
                    <input type="text" class="form-control" id="txtSms" name="txtSms" required="" />
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="person_mobile" name="parent_mobile" />
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('br_close') ?>
                    </button>
                    <button type="submit" class="btn btn-success"><?= lang('br_send_button') ?> <i
                            class="fa fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<input type="hidden" name="DbName" id="DbName" value="<?php echo $this->ApiDbname; ?>">
<script>
function clearColumns(ColumnsArray) {
    $(ColumnsArray).each(function() {
        $(this).empty();
        $(this).append('<option value="0">تحديد الكل</option>')
    });
}

function drawColumn(columnID, columnString, columnName) {
    columnnameID = "#" + columnName;
    $.each(data, function(key, value) {
        $('select[name="' + columnName + '"]').append('<option value="' + columnID + '">' + columnString +
            '</option>');
    });
    $(columnnameID).prop("disabled", false);

}

// $(document).ready(function () {
$('select[name="school"]').on('change', function() {
    var schoolID = $(this).val();
    var DbName = $('#DbName').val();
    if (schoolID) {
        $.ajax({
            url: '<?php echo lang("api_link"); ?>' + '/api/Years/' + DbName + '/GetOpenedYearsBySchoolId',
            type: "GET",
            data: {
                schoolId: schoolID
            },
            dataType: "json",
            success: function(data) {
                var element = $('select[name="GetYear"]');
                element.empty();
                element.append(
                    '<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                $.each(data, function(key, value) {
                    //   if((data[1]!=undefined&& value.IsNextYear===true)||(data[1]==undefined)){
                    element.append('<option value="' + value.YearId + '">' + value
                        .YearName + '</option>');
                    // }

                });
            }

        });
    } else {
        $('select[name="GetYear"]').empty();
    }
});



//   });
</script>