<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script>
<!--<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.js"></script>-->
<script type="text/javascript" language="javascript" class="init">
    $(function() {
        $('#example').dataTable();
    });
</script>
<div class="clearfix"></div>

<div class="content margin-top-none container-page">

    <div class="col-lg-12">

        <div class="block-st">

            <div class="sec-title">

                <h2><?php echo lang('ra_statistical_report_for_admission'); ?> </h2>

            </div>
            <form method="post" action="<?php echo site_url('admin/Report_Register/count_student_register/' . $reg_type); ?>">
                <input type="hidden" name="reg" value="<?= $reg_type; ?>">
                <div class="form-group col-lg-3">

                    <label class="control-label col-lg-4"><?php echo lang('br_school_name'); ?></label>

                    <div class="col-lg-8">

                        <select name="school" id="school" class="form-control selectpicker" required>
                            <option value=""><?php echo lang('am_choose_select'); ?></option>
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
                                                                                } ?>><?php echo $SchoolName; ?></option>

                            <?php 
                                }}
                            } ?>

                        </select>

                    </div>

                </div>

                <!----- Edit title -------->

                <div class="form-group col-lg-3">

                    <label class="control-label col-lg-4"><?php echo lang('br_year'); ?></label>

                    <div class="col-lg-8">

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

						<label class="control-label col-lg-4"><?php echo lang('Semester'); ?></label>

						<div class="col-lg-8">

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
                        <input type="submit" class="btn btn-success" name="save" id="save" value="<?php echo lang('br_btn_show'); ?> " />
                    </div>

                </div>
        </div>
    </div>
    </form>

    <div class="clearfix"></div>
    <div class="panel panel-danger">

        <div class="panel-body no-padding">


            <table id="example" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="text-align: center !important;">#</th>

                        <th style="text-align: center !important;"><?php echo lang('br_level'); ?></th>
                        <th style="text-align: center !important;"><?php echo lang('am_studeType'); ?></th>
                        <th style="text-align: center !important;"><?php echo lang('br_Num'); ?></th>
                        <th style="text-align: center !important;"><?php echo lang('Accepted_requests'); ?></th>
                        <th style="text-align: center !important;"><?php echo lang('Pending_orders'); ?></th>
                        <th style="text-align: center !important;"><?php echo lang('Rejected_requests'); ?></th>


                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($getdate as $Key => $StudentR) {
                        $Num                   = $Key + 1;
                        $count_student         = $StudentR->count_student;
                        // $semester              = $StudentR->semester;
                        $data['rowLevelID']    = $StudentR->rowLevelID;
                        $data['studyType']     = $StudentR->studyType;
                        $data['SchoolID']      = $SchoolID;
                        $data['Get_Year']      = $Get_Year;
                        $data['reg_type']      = $reg;
                        $data['semester']      = $semester;
                        $count_student_accepted= $this->Report_Register_model->count_student_register_accepted($data);
                        $count_student_refused = $this->Report_Register_model->count_student_register_refused($data);
                        $count_student_pined   = $this->Report_Register_model->count_student_register_pined($data);
                        if ($count_student_accepted == "") {
                            $count_student_accepted = 0;
                        }
                        if ($count_student_refused == "") {
                            $count_student_refused = 0;
                        }
                        if ($count_student_pined == "") {
                            $count_student_pined = 0;
                        }


                    ?>
                        <tr>
                            <td><?php echo $Num; ?></td>


                            <td>
                                <?php echo $StudentR->rowLevelName;?>
                            </td>
                            <td>
                                <?php foreach ($allStudeType as $val) { if ($val->StudyTypeId == $StudentR->studyType) { echo $val->StudyTypeName; } }?>
 
                            </td>

                            <td>
                                <?php echo $count_student; ?>
                            </td>
                            <td>
                                <?php echo $count_student_accepted;  ?>
                            </td>

                            <td><?php echo $count_student_pined; ?></td>
                            <td><?php echo $count_student_refused; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
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
                $('select[name="' + columnName + '"]').append('<option value="' + columnID + '">' + columnString + '</option>');
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
                            element.append('<option value="" ><?php echo lang('am_choose_select'); ?></option>');
                            $.each(data, function(key, value) {
                                // if((data[1]!=undefined&& value.IsNextYear===true)||(data[1]==undefined)){
                                element.append('<option value="' + value.id + '">' + value.name + '</option>');
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