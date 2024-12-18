<link rel="stylesheet" href="<?php echo base_url() ?>assets/new/css/bootstrap-select22.css">
<script src="<?php echo base_url() ?>assets/new/js/bootstrap-select22.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dataTable/dataTables.bootstrap.css">
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/dataTable/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.js"></script>
<script type="text/javascript" language="javascript" class="init">
	$(function() {
		$('#example').dataTable();
	});
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/datatables.min.css" />

<script type="text/javascript" src="<?php echo base_url(); ?>js/datatables.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#employee_grid').DataTable({
			"dom": 'lBfrtip',
			"buttons": [{
				extend: 'collection',
				text: 'Export',
				buttons: [
					'copy',
					'excel',
					'print'
				]
			}]
		});
	});
</script>

<script type="text/javascript" language="javascript" class="init">
	$(function() {
		$('#example').dataTable();
	});
</script>
<?php

$get_api_setting = $this->setting_model->get_api_setting();
$this->ApiDbname = $get_api_setting[0]->{'ApiDbname'};
$ApiDbname

?>
<script type="text/javascript">
	function check_type(CheckType) {
		if (CheckType == 1) {
			$("#level_div").show();
			$("#row_div").hide();
			$("#class_div").hide();
			$("#subject_div").hide();
		} else if (CheckType == 2) {
			$("#level_div").hide();
			$("#row_div").show();
			$("#class_div").hide();
			$("#subject_div").hide();
		} else if (CheckType == 3) {
			$("#level_div").hide();
			$("#row_div").hide();
			$("#class_div").show();
			$("#subject_div").hide();
		} else if (CheckType == 4) {

			$("#level_div").hide();
			$("#row_div").hide();
			$("#class_div").hide();
			$("#subject_div").show();
			$('#form-grop').hide();

		}

	}

	function check_sub() {
		$("#GetBranches").val($("#Branches").val());
		$("#GetClassType").val($("#class_type").val());
		$("#GetStudyType").val($("#study_type").val());
		$("#Getreq_type").val($("#req_type").val());
		$("#Getcategory").val($("#category").val());
		if ($("#Branches").val() == null) {

			alert("<?= lang("br_error_permission") ?>");
			return false;
		}
		<?php if (($this->ApiDbname  != "ksiscs")) { ?>
			if ($("#class_type").val() == null) {

				alert("<?= lang("br_error_permission") ?>");
				return false;
			}
		<?php } ?>
		var RadioChecked = $("input[name=type]:checked").val();

	
			$("#PerType").val($("#level").val());
			if ($("#level").val() == null) {
				alert("<?= lang("br_error_permission") ?>");
				return false;
			}
	

	

	

		

		var EmpID = $('#EmpID').val();
		var Branches = $('#GetBranches').val();
		var req_type = $('#Getreq_type').val();
		var category = $('#Getcategory').val();
		var Type = RadioChecked;
		var PerType = $('#PerType').val();
		var GroupID = $('#GroupID').val();
		var reg_type = $('#reg_type').val();
		var class_type = $('#GetClassType').val();
		var study_type = $('#GetStudyType').val();

		var data = {
			EmpID: EmpID,
			Branches: Branches,
			Type: Type,
			PerType: PerType,
			GroupID: GroupID,
			reg_type: reg_type,
			req_type: req_type,
			category: category,
			class_type: class_type,
			study_type: study_type
		};
		$.ajax({

			type: "POST", 
			url: "<?php echo site_url('admin/user_permission/add_group_emp') ?>",
			data: data,
			cache: false,
			beforeSend: function() {},
			success: function(html) {

				$("#msg_check").html(html);

				$('#smallModal').delay(1000).fadeOut(450);
				setTimeout(function() {
					$('#smallModal').modal("hide");
				}, 1500);

				alert('<?= lang('am_op_suc'); ?>');
				location.reload();

			},
			error: function(jqXHR, exception) {
				alert("Error Handling");
			}
		}); /////END AJAX
	}
