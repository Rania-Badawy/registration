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
					title: '<?php echo lang('br_check_st_register'); ?>'
				},
				{
					extend: 'excel',
					title: '<?php echo lang('br_check_st_register'); ?>'

				},
				{
					extend: 'copy',
					title: '<?php echo lang('br_check_st_register'); ?>'

				},
			]

		});

	});
</script>
<?php $per=check_group_permission_page(); ?>
<div class="clearfix"></div>
<div class="content margin-top-none container-page">
	<div class="col-lg-12">
		<div class="block-st">
			<div class="sec-title">
				<h2><?php echo lang('br_check_st_register'); ?></h2>
				<?php if ($this->ApiDbname == 'SchoolAccAndalos') { ?>
				<a class="btn btn-success pull-left" href="<?php echo site_url('admin/Report_Register/confirmRegistration'); ?>"><?php echo lang('am_new_student_confirm_Code'); ?></a>
			    <?php } ?>
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
			<form method="post" action="<?php echo site_url('admin/Report_Register/index'); ?>">
				<div class="row">
					<!--<div class="row">-->
					<div class="form-group col-lg-3">

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
																						} ?>><?php echo $SchoolName; ?>
											</option>

								<?php 
									}}
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
							<a role="button" href="<?= site_url('admin/Report_Register/student_register_brother') ?>" class="btn btn-primary"><?php echo lang('brothers'); ?></a>
						</div>
					</div>
					<!--</div>-->
				</div>
		</div>
	</div>
	</form>
	<div class="form-group col-lg-1">
		<div class="row">

		</div>
	</div>
</div>
</div>

<script>
	function show_report1()

	{


		window.location = "<?php echo site_url('admin/Report_Register/student_register_brother'); ?> 

	}
</script>

<?php $setting = $this->db->query("SELECT * FROM `form_setting` WHERE `form_type` =1")->result(); ?>

<div class="clearfix"></div>

