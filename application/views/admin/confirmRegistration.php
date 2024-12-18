<style>
	.bootstrap-select {
		display: none;
	}
</style>

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
					title: '<?php echo lang('am_new_student_confirm_Code'); ?>'
				},
				{
					extend: 'excel',
					title: '<?php echo lang('am_new_student_confirm_Code'); ?>'

				},
				{
					extend: 'copy',
					title: '<?php echo lang('am_new_student_confirm_Code'); ?>'

				},
			]

		});

	});
</script>
<div class="clearfix"></div>
<div class="content margin-top-none container-page">
	<div class="col-lg-12">
		<div class="block-st">
			<div class="sec-title">
				<h2><?php echo lang('am_new_student_confirm_Code'); ?></h2>
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

			<!----- Add title -------->
			<form method="post" action="<?php echo site_url('admin/Report_Register/confirmRegistration'); ?>">
				<div class="row">
					
					<div class="form-group col-lg-3">

						<label class="control-label col-lg-12"><?php echo lang('br_school_name'); ?></label>

						<div class="col-lg-12">

							<select name="school" id="school" class="form-control" required>
								<option value=""></option>
								<?php if ($get_schools != 0) {

									foreach ($get_schools as $School) {

										$SchoolId       = $School->SchoolId;

										$SchoolName     = $School->SchoolName;

										$school_per     = array_column($GetBranches, 'ID_ACC');

										if (in_array($SchoolId, $school_per)) {

								?>

											<option value="<?php echo $SchoolId; ?>" <?php if ($SchoolId == $SchoolID) {
																							echo "selected";
																						} ?>><?php echo $SchoolName; ?>
											</option>

								<?php }
									}
								} ?>

							</select>

						</div>

					</div>

					
					
					<div class="form-group col-lg-3">

						<label class="control-label col-lg-12"><?php echo lang('br_year'); ?></label>

						<div class="col-lg-12">

							<select name="GetYear" id="GetYear" class="form-control" required>
								<option value=""></option>
								<?php

								if ($SchoolID) {

									$isNextYear = 0;

									foreach ($getAllYear as $year) {

										$ID             = $year['id'];

										$YearName       = $year['name'];

										$schoolId       = $year['schoolId'];

										$IsNextYear     = $year['isNextYear'];

										$isClosed      = $year['isClosed'];
										if ($SchoolID == $schoolId) {

											if (($ID == $Get_Year) && $isClosed == 0) {
												$isNextYear = 1;
											}

								?>

											<option value="<?php echo $ID; ?>" <?php if ($ID == $Get_Year) {
																					echo "selected";
																				} ?>>
												<?php echo $YearName; ?></option>

								<?php }
									}
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

					<div class="col-lg-2" style="margin-top: 34px;">
						<div>
							<input type="submit" class="btn btn-success" name="save" id="save" value="<?php echo lang('br_btn_show'); ?> " />
							
						</div>
					</div>
					<!--</div>-->
				</div>
		</div>
	</div>
	</form>
	
</div>
</div>

<div class="clearfix"></div>

<div class="clearfix"></div>
<div class="panel panel-danger">

	<div class="panel-body no-padding">

		<?php if (is_array($getStudentR)) { ?>
            <form method="post" action="<?php echo site_url('admin/Report_Register/updateConfirmRegistration'); ?>">
			<table id="" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th style="text-align: center !important;">#</th>
						<th style="text-align: center !important;"><?php echo lang('er_StudentName') ?></th>
						<th style="text-align: center !important;"><?php echo lang('am_studeType') ?></th>
						<th style="text-align: center !important;"><?php echo lang('br_row_level') ?></th>
						<th style="text-align: center !important;"><?php echo lang('am_Check_Code_student') ?></th>
						<th style="text-align: center !important;"><?php echo lang('er_Nationality') ?></th>
						<th style="text-align: center !important;"><?php echo lang('br_BirhtDate') ?></th>
						<th style="text-align: center !important;"><?php echo lang('am_Age')  ?></th>
						<th style="text-align: center !important;"><?php echo lang('br_st_fa_mobile') ?></th>
						<th style="text-align: center !important;"><?php echo lang('br_st_mo_mobile') ?></th>
						<th style="text-align: center !important;"><?php echo lang('am_new_student_confirm_Code') ?> <input type="checkbox" id="check_all_add"></th>

					</tr>
				</thead>

				<tbody>
					<?php
					foreach ($getStudentR as $Key => $StudentR) {
						$date               = new DateTime($StudentR->birthdate);
						$date1              = new DateTime(date("Y-m-d"));
						$interval           = $date1->diff($date);
						$Num		        = $Key + 1;
						$id 	            = $StudentR->id;
						$name 	            = $StudentR->FullName;
						$parent_name        = $StudentR->parentname;
						$Rowid 	            = $StudentR->rowLevelID;
						$Nationality        = $StudentR->nationality;
						$date               = $StudentR->birthdate;
						$parent_mobile      = $StudentR->parentmobile;
						$mother_mobile      = $StudentR->mothermobile;
						$code               = $StudentR->check_code;
						$ParentNumberID     = $StudentR->ParentNumberID;
						$student_NumberID   = $StudentR->student_NumberID;
						$notes              = $StudentR->note;
						$parent_mobile2     = $StudentR->parent_mobile2;
						$interview_gate     = $StudentR->interview_gate;
						$interview_place    = $StudentR->interview_place;
						$studyType          = $StudentR->studyType;
						$studyTypeMap       = array_column($allStudeType, 'StudyTypeName', 'StudyTypeId');
                        $StudyTypeName      = isset($studyTypeMap[$studyType]) ? $studyTypeMap[$studyType] : null;
						
						
					?>
						<tr>
							<td><?php echo $Num; ?></td>
							<td><?php echo $name; ?></td>
							<td><?= $StudyTypeName ?></td>
							<td>
								<?php foreach ($getRowLevel as $p) {
									if ($p->RowLevelId == $Rowid) {
										echo $p->LevelName . " " . $p->RowName;
									}
								} ?>
							</td>
							<td><?= $code ?></td>
							<td>
								<?php foreach ($get_nationality as $n) {
									if ($n->NationalityId == $Nationality) {
										echo $n->NationalityName;
									}
								} ?>
							</td>
							<td><?= $date ?></td>
							<td><?= $interval->y . "year-" . $interval->m . "month-" . $interval->d . "day-" ?></td>
							<td><?= $parent_mobile ?></td>
							<td><?= $mother_mobile ?></td>
                            <td><input type="checkbox" class="check_add" name="regId[]" value="<?php echo $id ;?>"></td>
							
                        </tr>


                    <?php } ?>
    </tbody>
    </table>
    <button class="btn btn-success pull-left" type="submit"><?php echo lang("send sms");?></button>
</form>
</div>
</div>

<?php } else {
			echo "";
		} ?>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>

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
				// url: '<?php echo lang("api_link"); ?>' + '/api/Years/' + DbName + '/GetOpenedYearsBySchoolId',
				url: '<?php echo site_url(); ?>' + '/admin/Report_Register/get_all_year/'+schoolID,
				type: "GET",
				dataType: "json",
				success: function(data) {
					var element = $('select[name="GetYear"]');
					element.empty();
					element.append(
						'<option value="" ><?php echo lang('am_choose_select'); ?></option>');
					$.each(data, function(key, value) {
						//   if((data[1]!=undefined&& value.IsNextYear===true)||(data[1]==undefined)){
						if (schoolID == value.schoolId) {
							element.append('<option value="' + value.id + '">' + value
								.name + '</option>');
						}

					});
				}

			});
		} else {
			$('select[name="GetYear"]').empty();
		}
	});



	//   });
</script>



<script type="text/javascript">

   $(document).ready(function(){

	   

	  $("#check_all_add").on("click", function() {

       $('.check_add').prop("checked", $(this).prop("checked"));

     });

});

</script>
