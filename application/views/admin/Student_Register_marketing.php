<link rel="stylesheet" href="http://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable({
        // paging: false,
        // ordering: false,
        // info: false,
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
                <h2><?php echo lang('br_check_st_register'); ?></h2>
            </div>

            <?php
            if($this->session->flashdata('SuccessAdd'))
            {
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

            if($this->session->flashdata('Failuer'))
            {
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

            <!----- Add title -------->



            <!----- Edit title -------->
            <form action="<?php echo site_url('admin/Report_Register/Student_Register_marketing') ?>" method="post">

                <!--         <div class="form-group col-lg-4">-->
                <!--					<label  class="control-label col-lg-3"> <?php echo lang('br_TeacherLevel');?>  </label>-->
                <!--					<div class="col-md-12 col-sm-12 col-xs-12">-->
                <!--                                  <select id="show" name="show" class="form-control ">-->
                <!--<option value=""><?php echo lang('am_select');?></option>-->
                <!--					        <option value="0" <?php if($show==0){echo selected ;} ?>><?php echo lang('am_all');?></option>-->
                <!--					        <option value="1" <?php if($show==1){echo selected ;} ?>><?php echo lang('levrl_1');?></option>-->
                <!--					        <option value="2" <?php if($show==2){echo selected ;} ?>><?php echo lang('levrl_2');?></option>-->

                <!--                                  </select>	-->

                <!--					</div>	-->

                <!--</div>-->

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

                            <option value="<?php echo $SchoolId;?>" <?php if($SchoolId==$SchoolID){echo "selected";}?>>
                                <?php echo $SchoolName;?></option>

                            <?php }}}?>

                        </select>

                    </div>

                </div>

                <div class="form-group col-lg-4">

                    <label class="control-label col-lg-12"><?php echo lang('br_year'); ?></label>

                    <div class="col-lg-12">

                        <select name="GetYear" id="GetYear" class="form-control" required>
                            <option value=""></option>
                            <?php 
        
        					 foreach($GetYear as $year){
        
        						$ID          = $year->YearId;
        
        						$YearName    = $year->YearName;
        						
        					   $IsNextYear   = $year->IsNextYear;
        
        				 ?>

                            <option value="<?php echo $ID;?>" <?php if($ID==$Get_Year){echo "selected";}?>>
                                <?php echo $YearName;?></option>

                            <?php }?>

                        </select>

                    </div>

                </div>

                <div class="col-lg-2" style="margin-top: 34px;">
                    <input type="submit" class="btn btn-success" value="<?= lang('am_search');?>" />
                </div>

            </form>
            <div class="clearfix"></div>
            <div class="panel panel-danger">

                <div class="panel-body no-padding">

                    <?php if(is_array($getStudentR)){ ?>
                    <table id="example" class="table table-striped table-bordered dataTable display no-footer">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="text-align: center !important;"><?php echo lang('order number') ?> </th>
                                <th style="text-align: center !important;"><?php echo lang('student_name') ?></th>
                                <th style="text-align: center !important;"><?php echo lang('am_Mobile') ?></th>
                                <th style="text-align: center !important;"> <?php echo lang('br_reg_date') ?></th>
                                <th style="text-align: center !important;"><?php echo lang('am_studeType') ?></th>
                                <th style="text-align: center !important;"> <?php echo lang('br_level') ?> </th>
                                <th style="text-align: center !important;"> <?php echo lang('am_region') ?> </th>
                                <th style="text-align: center !important;"><?php echo lang('br_status') ?> </th>
                                <th style="text-align: center !important;"><?php echo lang('contacted') ?> </th>
                                <!--<th style="text-align: center !important;" >تاريخ المقابله </th>-->
                                <th style="text-align: center !important;"><?php echo lang('br_page_view') ?></th>

                                <th style="text-align: center !important;"><?php echo lang('br_delete') ?> </th>
                                <!--<th style="text-align: center !important;" >المقابله  </th>-->
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                        foreach ($getStudentR as $Key=>$StudentR )
                        {
                            $Num		   = $Key+1 ;
							$id 	       = $StudentR->id ;
                            $name 	       = $StudentR->name ;
                            $parent_name   = $StudentR->parent_name ;
                            $LevelId 	   = $StudentR->LevelID ;
                            $Nationality   = $StudentR->nationality ;
                            $IsAccepted    = $StudentR->IsAccepted ;
                            $check_code    = $StudentR->check_code ;
                            $parent_mobile = $StudentR->parent_mobile ;
                            $Reg_Date      = $StudentR->Reg_Date ;
                            $status        = $StudentR->status_reg ;
                            $is_contact    = $StudentR->is_contact ;
                            $schoolID      = $StudentR->schoolID;
		                    $studyType     = $StudentR->studyType;
		                    $gender        = $StudentR->gender;
		                    $rowLevelName  = $StudentR->rowLevelName;
		                    $interview_date = $StudentR->interview_date;
		                    $is_attend      = $StudentR->is_attend;
		                    $level_name     = $StudentR->level_name;
		                    $duration       = $StudentR->duration;
		                    $notes          = $StudentR->notes;
                            $parent_region  = $StudentR->parent_region;
		                    $query_attend   = $this->db->query("select * from zoom_meetings where reg_id=".$id." order by id desc")->row_array();
		                    $min            = $query_attend['duration'];
                            $endTime        = date('Y-m-d H:i:s',strtotime($query_attend['start_time']) + $min*60);
                            $starttime      = date('Y-m-d H:i:s',strtotime($query_attend['start_time']));
                            
                             $IsActiveArray = array(1=>lang('br_active'),0=>lang('br_not_active'));
                             $studyTypeMap  = array_column($allStudeType, 'StudyTypeName', 'StudyTypeId');
                             $StudyTypeName = isset($studyTypeMap[$studyType]) ? $studyTypeMap[$studyType] : null;
                            ?>
                            <tr>
                                <td><?php echo $Num ?></td>
                                <td><?php echo $check_code ; ?></td>
                                <td><?php echo $name; echo " "; echo $parent_name?></td>
                                <td><?php echo "-----".substr($parent_mobile, 0,3); ?></td>
                                <td><?php echo $Reg_Date; ?></td>
                                <td><?php echo $StudyTypeName ?></td>
                                <td><?php echo $rowLevelName;  ?></td>
                                <td><?php echo $parent_region; ?></td>
                                <td><?php echo $status; ?></td>
                                <td><?php echo $is_contact; ?></td>
                                <td>
                                    <!-----EDIT----->
                                    <?php 
                                $query=$this->db->query("select GroupID from contact where ID =".$this->session->userdata('id')."")->row_array();
                               ?>
                                    <a role="button"
                                        href="<?= site_url('admin/Report_Register/view_student_register_new/'.$id.'') ?>"
                                        class="btn btn-success btn-rounded">
                                        <?php echo lang('br_page_view') ?> <i class="fa fa-edit"></i>
                                    </a>

                                </td>

                                <td>

                                    <a class="btn btn-danger" onclick="return confirm('Are you sure to delete?')"
                                        href="<?php echo site_url('admin/Report_Register/delete_register/'.$id) ?>"><?= lang('br_delete');?></a>
                                </td>


                            </tr>

                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <?php }?>
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
                    <h4 class="modal-title" style="margin-top: 0; margin-right: 30px"><?=  lang('br_send_sms_table') ?>
                    </h4>
                </div>
                <form method="post" action="<?=site_url('admin/student_register/send_sms') ?>">
                    <div class="modal-body">
                        <label> <?=  lang('br_send_label') ?></label>
                        <input type="text" class="form-control" id="txtSms" name="txtSms" required="" />
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="person_mobile" name="parent_mobile" />
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?=  lang('br_close') ?>
                        </button>
                        <button type="submit" class="btn btn-success"><?=  lang('br_send_button') ?> <i
                                class="fa fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" name="DbName" id="DbName" value="<?php echo $this->ApiDbname ;?>">
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
                url: '<?php echo lang("api_link"); ?>' + '/api/Years/' + DbName +
                    '/GetOpenedYearsBySchoolId',
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