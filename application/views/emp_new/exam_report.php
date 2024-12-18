<style>
    #DayDateTo:invalid {
  color: red;
}
</style>

                <!-- Page Head -->
                <div class="page-head blue container-fluid pt30">
                    <!-- Breadcrumb -->
                    <div class="breadcrumb">
                        <a href="<?php echo site_url('emp/cpanel') ?>" class="ti-x fas fa-home"><?php echo lang('er_main');?></a>
                        <a href="#"><?php echo lang('br_report');?></a>
                        <a href="#"><?php echo lang('exam_report');?></a>
                    </div>
                    <!-- Title -->
                    <h1><?php echo lang('exam_report'); ?></h1>
                </div>
                <!-- // Page Head -->

                <!-- Page Content -->
                <div class="white-bg padding-all-20 mb0">
                    <div class="container form-ui">
                        <form action="<?php echo site_url('emp/report/exam_report/'."show"); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?= $RowLevelID ?>" name="RowLevelID">
                            <input type="hidden" value="<?= $SubjectID ?>" name="SubjectID">
                        <!-- Grid -->
                        <div class="row">
                            <!-- Form Control -->
                            <div class="col-12 col-m-6 col-l-4">
                                <label for="" class="mb10 strong-weight"><?php echo lang('am_from'); ?></label>
                                <div class="control-icon floating-end">
                                    <input type="date" name="DayDateFrom" id="DayDateFrom" placeholder="<?php echo lang('am_date'); ?>" value="<?php echo $from;?>" autocomplete="off">
                                </div>
                            </div>
                            <!-- Form Control -->
                            <div class="col-12 col-m-6 col-l-4">
                                <label for="" class="mb10 strong-weight"><?php echo lang('am_to'); ?></label>
                                <div class="control-icon floating-end">
                                    <input type="date" name="DayDateTo" min="" id="DayDateTo" placeholder="<?php echo lang('am_date'); ?>" value="<?php echo $to;?>" autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="col-12 col-m-6 col-l-4">
                                <label for="" class="mb10 strong-weight"><?php echo lang('br_level'); ?></label>
                                <select data-live-search="true" tabindex="18" name="level_id" id="level_id">
                                        <option value="0"><?php echo lang('br_check_all'); ?></option>
                                        <?php
						                if ($all_row_level) {
							                 foreach ($all_row_level as $Key => $rol) {
						    	              $ID   = $rol->level_ID;
								              $Name       = $rol->LevelName;
								             
						                ?>
								    <option value="<?php echo $ID; ?>" <?php if ($level_id == $ID) {echo 'selected';} ?>><?php echo $Name; ?></option>
						         <?php
							         }
						         }
						         ?>
                                </select>
                            </div>
                            <!-- Form Control -->
                            <div class="col-12 col-m-6 col-l-4">
                                <label for="" class="mb10 strong-weight"><?php echo lang('br_subjects'); ?></label>
                                <select name="subject_id" id="subject_id">
			                            <option value="0"><?php echo lang('br_check_all'); ?></option>
			                            <?php
						                  if ($all_subject) {
							                foreach ($all_subject as $Key => $sub) {
								                 $ID   = $sub->SubjectID;
								                 $Name = $sub->SubjectName;
						                 ?>
								<option value="<?php echo $ID; ?>" <?php if ($subjectID == $ID) {echo 'selected';} ?>><?php echo $Name; ?></option>
						               <?php }}?>
                                 </select>
                            </div>
                            <!-- // Form Control -->

                            <!-- Button -->
                            <div class="col-auto mxw-120 ms-auto">
                                <button type="submit" class="btn blue-bg block-lvl"><?php echo lang('br_page_view');?></button>
                            </div>
                            </form>
                        </div>
                        <!-- Grid -->
                    </div>
                </div>
                <!-- // Page Content -->
                <!-- Data Table -->
                <?php
			    if (is_array($homework_report)) {
				if ($show != NULL) {
			    ?>
                <h3 style="color:#a81129"><?php echo lang('am_homework'); ?></h3>
                
                
                <div class="container-fluid responsive-sm-table white-bg padding-all-20 mb0">
                    <table class="table bordered-y data-table white-bg medium-spaces data-table-ex" data-items="7">
                        <!-- Table Head -->
                        <thead>
                            <tr class="blue-bg">
                                <th class="width-50 tx-align-center hide-sort-arrow">#</th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('am_homework'); ?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('am_date'); ?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('am_Subject'); ?> / <?php echo lang('br_row_level') ; ?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('teacher_name'); ?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('degree_assignment'); ?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('answer_modal'); ?></th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            <!-- Row -->
                            <?php
									foreach ($homework_report as $Key => $row) {
									    $Num             = $Key + 1;
									    
									    $test_ID         = $row->ID;
										
										$homework_name   = $row->Name;
										
										$test_degree     = $row->SumDegreeQ;
										
										$Level_Name      = $row->Level_Name;
										
									    $Row_Name        = $row->Row_Name;
										
										$subject_Name    = $row->subject_Name;
										
										$teacherName     = $row->teacherName;
										
										$Date_Stm        = $row->date_from;
										
										if($Degree<($questionDegree/2)){
										    $faield_style_status=1;
										}
									?>
                            <tr>
                                            <td class="tx-align-center"><?php echo $Num; ?></td>
											
											<td class="tx-align-center"><?= $homework_name ?></td>
											
											<td class="tx-align-center"><?= $Date_Stm ?></td>
											
											<td class="tx-align-center"> <?= $Level_Name ." ".$Row_Name ." ".$subject_Name ?></td>
											
											<td class="tx-align-center"><?= $teacherName ?>	</td>
											
											<td class="tx-align-center"><?= $test_degree ?></td>
											
											<td class="tx-align-center"><a target="_blank" href="<?php echo site_url('emp/report/exam_report_detils/show/'.$test_ID )?>"><?php echo lang('answer_modal'); ?></a>
                            </tr>
                            <!-- // Row -->
                                     <!-- // Table Body -->
                        <?php
                }
                ?>
                        </tbody>
               
                    </table>
                </div>
                <?php }} 
                else { ?>
                <h3 style="color:#a81129"><?php echo lang('am_homework'); ?></h3>
				<div class="alert alert-danger"><?php echo lang('Not_exit'); ?> </div>
			    <?php } ?>
                <!-- // Data Table -->
                
                <!-- Data Table -->
                <?php
			    if (is_array($exam_report)) {
				if ($show != NULL) {
			    ?>
                <h1 style="color:#a81129"><?php echo lang('Exams'); ?></h1>
                
                <div class="container-fluid responsive-sm-table white-bg padding-all-20 mb0">
                    <table class="table bordered-y data-table white-bg medium-spaces data-table-ex" data-items="7">
                        <!-- Table Head -->
                        <thead>
                            <tr class="blue-bg">
                                <th class="width-50 tx-align-center hide-sort-arrow">#</th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('br_exam'); ?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('am_date'); ?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('am_Subject'); ?> / <?php echo lang('br_row_level') ; ?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('teacher_name'); ?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('exam_mark'); ?></th>
                                <th class="tx-align-center hide-sort-arrow" ><?php echo lang('answer_modal'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                        <!-- Table Body -->
                        <?php
									foreach ($exam_report as $Key => $row) {
									    
										$Num             = $Key + 1;
										
										$test_ID         = $row->ID;
										
										$homework_name   = $row->Name;
									    $Level_Name      = $row->Level_Name;
									    $Row_Name      = $row->Row_Name;
										$test_degree     = $row->SumDegreeQ;
										
										$subject_Name    = $row->subject_Name;
										
										$teacherName     = $row->teacherName;
										
										$Date_Stm        = $row->date_from;

									?>
                            <!-- Row -->
                            <tr>
                                <td class="tx-align-center"><?php echo $Num; ?></td>
											
											<td class="tx-align-center"><?= $homework_name ?></td>
											
											<td class="tx-align-center"><?= $Date_Stm ?></td>
											
											<td class="tx-align-center" > <?= $Level_Name ." ".$Row_Name ." ".$subject_Name ?></td>
											
											<td class="tx-align-center" ><?= $teacherName ?>	</td>
											
											<td class="tx-align-center" ><?= $test_degree ?></td>
											
											<td class="tx-align-center "><a target="_blank" href="<?php echo site_url('emp/report/exam_report_detils/show/'.$test_ID )?>"><?php echo lang('answer_modal'); ?> </a>
                            </tr>
                            <!-- // Row -->
                        
                        <!-- // Table Body -->
                        <?php
                }
                ?>
                </tbody>
                    </table>
                </div>
                <?php }} 
                else { ?>
                <h1 style="color:#a81129 "><?php echo lang('Exams'); ?></h1>
				<div class="alert alert-danger"><?php echo lang('Not_exit'); ?> </div>
			    <?php } ?>
                <!-- // Data Table -->
                
                <script>
    var checkIn = document.getElementById('DayDateFrom');
var checkOut = document.getElementById('DayDateTo');

checkIn.addEventListener('change', updatedate);

function updatedate() {
    var firstdate = checkIn.value;
    checkOut.min = firstdate;
}
</script>
           