<div class="clearfix"></div>
<div class="panel panel-danger">

	<div class="panel-body no-padding">

		<?php if (is_array($getStudentR)) { ?>
			<table id="example" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th style="text-align: center !important;">#</th>

						<!--<th style="text-align: center !important;" ><?php echo lang('br_father') ?></th>-->
						<th style="text-align: center !important;"><?php echo lang('er_StudentName') ?></th>
						<th style="text-align: center !important;"><?php echo lang('am_studeType') ?></th>
						<th style="text-align: center !important;"><?php echo lang('br_row_level') ?></th>
						<th style="text-align: center !important;"><?php echo lang('am_Check_Code_student') ?></th>
						<th style="text-align: center !important;"><?php echo lang('er_Nationality') ?></th>
						<th style="text-align: center !important;"><?php echo lang('br_BirhtDate') ?></th>
						<th style="text-align: center !important;"><?php echo lang('am_Age')  ?></th>
						<th style="text-align: center !important;"><?php echo lang('br_st_fa_mobile') ?></th>
						<th style="text-align: center !important;"><?php echo lang('br_father_NumberID') ?></th>
						<th style="text-align: center !important;"><?php echo lang('br_student_NumberID') ?></th>
						<th style="text-align: center !important;"><?php echo lang('br_st_mo_mobile') ?></th>
						<?php if ($setting[69]->display == 1 && $this->ApiDbname != "SchoolAccAlHasan") { ?>
						<th style="text-align: center !important;"><?php echo lang('am_want_transport') ?></th>
						<?php } ?>
						<?php if ($setting[60]->display == 1 && $this->ApiDbname == "SchoolAccAlHasan") { ?>
						<th style="text-align: center !important;"><?php echo lang('allow_photography') ?></th>
						<?php } ?>
						<?php if ($isNextYear == 1) { ?>
							<th style="text-align: center !important;"> <?php echo lang('interview_date') ?> </th>
							<th style="text-align: center !important;">المقابله </th>
						<?php } ?>
						<?php if ($this->ApiDbname == "SchoolAccDigitalCulture") { ?>
							<th style="text-align: center !important;"> <?php echo lang('br_discount_code') ?> </th>
						<?php } ?>
						<!--<th style="text-align: center !important;" >تقرير لتاريخ الاختبار </th>-->
						<?php $query = $this->db->query("select accpet_reg_type,reg_type	 from school_details limit 1")->row_array();
						if ($query['accpet_reg_type'] != 1) { ?>

							<th style="text-align: center !important;"><?php echo lang('br_academy_accept') ?></th>
						<?php } ?>
						<?php if ($query['accpet_reg_type'] == 2 || $query['reg_type'] == 2 ||$query['accpet_reg_type'] == 1) { ?>
							<th style="text-align: center !important;"><?php echo lang('br_money_accept') ?></th>
						<?php } ?>
						<th style="text-align: center !important;"><?php echo lang('br_page_view') ?></th>
						<!--<th style="text-align: center !important;" >الاخوه</th>-->

					</tr>
				</thead>

				<tbody>
					<?php
					foreach ($getStudentR as $Key => $StudentR) {
						$date = new DateTime($StudentR->birthdate);
						$date1 = new DateTime(date("Y-m-d"));
						$interval = $date1->diff($date);
						$Num		       = $Key + 1;
						$id 	            = $StudentR->id;
						$name 	            = $StudentR->FullName;
						$parent_name        = $StudentR->parentname;
						$Rowid 	            = $StudentR->rowLevelID;
						$Nationality        = $StudentR->nationality;
						$IsAccepted         = $StudentR->IsAccepted;
						$date               = $StudentR->birthdate;
						$parent_mobile      = $StudentR->parentmobile;
						$mother_mobile      = $StudentR->mothermobile;
						$code               = $StudentR->check_code;
						$ParentNumberID     = $StudentR->ParentNumberID;
						$student_NumberID   = $StudentR->student_NumberID;
						$interview_date     = $StudentR->InterviewDate;
						$interview_type     = $StudentR->interview_type;
						$is_attend          = $StudentR->is_attend;
						$duration           = $StudentR->duration;
						$notes              = $StudentR->note;
						$parent_mobile2     = $StudentR->parent_mobile2;
						$interview_gate     = $StudentR->interview_gate;
						$interview_place    = $StudentR->interview_place;
						$studyType          = $StudentR->studyType;
						$schoolID           = $StudentR->schoolID;
                        $rowID              = $StudentR->rowID;
                        $LevelID            = $StudentR->LevelID;
                        $ClassTypeId        = $StudentR->ClassTypeId;
                        $status             = $StudentR->status;
						$rowLevelName       = $StudentR->rowLevelName;
						$gender             = $StudentR->gender;
						$transport          = array(1 => lang('no'), 2 => lang('yes'));
                        $want_transport     = $transport[$StudentR->want_transport];
						$photo              = array(0 => lang('no'), 1 => lang('yes'));
						$allowphoto         = $photo[$StudentR->allowphoto];
						$query_attend       = $this->db->query("select * from zoom_meetings where reg_id=" . $id . " order by id desc")->row_array();
						$min                = $query_attend['duration'];
						$endTime            = date('Y-m-d H:i:s', strtotime($query_attend['start_time']) + $min * 60);
						$starttime          = date('Y-m-d H:i:s', strtotime($query_attend['start_time']));
						$date_now           = date('Y-m-d H:i:s', strtotime($date_now));
					
						$studyTypeMap       = array_column($allStudeType, 'StudyTypeName', 'StudyTypeId');
                        $StudyTypeName      = isset($studyTypeMap[$studyType]) ? $studyTypeMap[$studyType] : null;
						if ($student_NumberID) {
							$get_data        = $this->Report_Register_model->student_register_brothers($ParentNumberID, $student_NumberID);
						}
						$last_date        = $this->Report_Register_model->register_date($id);
						$IsActiveArray    = array(1 => lang('br_active'), 0 => lang('br_not_active'));
						$accepted = array(
							lang('br_request_wating'),
							lang('br_request_accepted')
						);
						$refused = array(
							lang('br_request_wating'),
							lang('br_request_refused')
						);
						$status_academy = lang('br_request_wating');
						$status_money   = lang('br_request_wating');
						$query = $this->db->query("select active_request.* ,contact.Name as EmpName from active_request
                                                       left join contact on active_request.EmpID=contact.ID  where RequestID =" . $StudentR->id . "")->result();
						if ($query != null) {
							foreach ($query as $row) {
								if ($row->NameSpaceID == 87 && $row->IsActive == 1) {
									$status_academy = lang('br_request_accepted');
									$EmpName1        = $row->EmpName;
								}
								if ($row->NameSpaceID == 87 && $row->IsActive == 2) {
									$status_academy = lang('br_request_refused');
								}
								if ($row->NameSpaceID == 85 && $row->IsActive == 1) {
									$status_money = lang('br_request_accepted');
									$EmpName2     = $row->EmpName;
								}
								if ($row->NameSpaceID == 85 && $row->IsActive == 2) {
									$status_money = lang('br_request_refused');
								}
							}
						}
					?>
						<tr>
							<td><?php echo $Num; ?></td>
							
							<td>
								<?php if ($name !== '') {
									echo $name;
								} else {
									echo 'لم تتم الاضافة';
								}; ?>
							</td>
							<td><?= $StudyTypeName ?></td>

							<td><?php echo $rowLevelName ; ?></td>
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
							<td><?= $ParentNumberID ?></td>
							<td><?= $student_NumberID ?></td>
							<td><?= $mother_mobile ?></td>
							<?php if ($setting[69]->display == 1 && $this->ApiDbname != "SchoolAccAlHasan") { ?>
							<td><?= $want_transport ?></td>
							<?php } ?>
							<?php if ($setting[60]->display == 1 && $this->ApiDbname == "SchoolAccAlHasan") { ?>
							<td><?= $allowphoto ?></td>
							<?php } ?>
							<!--<td><?= $last_date[0]->Date ?></td>-->
							<?php if ($isNextYear == 1) { ?>
								<td>
									<button type="button" class="allowedAddedButton btn btn-info btn-rounded" data-toggle="modal" data-target="#view-data-<?= $Num ?>"><?php if ($interview_date != "") {
																																											echo date("Y-m-d H:i", strtotime($interview_date));
																																										} else echo lang('interview_date'); ?>
									</button>
									<!--<a    href="<?= site_url('admin/Report_Register/register_form_date/' . $id . '') ?>" >-->
									<!--     <?= $last_date[0]->Date ?> <i class="fa fa-edit"></i>-->
									<!--  </a>-->
									<div id="view-data-<?= $Num ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header" style="background: #1173bb;--primary-hover:">
                                                <h4 class="modal-title" id="myModalLabel" style="color: #ffffff;"><?php echo lang('interview_attend') ?> </h4>
                                            </div>
												<form action="<?php echo site_url('admin/Report_Register/add_register_attend/' . $id . "/" . "1"); ?>" method="post">
													<div class="modal-body">
														<div class="form-group col-lg-4">
															<label class="control-label col-lg-4"><?php echo lang('am_date'); ?></label>
															<div class="col-lg-8">

																<input type="datetime-local" name="interview_date" class="form-control" <?php if ($interview_date != "") { ?>value="<?php echo date("Y-m-d\TH:i:s", strtotime($interview_date)); ?>" <?php } ?> required />
															</div>
														</div>
														<div class="form-group col-lg-4">
															<label class="control-label col-lg-4"><?php echo lang('time_per_minute'); ?></label>
															<div class="col-lg-8">
																<input type="number" onkeypress="return onlyNumberKey(event)" name="duration" class="form-control" value="<?php echo $duration; ?>" min="0" required />
															</div>
														</div>
														<?php if ($this->ApiDbname == 'SchoolAccGheras') { ?>
															<div class="form-group col-lg-4">
																<label class="control-label col-lg-4"><?php echo lang('place_interiew'); ?></label>
																<div class="col-lg-8">
																	<input type="text" name="interview_place" class="form-control" value="<?php echo $interview_place; ?>" required />
																</div>
															</div>
															<div class="form-group col-lg-4">
																<label class="control-label col-lg-4"><?php echo lang('gate_interiew'); ?></label>
																<div class="col-lg-8">
																	<input type="text" name="interview_gate" class="form-control" value="<?php echo $interview_gate; ?>" required />
																</div>
															</div>
														<?php } ?>
														<div class="form-group">
															<label class="control-label col-lg-4"><?php echo lang('attend'); ?></label>
															<div class="controls">
																<div class="col-lg-4">
																	<label class="control-radio"> <?php echo lang('Yes') ?>
																		<input type="radio" name="attend" value="نعم" <?php if ($is_attend == "نعم") { ?> checked="checked" <?php } ?> />
																		<div class="control_indicator_radio"></div>
																	</label>
																</div>

																<div class="col-lg-4">
																	<label class="control-radio"><?php echo lang('no'); ?>
																		<input type="radio" name="attend" value="لا" <?php if ($is_attend == "لا") { ?> checked="checked" <?php } ?> />
																		<div class="control_indicator_radio"></div>
																	</label>
																</div>
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-lg-4"><?php echo lang('meeting_type'); ?></label>
															<div class="controls">
																<div class="col-lg-4">
																	<label class="control-radio"> zoom
																		<input type="radio" name="interview_type" value="1" <?php if ($interview_type == "1") { ?> checked="checked" <?php } ?> />
																		<div class="control_indicator_radio"></div>
																	</label>
																</div>

																<div class="col-lg-4">
																	<label class="control-radio">school
																		<input type="radio" name="interview_type" value="2" <?php if ($interview_type == "2") { ?> checked="checked" <?php } ?> />
																		<div class="control_indicator_radio"></div>
																	</label>
																</div>
															</div>
														</div> 
														<div class="form-group col-lg-4">
															<label class="control-label col-lg-4"><?php echo lang('am_notes'); ?>
															</label>
															<div class="col-lg-8">
																<textarea name="notes" class="form-control"><?php echo $notes; ?></textarea>
															</div>
														</div>
														<?php $query = $this->db->query("SELECT time_zone FROM school_details WHERE ID = '" . $this->session->userdata('SchoolID') . "'  ")->row_array(); ?>
														<input type="hidden" name="timezone" value=<?= $query['time_zone']; ?>>


														<div class="modal-footer noborder">
															<input type="button" class="col-lg-2 btn btn-danger" data-dismiss="modal" value="<?php echo lang('am_close'); ?>">
															<input type="submit" class="col-lg-2 text-right btn btn-info" value="<?php echo lang('am_save'); ?>">
														</div>
												</form>
											</div>
										</div>
									</div>
	</div>
</div>
</td>
<td>
<?php
	$query = $this->db->query("select ID,GroupID,Type from contact where ID =" . $this->session->userdata('id') . "")->row_array();
	// print_r($date_now."/////".$endTime."///////".$starttime);die;
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
<?php } ?>
<?php if ($this->ApiDbname == "SchoolAccDigitalCulture") { ?>
	<td><?= $parent_mobile2 ?></td>
<?php } ?>
<?php
						$query = $this->db->query("select accpet_reg_type,reg_type	 from school_details limit 1")->row_array();
						if ($query['accpet_reg_type'] != 1) { ?>
	<td>
		<? if ($query['accpet_reg_type'] == 3) {
								echo  $status_money . "  " . $EmpName2;
							} else {
								echo   $status_academy . "  " . $EmpName1;
							}
		?>
	</td>
<?php } ?>
<?php if ($query['accpet_reg_type'] == 2 || $query['reg_type'] == 2 ||$query['accpet_reg_type'] == 1) { ?>
	<td><?= $status_money  . "  " . $EmpName2; ?></td>
<?php } ?>
<td style="display: grid;">
	<!--- --EDIT----->

	<!-- <a onclick="$('#person_mobile').val(<?= $StudentR->person_mobile ?>); $('#txtSms').val('');" href="#" role="button" class="btn btn-warning btn-rounded" data-toggle="modal" data-target="#msg"> <?php echo lang('br_send_sms_table') ?> <i class="fa fa-envelope"></i> </a>-->
	<!--<br>-->
	<a role="button" href="<?= site_url('admin/Report_Register/view_student_register/' . $id . "/" . $SchoolID . "/" . $Get_Year . "/" . $isNextYear) ?>" class="btn btn-success btn-rounded">
		<?php echo lang('br_page_view') ?> <i class="fa fa-edit"></i>
	</a>
	<?php if ($isNextYear == 1 && $per['PermissionEdit']==1) { ?>
		<a role="button" href="<?= site_url('admin/Report_Register/get_student_register/' . $id . '') ?>" class="btn btn-primary btn-rounded">
			<?php echo lang('br_edit') ?> <i class="fa fa-edit"></i>
		</a>
	<?php } ?>
	<?php if ($get_data['student_name'] != NULL) { ?>

		<button type="button" class="allowedAddedButton btn btn-info btn-rounded" data-toggle="modal" data-target="#view-rating-<?= $Num ?>">الاخوه</button>
	<?php } else {
						} ?>
	<div class="clearfix"></div>
	<?php if ($isNextYear == 1) { ?>
		<?php if ($this->ApiDbname != "SchoolAccAndalos" && $per['PermissionDelete']==1) { ?>
			<a role="button" href="<?= site_url('admin/Report_Register/delete_student_register/' . $id . '') ?>" class="btn btn-danger btn-rounded">
				<?php echo lang('br_delete') ?> <i class="fa fa-remove"></i>
		<?php }
						} ?>


</td>

</tr>

<div id="view-rating-<?= $Num ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">عرض الاخوه المسجلين بالمدرسه
					<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true" rtl>×</button>-->
				</h4>
			</div>

			<div class="modal-body">
				<div class="form-group">
					<label>الاسم</label>
					<div class="controls">
						<?php echo $get_data['student_name'];

						?>
					</div>
				</div>
				<div class="form-group">
					<label>المرحله</label>
					<div class="controls">
						<?php echo $get_data['row_name']; ?>
					</div>
				</div>

			</div>
			<div class="modal-footer noborder">
				<button type="button" class="col-lg-2 text-right" class="btn btn-danger" data-dismiss="modal"><?php echo lang('cancel')  ?></button>
			</div>

		</div>
	</div>
</div>
<?php
					}
?>
</tbody>
</table>
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
<div class="modal fade" id="msg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" style="margin-top: 0; margin-right: 30px"><?= lang('br_send_sms_table') ?>
				</h4>
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
					<button type="submit" class="btn btn-success"><?= lang('br_send_button') ?> <i class="fa fa-paper-plane"></i></button>
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
	// When the document is ready

	$(document).ready(function() {
		// $('#DayDateFrom').datepicker({format: "yyyy-mm-dd" });
		// $('#DayDateTo').datepicker({format: "yyyy-mm-dd" });
		$('.selectpicker').selectpicker('refresh');
		$(".datepicker tbody").click(function() {
			$('.datepicker').hide();
		});

		//////////////////////////////////////////////////////////////////////////////////////////////////////////

		////////////////////////////
		$(".selectGroup").prop("disabled", true);
		$("#level").prop("disabled", false);
		<?php
		if ($level != 0) { ?>
			$("#RowLevel").prop("disabled", false);
		<?php }

		?>

		//////////////////////////////////////////////////////////////////////////
		$('select[name="level"]').on('change', function() {

			var stateID = $(this).val();
			if (stateID) {
				$.ajax({
					url: '<?php echo site_url(); ?>' +
						'/admin/permission/get_RowLevel_without_student/' + stateID,
					type: "GET",
					dataType: "json",
					success: function(data) {
						clearColumns("#RowLevel");
						$.each(data, function(key, value) {
							$('select[name="RowLevel"]').append('<option value="' +
								value.RowLevelID + '">' + value.LevelName + '--' +
								value.RowName + '</option>');
						});
						$("#level").prop("disabled", false);
						$("#RowLevel").prop("disabled", false);
						// $("#subject").prop("disabled", false );
					}


				});
			} else {
				$('select[name="RowLevel"]').empty();
			}
		});


	});

	function onlyNumberKey(evt) {

		// Only ASCII charactar in that range allowed 
		var ASCIICode = (evt.which) ? evt.which : evt.keyCode
		if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
			return false;
		return true;
	}
</script>