</script>
<div class="modal modal_st fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">
					<div id="msg_check"></div>
				</h4>
				<br />
			</div>
			<div class="modal-body">
				<div id="get_per_emp"></div>
				<div class="clearfix"></div>
				<div class="modal-footer">
					<input type="hidden" id="EmpID" value="0" />
					<input type="hidden" id="GroupID" value="<?= $GroupID ?>" />
					<input type="hidden" id="PerType" value="" />
					<input type="hidden" id="GetBranches" value="" />
					<input type="hidden" id="Getreq_type" value="" />
					<input type="hidden" id="Getcategory" value="" />
					<input type="hidden" id="GetClassType" value="" />
					<input type="hidden" id="GetStudyType" value="" />
					<input type="submit" class="btn btn-success" value="<?php echo lang('br_save'); ?>" onclick="return check_sub();" />

				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function add_per(EmpID) {
		if (EmpID != 0) {
			$("#msg_check").html("");
			$('#EmpID').val(EmpID);
			$('#smallModal').modal('show');
			var EmpID = $('#EmpID').val();
			var GroupID = $('#GroupID').val();
			var data = {
				EmpID: EmpID,
				GroupID: GroupID
			};
			$.ajax({

				type: "POST",
				url: "<?php echo site_url('admin/user_permission/check_emp_permission') ?>",
				data: data,
				cache: false,
				beforeSend: function() {},
				success: function(html) {

					$("#get_per_emp").html(html);


				},
				error: function(jqXHR, exception) {
					alert("Error Handling");
				}
			}); /////END AJAX
		}
	}

	function remove_per(EmpID) {
		if (EmpID != 0) {
			var result = confirm(" هل تريد إتمام عملية الحذف؟");
			if (result) {
				var data = {
					EmpID: EmpID
				};
				$.ajax({

					type: "POST",
					url: "<?php echo site_url('admin/user_permission/remove_emp_permission') ?>",
					data: data,
					cache: false,
					beforeSend: function() {},
					success: function(html) {


						alert('<?= lang('am_delete_suc'); ?>');
						location.reload();


					},
					error: function(jqXHR, exception) {
						alert("Error Handling");
					}
				}); /////END AJAX
			}
		}
	}
</script>

