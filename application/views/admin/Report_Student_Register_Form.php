<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js">
</script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {

        $('#example').DataTable({

            "dom": 'lBfrtip',

            buttons: [{
                    extend: 'print',
                    title: '<?php echo lang('br_report_st_register'); ?>'
                },
                {
                    extend: 'excel',
                    title: '<?php echo lang('br_report_st_register'); ?>'

                },
                {
                    extend: 'copy',
                    title: '<?php echo lang('br_report_st_register'); ?>'

                },
            ]
        });

    });
</script>
<?php

$get_api_setting = $this->setting_model->get_api_setting();
$this->ApiDbname = $get_api_setting[0]->{'ApiDbname'};
$ApiDbname

?>
<style>
    .block-st {
        min-height: 293px !important;
    }
</style>

<div class="content margin-top-none container-page">
    <div class="col-lg-12">
        <div class="block-st">
            <div class="sec-title">
                <h2><?php echo lang('br_report_st_register'); ?> </h2>
            </div>
            <form method="post" action="<?php echo site_url('admin/Report_Register/report_register/' . $reg_type); ?>">
                <input type="hidden" name="reg" value="<?= $reg_type; ?>">
              
                <div class="form-group col-lg-3">

                    <label class="control-label col-lg-12"><?php echo lang('br_school_name'); ?></label>

                    <div class="col-lg-12">

                        <select name="school" id="school" class="form-control selectpicker" required>
                            <option value=""><?php echo lang('am_select'); ?></option>
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
                                }}
                            } ?>

                        </select>

                    </div>

                </div>

                <!----- Edit title -------->

                <div class="form-group col-lg-3">

                    <label class="control-label col-lg-12"><?php echo lang('br_year'); ?></label>

                    <div class="col-lg-12">

                        <select name="GetYear" id="GetYear" class="form-control" required>
                            <option value=""></option>
                            <?php if ($SchoolID != 0) {

                                foreach ($getAllYear as $year) {

                                    $ID             = $year['id'];

                                    $YearName       = $year['name'];

                                    $schoolId       = $year['schoolId'];

                                    $IsNextYear     = $year['isNextYear'];
                                  

                            ?>

                                    <option value="<?php echo $ID; ?>" <?php if ($ID == $Get_Year) {
                                                                            echo "selected";
                                                                        } ?>>
                                        <?php echo $YearName; ?></option>

                            <?php }
                            } ?>

                        </select>

                    </div>

                </div>
                <?php  $query_erb = $this->db->query("SELECT IN_ERP ,time_zone FROM  school_details ")->row_array(); 
					       $query_sem = $this->db->query("SELECT semester FROM setting  ")->row_array(); 
					      
                         if(($query_erb['IN_ERP'] ==1) && ($query_erb['time_zone'] !='Africa/Cairo')) {
                             ?>
                <div class="form-group col-lg-3">

						<label class="control-label col-lg-12"><?php echo lang('Semester'); ?></label>

						<div class="col-lg-12">

							<select name="semester" id="semester" class="form-control">
								<option value="0"><?php echo lang('ra_Choose_semester'); ?></option>
								<option value="1,2,3" <?php if($semester=="1,2,3"){echo selected; }?>><?php echo lang('am_fullyear'); ?></option>
								<option value="2,3" <?php if($semester=="2,3"){echo selected; }?>><?php echo lang('ra_First_second_semester'); ?></option>
								<option value="3"  <?php if($semester=="3"){echo selected; }?>><?php echo lang('Semester')." ".lang('er_third'); ?></option>

							</select>

						</div>

					</div>
                    <?php } ?>

                <div class="form-group col-lg-1">
                    <div class="row">
                        <input type="submit" style=" margin-top: 35px;" class="btn btn-success" name="save" id="save" value="<?php echo lang('br_btn_show'); ?> " />
                    </div>

                </div>
        </div>
    </div>
    </form>


    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <?php $setting = $this->db->query("SELECT * FROM `form_setting` WHERE `form_type` =1")->result(); ?>
    <?php if (is_array($getStudentR)) { ?>
        <div class="clearfix"></div>
        <div class="panel panel-danger" style="width: 98%; margin-right: 15px;">
            <div class="panel-body no-padding">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center !important;">#</th>
                            <th style="text-align: center !important;"><?php echo lang('br_Name') ?></th>
                            <th style="text-align: center !important;"><?php echo lang('am_studeType') ?></th>
                            <?php if (($this->ApiDbname  == "SchoolAccAndalos")) { ?>
                                <th style="text-align: center !important;"><?php echo lang('br_level') ?></th>
                            <?php } ?>
                            <th style="text-align: center !important;"><?php echo lang('br_row_level') ?></th>
                            <th style="text-align: center !important;"><?php echo lang('br_reg_date') ?></th>
                            <th style="text-align: center !important;"><?php echo lang('br_st_fa_mobile') ?></th>
                            <th style="text-align: center !important;"><?php echo lang('am_mail') ?></th>
                            <!--<th style="text-align: center !important;" ><?php echo lang('br_st_mo_mobile') ?></th>-->
                            <th style="text-align: center !important;"><?php echo lang('er_Nationality') ?></th>
                            <!--th style="text-align: center !important;" ><?php echo lang('br_active') ?></th-->
                            <th style="text-align: center !important;"><?php echo lang('br_how_school_name') ?></th>
                            <?php if ($setting[69]->display == 1) { ?>
                                <th style="text-align: center !important;"><?php echo lang('am_want_transport') ?></th>
                            <?php } ?>
                            <?php if ($this->ApiDbname == "SchoolAccUniversitySchools") { ?>
                                <th style="text-align: center !important;"><?php echo lang('er_TeacherName') ?></th>
                            <?php } ?>
                            <?php $query = $this->db->query("select accpet_reg_type,reg_type	 from school_details limit 1")->row_array();
                            if ($query['accpet_reg_type'] != 1) { ?>
                                <th style="text-align: center !important;"><?php echo lang('br_academy_accept') ?></th>
                            <?php } ?>
                            <?php
                            if ($query['accpet_reg_type'] == 2 || $query['reg_type'] == 2 || $query['accpet_reg_type'] == 1) { ?>
                                <th style="text-align: center !important;"><?php echo lang('br_money_accept') ?></th>
                            <?php } ?>
                           
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        
                        foreach ($getStudentR as $Key => $StudentR) {
                            $Num             = $Key + 1;
                            $id              = $StudentR->id;
                            $name            = $StudentR->name;
                            $parent_name     = $StudentR->parent_name;
                            $Reg_Date        = $StudentR->Reg_Date;
                            $father_mobile   = $StudentR->parentmobile;
                            $father_mail     = $StudentR->parent_email;
                            $mother_mobile   = $StudentR->mothermobile;
                            $rowLevelID      = $StudentR->rowLevelID;
                            $Nationality     = $StudentR->nationality;
                            $how_school_name = $StudentR->how_school_name;
                            $IsAccepted      = $StudentR->IsAccepted;
                            $student_NumberID = $StudentR->student_NumberID;
                            $schoolID        = $StudentR->schoolID;
                            $rowID           = $StudentR->rowID;
                            $LevelID         = $StudentR->LevelID;
                            $studyType       = $StudentR->studyType;
                            $ClassTypeId     = $StudentR->ClassTypeId;
                            $status          = $StudentR->status;
                            $note            = $StudentR->note;
                            $status          = $status ? $status : NULL;
                            $rowLevelName    = $StudentR->rowLevelName;
                            $gender          = $StudentR->gender;
                            $transport       = array(1 => lang('no'), 2 => lang('yes'));
                            $want_transport  = $transport[$StudentR->want_transport];
                            $studyTypeMap    = array_column($allStudeType, 'StudyTypeName', 'StudyTypeId');
                            $StudyTypeName   = isset($studyTypeMap[$studyType]) ? $studyTypeMap[$studyType] : null;
                            
                            $IsActiveArray   = array(1 => lang('br_active'), 0 => lang('br_not_active'));
                            $accepted = array(
                                lang('br_request_wating'),
                                lang('br_request_accepted')
                            );
                            $refused = array(
                                lang('br_request_wating'),
                                lang('br_request_refused')
                            );
                            $status_academy = lang('br_academy_request_wating');
                            $status_money   = lang('br_money_request_wating');
                            $query = $this->db->where('RequestID', $StudentR->id)->get('active_request')->result();
                            if ($query != null) {
                                foreach ($query as $row) {
                                    if ($row->NameSpaceID == 87 && $row->IsActive == 1) {
                                        $status_academy = lang('br_academy_request_accepted');
                                    }
                                    if ($row->NameSpaceID == 87 && $row->IsActive == 2) {
                                        $status_academy = lang('br_academy_request_refused');
                                    }
                                    if ($row->NameSpaceID == 85 && $row->IsActive == 1) {
                                        $status_money = lang('br_money_request_accepted');
                                    }
                                    if ($row->NameSpaceID == 85 && $row->IsActive == 2) {
                                        $status_money = lang('br_money_request_refused');
                                    }
                                }
                            }
                        ?>
                            <tr>
                                <td><?php echo $Num; ?></td>
                                <td>
                                    <?php if ($name !== '') {
                                        echo $name . " " . $parent_name;
                                    } else {
                                        echo 'لم تتم الاضافة';
                                    }; ?>
                                </td>
                                <td><?= $StudyTypeName ?></td>

                                <?php if (($this->ApiDbname  == "SchoolAccAndalos")) { ?>
                                    <td>
                                        <?php echo $get_row_level->LevelName; ?>
                                    </td>
                                <?php } ?>
                                <td>
                                    <?php  
                                     echo $rowLevelName;
                                    ?>
                                </td>
                                <td><?= $Reg_Date ?></td>

                                <td><?= $father_mobile ?></td>
                                <td><?= $father_mail  ?></td>


                                <!--<td><?= $mother_mobile ?></td>-->
                                <td>
                                    <?php foreach ($get_nationality as $n) {
                                        if ($n->NationalityId == $Nationality) {
                                            echo $n->NationalityName;
                                        }
                                    } ?>
                                </td>
                                <td>
                                    <?php echo $how_school_name; ?>
                                </td>
                                <?php if ($setting[69]->display == 1) { ?>
                                <td><?= $want_transport ?></td>
                                <?php } ?>
                                <?php if ($this->ApiDbname == "SchoolAccUniversitySchools") { ?>
                                    <td><?php echo $note ?></td>
                                <?php } ?>
                                <!--td>
                                    <?php echo $IsActiveArray[$IsAccepted]; ?>
                                </td-->
                                <?php
                                $query = $this->db->query("select accpet_reg_type,reg_type	 from school_details limit 1")->row_array();
                                if ($query['accpet_reg_type'] != 1) { ?>
                                    <td><?php echo $status_academy; ?></td>
                                <?php } ?>
                                <?php
                                if ($query['accpet_reg_type'] == 2 || $query['reg_type'] == 2 || $query['accpet_reg_type'] == 1) { ?>
                                    <td><?php echo $status_money; ?></td>
                                <?php } ?>
                                
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
        echo '';
    }
    ?>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
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

    $(document).ready(function() {
        $('select[name="school"]').on('change', function() {
            var schoolID = $(this).val();
            var DbName = $('#DbName').val();
            if (schoolID) {
                $.ajax({
                    url: '<?php echo site_url(); ?>' + '/admin/Report_Register/get_all_year/' + schoolID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        var element = $('select[name="GetYear"]');
                        element.empty();
                        element.append(
                            '<option value="" ><?php echo lang('am_choose_select'); ?></option>'
                        );
                        $.each(data, function(key, value) {
                            // if((data[1]!=undefined&& value.IsNextYear===true)||(data[1]==undefined)){
                            element.append('<option value="' + value.id + '">' +
                                value.name + '</option>');
                            // }

                        });
                    }

                });
            } else {
                $('select[name="GetYear"]').empty();
            }
        });



    });
</script>
