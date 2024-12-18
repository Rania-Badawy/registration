<?php
    $url1=$_SERVER['REQUEST_URI'];
    header("Refresh: 50; URL=$url1");
?>

<div class="page-head container-fluid pt30">
                    <!-- Breadcrumb -->
                    <div class="breadcrumb">
                        <a href="<?php echo site_url('/student/cpanel/main_page');?>" class="ti-x fas fa-home"><?php echo lang('er_main');?></a>
                        <a href="<?php echo site_url('/student/answer_exam/answer_exam_header').'/'.$exam_details[0]->subject_id;?>"><?php echo lang('Exams');?></a>
                        <span><?php echo $exam_details[0]->sub_name; ?> </span>
                    </div>
                    <!-- Title -->
                    <h1><?php if($type == 0 ){ echo lang('Exams');}elseif($type == 1){echo lang('am_homework');}else{echo lang('na_eval_exam');}?> : <?php echo $exam_details[0]->SubjectName; ?> </h1>
                </div>
             <form action="<?php echo site_url('student/answer_exam/answer_exam_header/'.$subjectID."/".$type); ?>" method="post">
               <div class="dt-filters-btn container-fluid row flexbox form-ui">
                    <div class="col-12 col-m-4 col-l-3 no-padding">
                        <select id="select_semester" name="select_semester">
                            <option value="0"><?php echo lang('ra_Choose_semester'); ?></option>
                            <?php
                            foreach($Semesters as $key=>$RowSemester)
                            {
                                $ID             = $RowSemester->ID;
                                if($this->session->userdata('language') == arabic){
                                $Name           = $RowSemester->Name;}else{
                                $Name           = $RowSemester->Name_en;}
                                $SemesterActive = (int)$this->session->userdata('SemesterActive');
                                
                              
                             ?>
                              
                              <option value="<?php echo $ID ?>"<?php if($SemesterID == $ID ){echo 'selected';}; ?>><?php echo $Name ?></option>
                             <?php	
                            }
                             ?>
                    </select>
                    </div>
                     <div class="col-12 col-m-4 col-l-2" >
                             <button type="submit"  class="btn green-bg block-lvl" ><?php echo lang('am_view'); ?></button>
                      </div>
                           
                </div>
                 </form>
                 <?php
                $query = $this->db->query("SELECT exam_result,appear_exam_result_after FROM config_emp_school WHERE schoolID = '".$this->session->userdata('SchoolID')."'  ")->row_array();
                if(sizeof($query) > 0 ){$exam_result =  $query['exam_result']; $appear_exam_result_after =  $query['appear_exam_result_after'];  }
                ?>
                <!-- Data Table -->
                <div class="container-fluid responsive-sm-table white-bg padding-all-20 mb0">
                    <table class="table bordered-y data-table white-bg medium-spaces" data-items="6">
                        <!-- Table Head -->
                        <thead>
                            <tr class="orange-bg">
                                <th class="width-50 tx-align-center hide-sort-arrow">#</th>
                                  <th><?php echo lang('Exam_Name'); ?></th>
                                  <th><?php echo lang('br_emp');?></th>
                                  <th><?php echo lang('Time'); ?></th>
                                  <th><?php echo lang('br_from'); ?></th>
                                  <th><?php echo lang('br_to'); ?></th>
                                 <?php if($exam_result==1){?>
                                 <th><?php echo lang('test_student_degree')  ; ?></th>
                                 <?php }?>
                                <th><?php echo   lang('test_degree'); ?></th>
                                <th class="tx-align-center width-140 hide-sort-arrow"><?php echo lang('answer_exam'); ?></th>
                                <th><?= lang('am_model_answer'); ?></th>

                            </tr>
                        </thead>
                        <?php  
        
                            foreach($exam_details as $key=>$row){
                                $key                  = $key+1;
				                $testID              = $row->test_ID;
			                	$test_Name            = $row->test_Name;
				                $test_Description     = $row->test_Description;
				                $time_count           = $row->time_count;
				                $teacher_Name         = $row->teacher_Name;
				                $teacherName          = $this->db->query("select Name from contact where ID IN (".$teacher_Name.")")->result();
				                $subject_Name         = $row->subject_Name;
				                $config_semester_Name = $row->config_semester_Name;
				                $row_level_Name       = $row->row_level_Name;
				                $date_from            = $row->date_from;
				                $date_to              = $row->date_to;
				                $num_student          = $row->num_student;
				                $teacher              = $row->teacher ;
				                if($num_student){$num_student=explode(",", $num_student);}
		    	                $student_id           =(int)$this->session->userdata('id');
		    	                $answer               = $this->answer_exam_model->answer_exam($testID,$student_id); // if student answer
		    	                $answer2              = $this->answer_exam_model->answer_exam2($testID,$student_id); // if  repeat exam
			                    $sumDegree            = $this->answer_exam_model->get_sum_degree($testID);
			                    extract($sumDegree);
		
			                ?>
                    <tbody>
                          <tr >
                            <td><?php  echo $key;?></td>
                            <td><?php  echo $test_Name;?></td>
                            <td><?php echo $teacher; ?></td>
                            <td><?php  echo $time_count/60;?> <?php echo "دقائق "?></td>
                            <td><?php  echo $date_from;?></td>
                            <td><?php  echo $date_to;?></td>
                              <?php if($exam_result==1){?>
                            <td>
                               <?php if($appear_exam_result_after==0){?>
            
                             <?php if(!$answer){echo lang('not_answer_Exam');}else{echo round($SumDegreeSt,1);}?>
                              <?php }else{?>
                               <?php
                              $appear_exam_result_after1=$appear_exam_result_after*60;
                              $effectiveDate= strtotime("+".$appear_exam_result_after1." minutes", strtotime($date_to));
                               $appear_date= date("Y-m-d H:i:s",$effectiveDate);
                              if($date>$appear_date){
                              if(!$answer){echo lang('not_answer_Exam');}else{echo round($SumDegreeSt,1);} ?> 
                              <?php }}?> </td>
                             <?php }?>
                           <td><?php echo $SumDegreeQ?></td>
                              <?php if(in_array ($student_id,$num_student)){ ?>
                           <td >
                              
                                <a id="time" data-examid='<?=$testID?>' class="btn small primary block-lvl rounded btn-icon-after " title="Edit" <?php if(!$answer){ ?>href="<?php echo site_url('student/answer_exam/show_exam/'.$subjectID."/".$type."/".$testID."/".$task )?>"<?php }else{if(($answer2['is_updated']!=1) && $answer){?>href="<?php echo site_url('student/answer_exam/show_exam/'.$subjectID."/".$type."/".$testID."/".$task )?>"<?php }else{echo "disabled";}}?>   >
                                  <?php echo lang('answer_exam'); ?> 
                                </a>
                                
                           </td>
                           <td>
                           <a class="btn small success block-lvl rounded btn-icon-after " title="Show" <?php if($answer){ ?>href="<?php echo site_url("student/answer_exam/exam_report/show//0/0/all/0/".$testID )?>"<?php }else{echo "disabled";}?>  >
                           <?= lang('am_model_answer'); ?> 
                                </a>
                           </td>
        
                           <?php }else{ ?>
                           <?php
                             $startTime = $date;
                             if($startTime>=$date_from&&$startTime <= $date_to){
                                $Intime='true';  
                             }else{$Intime='false';  }
                           ?>
                          <td>
                           <a id="time" data-examid='<?=$testID?>' class="btn small primary block-lvl rounded btn-icon-after " <?php if(!$answer&& $Intime=='true'){ ?>href="<?php echo site_url('student/answer_exam/show_exam/'.$subjectID."/".$type."/".$testID."/".$task)?>"<?php }else{echo "disabled";};?> title="Edit"  >
                              <?php echo lang('answer_exam'); ?> 
                           </a>
                           
                         </td>
                         <td>
                           <a class="btn small success block-lvl rounded btn-icon-after " title="Show" <?php if($answer){ ?>href="<?php echo site_url("student/answer_exam/exam_report/show//0/0/all/0/".$testID )?>"<?php }else{echo "disabled";}?>  >
                           <?= lang('am_model_answer'); ?> 
                                </a>
                           </td>
                      </tr>
                   </tbody>
               <?php }}?>
              </table>		     
                </div>
                <!-- // Data Table -->
            