<div class="content margin-top-none container-page">
	<div class="col-lg-12">
		<div class="block-st">
			<div class="sec-title">
				<h2>

					<?php echo lang('br_add_emp_group') . '&nbsp;-&nbsp;' . $GetGroup['Name'] ?>
				</h2>

			</div>
			<?php
			if ($this->session->flashdata('Sucsess')) {
			?>
				<div class="widget-content">
					<div class="widget-box">
						<div class="alert alert-success fade in">
							<button data-dismiss="alert" class="close" type="button">×</button>
							<?php
							echo $this->session->flashdata('Sucsess');
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

			<div class="clearfix"></div>
			<div class="panel panel-danger">

				<div class="panel-body no-padding">

					<div id="form-grop" class="form-group col-lg-6">
						<label for="multiple-label-example " class="label-control col-lg-2"><?php echo lang('br_Name'); ?></label>
						<div class="col-lg-8">
							<select onChange="add_per(this.value);" data-placeholder="<?php echo lang('br_Name'); ?>" class="selectpicker form-control" data-live-search="true" tabindex="18" name="level[]" id="level">
								<option value="0"><?php echo lang('br_Name'); ?></option>
								<?php


								if ($GetAllEmp) {
									foreach ($GetAllEmp as $Key => $Row) {
										$ID    = $Row->ID;
										$Name  = $Row->Name;
										$GetEmpData = $this->db->query("SELECT permission_group.Name , contact.GroupID FROM contact LEFT JOIN permission_group ON contact.GroupID =  permission_group.ID  WHERE contact.ID = '" . $ID . "' LIMIT 1 ")->row_array();
										if ($GroupID != $GetEmpData['GroupID']) {
								?>
											<option value="<?php echo $ID; ?>">
												<?php echo $Name . '&nbsp;&nbsp;&nbsp;' . $GetEmpData['Name']; ?></option>
								<?php
										}
									}
								}

								?>
							</select>
						</div>
					</div>

					<?php
					if ($GroupID  != 0) {

						if ($GetAllEmp) {
					?>
							<table id="employee_grid" class="display table table-bordered" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th><?php echo lang('br_Name'); ?></th>
										<th style="text-align: center !important;"><?php echo lang('class_type') ?></th>
										<th><?php echo lang('am_edit'); ?></th>
										<th><?php echo lang('am_delete'); ?></th>
										<th><?php echo lang('br_group'); ?></th>
										<th><?php echo lang('br_Branche'); ?></th>
										<?php if ($GroupID  == 24 || $GroupID  == 98) { ?>
											<th>النوع </th>
										<?php } ?>
									
										<th><?php echo lang('br_EmpType'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$Lang           = $this->session->userdata('language');

									$SchoolName = 'SchoolName';
									if ($Lang == 'english') {
										$SchoolName = 'SchoolNameEn';
									}
									foreach ($GetAllEmp as $Key => $Row) {
										$ID    = $Row->ID;
										$Name  = $Row->Name;

									

										$GetEmpData = $this->db->query("SELECT permission_group.Name,permission_request.Level , contact.GroupID ,permission_request.school_id  ,name_space.Name as reg_name,permission_request.ClassType
                                				  FROM contact 
                                				  LEFT JOIN permission_group ON contact.GroupID =  permission_group.ID 
                                				  LEFT JOIN employee on employee.Contact_ID =contact.ID
                                				  LEFT JOIN permission_request on contact.ID =permission_request.EmpID
                                				  LEFT JOIN name_space  on permission_request.NameSpaceID =name_space.ID
                                				  WHERE contact.ID = '" . $ID . "' LIMIT 1 ")->row_array();
									 // print_r($GetEmpData);die;
										if ($GroupID == $GetEmpData['GroupID']) {



									?>
											<tr>
												<td>
													<?php echo $Name ?>
												</td>
												<td>
													<?php
													if ($GetClassType) {
														foreach ($GetClassType as $Key => $val) {
															$ClassTypeId   = $val->ClassTypeId;
															$Name = $val->ClassTypeName;
															$ClassType_array = explode(",", $GetEmpData['ClassType']);
															if (in_array($ClassTypeId, $ClassType_array)) {
																echo $Name . ",";
															}
														}
													} ?>
												</td>
												<td>
													<button onclick="add_per('<?= $ID; ?>')" class="fa fa-edit btn btn-success btn-rounded">
														<?php echo lang('am_edit') ?>
													</button>
												</td>
												<td>
													<button onclick="remove_per('<?= $ID; ?>')" class="fa fa-trash-o btn btn-danger btn-rounded">
														<?php echo lang('am_delete') ?>
													</button>
												</td>
												<td>
													<?php echo $GetEmpData['Name'] ?>
												</td>
												<td>
														<?php
													if ($get_schools) {
														foreach ($get_schools as $Key => $val) {
															$SchoolId  = $val->SchoolId;
															$SchoolName = $val->SchoolName;
															$school_id_array = explode(",", $GetEmpData['school_id']);
															if (in_array($SchoolId, $school_id_array)) {
																echo $SchoolName . ",";
															}
														}
													} ?>
												</td>
												<?php if ($GroupID == 24 || $GroupID  == 98) { ?>

													<td><?= $GetEmpData['reg_name']; ?> </td>
												<?php }
												 ?>
												<td>
													<div class="list-group">
														<?php
														$PerType = explode(',', $GetEmpData['Level']); ?>

														
																<li class="list-group-item  active "><?php echo  lang("am_level") ; ?> </li>
																<?php 

																if ($row_level) {
																	foreach ($row_level as $Key => $Level) {
																		$ID_Level   = $Level->LevelId;
																		$Name_Level = $Level->LevelName;
																		if (in_array($ID_Level, $PerType)) {
																			echo  '<li class="list-group-item ">' . $Name_Level . '</li>';
																		}
																	}
																}


														
														?>
													</div>
												</td>
											</tr>
									<?php
										}
									}
									?>
								</tbody>
							</table>

					<?php
						}
					}
					?>
				</div>
			</div>

		</div>


		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
</div>

<script>
function gradeFeltar(){
	$('#form-grop').hide();

}
</script>