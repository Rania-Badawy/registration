<?php
  $query_hr = $this->db->query("SELECT `IN_ERP` FROM `school_details` ")->row_array();
$get_api_setting = $this->setting_model->get_api_setting();
$this->ApiDbname = $get_api_setting[0]->{'ApiDbname'};
$ApiDbname

?>

<h4 class="modal-title"> <?= $ContactName  ?> </h4>
<?php if (!empty($GroupName)) {
?>
	<h4 class="modal-title"> <?= lang("br_add_emp_group_name") . '&nbsp;&nbsp;' . $GroupName;  ?> </h4>
<?php
}
?>

<div class="form-group col-lg-6">
	<label for="multiple-label-example" class="label-control col-lg-2"><?php echo lang('br_Branches'); ?></label>
	<div class="col-lg-8">
		<select multiple data-placeholder="<?php echo lang('br_Branches'); ?>" class="selectpicker22 show-tick form-control" data-live-search="true" name="Branches[]" id="Branches">
		 <option value=""><?=lang('am_select')?></option>
                  <?php 
										if ($get_schools) {
											foreach ($get_schools as $school) {
										?>
                                            <option value="<?=$school->SchoolId?>" <?php  if(is_array($Branch))	{	if(in_array($school->SchoolId , $Branch)){echo 'selected';}	}?>><?=$school->SchoolName?></option>
                                            <?php
											}
										}
										?>
                </select>
	</div>
</div>

<!-- <php 	if($query_hr['IN_ERP'] ==1) {  ?> -->
	<div class="form-group col-lg-6">
		<label for="multiple-label-example" class="label-control col-lg-2"><?php echo lang('class_type'); ?></label>
		<div class="col-lg-8">
			<select multiple data-placeholder="<?php echo lang('class_type'); ?>" class="selectpicker22 show-tick form-control" data-live-search="true" name="class_type[]" id="class_type">
				<?php
				if ($GetClassType) {
					foreach ($GetClassType as $Key => $Type) {

						$ID   = $Type->ClassTypeId;
						$Name = $Type->ClassTypeName;
				?>
						<option value="<?php echo $ID; ?>" <?php if (is_array($ClassType)) {
																if (in_array($ID, $ClassType)) {
																	echo 'selected';
																}
															} ?>><?php echo $Name; ?></option>
				<?php
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group col-lg-6">
		<label for="multiple-label-example" class="label-control col-lg-2"><?php echo lang('am_studeType'); ?></label>
		<div class="col-lg-8">
			<select multiple data-placeholder="<?php echo lang('am_studeType'); ?>" class="selectpicker22 show-tick form-control" data-live-search="true" name="study_type[]" id="study_type">
				<?php
				if ($GetStudyType) {
					foreach ($GetStudyType as $Key => $Type) {

						$ID   = $Type->StudyTypeId;
						$Name = $Type->StudyTypeName;
				?>
						<option value="<?php echo $ID; ?>" <?php if (is_array($StudyType)) {
																if (in_array($ID, $StudyType)) {
																	echo 'selected';
																}
															} ?>><?php echo $Name; ?></option>
				<?php
					}
				}
				?>
			</select>
		</div>
	</div>
<!-- <php  } else{ ?>

<div class="form-group col-lg-6">
		<label for="multiple-label-example" class="label-control col-lg-2"><php echo lang('class_type'); ?></label>
		<div class="col-lg-8">
			<select multiple data-placeholder="<php echo lang('class_type'); ?>" class="selectpicker22 show-tick form-control" data-live-search="true" name="class_type[]" id="class_type">
			<option  value="1" <php if (is_array($ClassType)) {
																if (in_array(1, $ClassType)) {
																	echo 'selected';
																}
															} ?>> <php echo lang('am_Boys'); ?></option>
			<option   value="2" <php if (is_array($ClassType)) {
																if (in_array(2, $ClassType)) {
																	echo 'selected';
																}
															} ?>><php echo lang('am_girls'); ?></option>
			</select>
		</div>
	</div>
	<div class="form-group col-lg-6">
		<label for="multiple-label-example" class="label-control col-lg-2"><php echo lang('am_studeType'); ?></label>
		<div class="col-lg-8">
			<select multiple data-placeholder="<php echo lang('am_studeType'); ?>" class="selectpicker22 show-tick form-control" data-live-search="true" name="study_type[]" id="study_type">
				<option  value="1" <php if (is_array($StudyType)) {
																if (in_array(1, $StudyType)) {
																	echo 'selected';
																}
															} ?>> <php echo lang('general'); ?></option>
			</select>
		</div>
	</div>

<php } ?> -->

<?php if ($GroupID == 24 || $GroupID == 98) { ?>
	<div class="form-group col-lg-6">
		<label for="multiple-label-example" class="label-control col-lg-2"><?php echo lang('br_type'); ?></label>
		<div class="col-lg-8">
			<select data-placeholder="<?php echo lang('br_type'); ?>" class="selectpicker22 show-tick form-control" data-live-search="true" name="reg_type" id="reg_type">
			    <option value="0" ><?php echo lang('am_select'); ?> </option>
			    <option value="87" <?php if ($NameSpaceID == 87) { ?>selected <?php } ?>><?php echo lang('br_academy_accept'); ?> </option>
				<option value="85" <?php if ($NameSpaceID == 85) { ?>selected <?php } ?>><?php echo lang('br_money_accept'); ?> </option>
			</select>
		</div>
	</div>
<?php } ?>
<!-------------------------------Type---------------------------------------------->



<div id="level_div" <?php if ($Type == 1 || $Type == 0) {
						echo 'style="display:block;"';
					} else {
						echo 'style="display:none;"';
					} ?>>
	<div class="form-group col-lg-6">
		<label for="multiple-label-example " class="label-control col-lg-2"><?php echo lang('br_level'); ?></label>
		<div class="col-lg-8">
	 <select multiple data-placeholder="<?php echo lang('br_level'); ?>"   class="selectpicker22 show-tick form-control" data-live-search="true" name="level[]"  id="level">
     <?php 
										if ($row_level) {
											foreach ($row_level as $level) {
										?>
                                            <option value="<?=$level->LevelId?>" <?php if($Type == 1 && in_array( $level->LevelId ,$PerType)){echo 'selected' ;} ?>><?=$level->LevelName?></option>
                                            <?php
											}
										}
										?>
                </select>
		</div>
	</div>
</div>







</div>
</div>
</div>
<script>
	$('.selectpicker22').selectpicker('refresh');



	function getsub(element) {
		var selectedValues = $(element).val();
		var EmpID = $('#EmpID').val();

		$("#GetSubject").empty();

		$("#GetSubject").selectpicker("refresh");

		$.ajax({
			type: "GET",
			url: "/admin/user_permission/get_subject",
			data: {
				rowLevelId: selectedValues,
				EmpID: EmpID
			},
			success: function(data) {
				if (data.length > 0) {
					$("#GetSubject").append(data);
				} else {}

				$("#GetSubject").selectpicker("refresh");
				console.log(data);
			},
			error: function() {}
		});
	}
	$(document).ready(function() {
		getsub(document.getElementById('getsub'));
	});


	function GetSubject() {
		var selectedRowLevelId = id;


	}
</script>